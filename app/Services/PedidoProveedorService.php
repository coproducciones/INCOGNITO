<?php

namespace App\Services;

use App\Models\EstadoGeneral;
use App\Models\Pedido;
use App\Models\PedidoProveedorEstado;
use App\Models\PedidoProveedorEvento;
use App\Models\Proveedor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Servicio encargado de administrar los pedidos
 * recibidos por cada proveedor.
 *
 * Cada proveedor trabaja únicamente con los productos
 * que le pertenecen dentro de un pedido.
 *
 * Las actualizaciones de estado son independientes
 * de las realizadas por otros proveedores.
 */
class PedidoProveedorService
{
    /**
     * Obtiene los pedidos que contienen productos
     * pertenecientes al proveedor indicado.
     *
     * También carga:
     * - El usuario que realizó el pedido.
     * - El estado general del pedido.
     * - Los detalles correspondientes al proveedor.
     * - Los productos asociados a dichos detalles.
     *
     * @param Proveedor $proveedor
     * @return LengthAwarePaginator
     */
    public function listar(
        Proveedor $proveedor
    ): LengthAwarePaginator {

        return Pedido::query()

            // Filtrar pedidos que tengan productos del proveedor.
            ->whereHas('detalles.producto', function ($query) use ($proveedor) {
                $query->where(
                    'id_proveedor',
                    $proveedor->id_proveedor
                );
            })

            // Cargar información general del pedido.
            ->with([
                'usuario',
                'estado',
            ])

            // Cargar únicamente los detalles del proveedor.
            ->with([
                'detalles' => function ($query) use ($proveedor) {

                    $query->whereHas(
                        'producto',
                        function ($producto) use ($proveedor) {

                            $producto->where(
                                'id_proveedor',
                                $proveedor->id_proveedor
                            );
                        }
                    )

                    // Cargar la información de cada producto.
                    ->with('producto');
                },
            ])

            // Mostrar primero los pedidos más recientes.
            ->orderByDesc('fecha_pedido')

            // Paginar los resultados.
            ->paginate(15);
    }

    /**
     * Obtiene el detalle de un pedido para un proveedor.
     *
     * Comprueba que el pedido tenga al menos un producto
     * perteneciente al proveedor autenticado.
     *
     * También carga:
     * - Los detalles correspondientes al proveedor.
     * - El estado individual del proveedor.
     * - El historial de eventos del proveedor.
     *
     * @param Proveedor $proveedor
     * @param int $pedidoId
     * @return Pedido
     */
    public function obtenerPedido(
        Proveedor $proveedor,
        int $pedidoId
    ): Pedido {

        // Buscar únicamente pedidos que pertenezcan al proveedor.
        $pedido = Pedido::query()

            ->whereHas('detalles.producto', function ($query) use ($proveedor) {

                $query->where(
                    'id_proveedor',
                    $proveedor->id_proveedor
                );
            })

            // Cargar información general.
            ->with([
                'usuario',
                'estado',
            ])

            // Cargar exclusivamente los productos del proveedor.
            ->with([
                'detalles' => function ($query) use ($proveedor) {

                    $query->whereHas(
                        'producto',
                        function ($producto) use ($proveedor) {

                            $producto->where(
                                'id_proveedor',
                                $proveedor->id_proveedor
                            );
                        }
                    )

                    ->with('producto');
                },
            ])

            // Si el pedido no existe o no pertenece al proveedor,
            // Laravel responderá con un error 404.
            ->findOrFail($pedidoId);

        /*
         * ----------------------------------------------------------
         * ESTADO INDIVIDUAL DEL PROVEEDOR
         * ----------------------------------------------------------
         */

        $estadoProveedor = PedidoProveedorEstado::query()
            ->with('estado')
            ->where('id_pedido', $pedido->id_pedido)
            ->where('id_proveedor', $proveedor->id_proveedor)
            ->first();

        // Agregar el estado individual a la instancia del pedido.
        $pedido->setRelation(
            'estadoProveedor',
            $estadoProveedor
        );

        /*
         * ----------------------------------------------------------
         * HISTORIAL DE EVENTOS DEL PROVEEDOR
         * ----------------------------------------------------------
         */

        $historialProveedor = PedidoProveedorEvento::query()
            ->with([
                'estado',
                'usuario',
            ])
            ->where('id_pedido', $pedido->id_pedido)
            ->where('id_proveedor', $proveedor->id_proveedor)
            ->orderByDesc('fecha')
            ->get();

        // Agregar el historial a la instancia del pedido.
        $pedido->setRelation(
            'historialProveedor',
            $historialProveedor
        );

        return $pedido;
    }

    /**
     * Actualiza el estado individual de un proveedor
     * dentro de un pedido.
     *
     * La operación se realiza dentro de una transacción
     * para mantener consistentes el estado y el historial.
     *
     * Reglas:
     * - El pedido debe contener productos del proveedor.
     * - El estado debe pertenecer al tipo PEDIDO.
     * - Solo se permiten Confirmado, En proceso y Completado.
     * - No se permite saltar etapas.
     * - No se permiten cambios si el pedido general está
     *   cancelado o completado.
     *
     * @param Proveedor $proveedor
     * @param int $pedidoId
     * @param int $estadoId
     * @param int $usuarioId
     * @param string|null $comentario
     * @return void
     */
    public function actualizarEstado(
        Proveedor $proveedor,
        int $pedidoId,
        int $estadoId,
        int $usuarioId,
        ?string $comentario = null
    ): void {

        DB::transaction(function () use (
            $proveedor,
            $pedidoId,
            $estadoId,
            $usuarioId,
            $comentario
        ) {

            /*
             * ------------------------------------------------------
             * 1. OBTENER Y BLOQUEAR EL PEDIDO
             * ------------------------------------------------------
             */

            $pedido = Pedido::query()
                ->whereKey($pedidoId)
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * ------------------------------------------------------
             * 2. COMPROBAR LA PERTENENCIA DEL PEDIDO
             * ------------------------------------------------------
             *
             * El pedido debe contener al menos un producto
             * perteneciente al proveedor autenticado.
             */

            $participa = $pedido->detalles()
                ->whereHas('producto', function ($query) use ($proveedor) {

                    $query->where(
                        'id_proveedor',
                        $proveedor->id_proveedor
                    );
                })
                ->exists();

            // Ocultar el pedido si no pertenece al proveedor.
            abort_unless($participa, 404);

            /*
             * ------------------------------------------------------
             * 3. VALIDAR EL NUEVO ESTADO
             * ------------------------------------------------------
             *
             * Los proveedores no pueden seleccionar estados
             * administrativos ni estados fuera del flujo permitido.
             */

            $estadoNuevo = EstadoGeneral::query()
                ->where('id_estado', $estadoId)
                ->where('tipo', 'PEDIDO')
                ->whereIn('nombre', [
                    'Confirmado',
                    'En proceso',
                    'Completado',
                ])
                ->first();

            if (!$estadoNuevo) {
                throw ValidationException::withMessages([
                    'id_estado' => 'El estado seleccionado no está permitido para proveedores.',
                ]);
            }

            /*
             * ------------------------------------------------------
             * 4. OBTENER EL ESTADO ACTUAL DEL PROVEEDOR
             * ------------------------------------------------------
             */

            $estadoActualRegistro = PedidoProveedorEstado::query()
                ->where('id_pedido', $pedido->id_pedido)
                ->where('id_proveedor', $proveedor->id_proveedor)
                ->lockForUpdate()
                ->first();

            // Buscar el estado inicial Pendiente.
            $estadoPendiente = EstadoGeneral::query()
                ->where('tipo', 'PEDIDO')
                ->where('nombre', 'Pendiente')
                ->first();

            if (!$estadoPendiente) {
                throw ValidationException::withMessages([
                    'pedido' => 'No existe el estado general Pendiente. Ejecuta el seeder de estados antes de continuar.',
                ]);
            }

            // Si no existe un estado individual, se considera Pendiente.
            $estadoActual = $estadoActualRegistro?->estado
                ?? $estadoPendiente;

            /*
             * ------------------------------------------------------
             * 5. VALIDAR EL FLUJO DE ESTADOS
             * ------------------------------------------------------
             *
             * Pendiente  -> Confirmado
             * Confirmado -> En proceso
             * En proceso -> Completado
             */

            $siguienteEstado = [
                'Pendiente'  => 'Confirmado',
                'Confirmado' => 'En proceso',
                'En proceso' => 'Completado',
            ];

            $esperado = $siguienteEstado[$estadoActual->nombre] ?? null;

            // Evitar saltos de estado o actualizaciones repetidas.
            if ($esperado !== $estadoNuevo->nombre) {

                throw ValidationException::withMessages([
                    'id_estado' => $esperado
                        ? "El siguiente estado permitido es {$esperado}."
                        : 'Este pedido ya alcanzó un estado final o no admite más cambios.',
                ]);
            }

            /*
             * ------------------------------------------------------
             * 6. VALIDAR EL ESTADO GENERAL DEL PEDIDO
             * ------------------------------------------------------
             *
             * Aunque el proveedor tenga un estado individual,
             * no puede actualizarlo si el pedido global ya está
             * cancelado o completado.
             */

            $estadoGeneralNombre = mb_strtolower(
                (string) $pedido->estado?->nombre
            );

            if (in_array(
                $estadoGeneralNombre,
                ['cancelado', 'completado'],
                true
            )) {

                throw ValidationException::withMessages([
                    'pedido' => 'No puedes actualizar los productos de un pedido cancelado o completado globalmente.',
                ]);
            }

            /*
             * ------------------------------------------------------
             * 7. GUARDAR EL ESTADO INDIVIDUAL
             * ------------------------------------------------------
             *
             * Se actualiza el registro existente o se crea uno nuevo.
             */

            PedidoProveedorEstado::query()->updateOrCreate(

                [
                    'id_pedido' => $pedido->id_pedido,
                    'id_proveedor' => $proveedor->id_proveedor,
                ],

                [
                    'id_estado' => $estadoNuevo->id_estado,
                    'actualizado_por' => $usuarioId,
                    'comentario' => $comentario,
                ]
            );

            /*
             * ------------------------------------------------------
             * 8. REGISTRAR EL HISTORIAL
             * ------------------------------------------------------
             *
             * Cada actualización genera un evento independiente.
             * Esto permite consultar quién realizó el cambio,
             * cuándo lo realizó y qué comentario dejó.
             */

            PedidoProveedorEvento::query()->create([

                'id_pedido' => $pedido->id_pedido,

                'id_proveedor' => $proveedor->id_proveedor,

                'id_estado' => $estadoNuevo->id_estado,

                'id_usuario' => $usuarioId,

                'tipo_evento' => 'ESTADO_ACTUALIZADO',

                'comentario' => $comentario,

                'fecha' => now(),
            ]);
        });
    }
}