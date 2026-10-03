<?php

namespace App\Services;

use App\Models\EstadoGeneral;
use App\Models\Pedido;
use App\Repositories\PedidoEventoRepository;
use App\Repositories\PedidoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PedidoService
{
    /*
     * =========================================================
     * DEPENDENCIAS
     * =========================================================
     */

    public function __construct(
        private PedidoRepository $pedidos,
        private PedidoEventoRepository $eventos,
        private DetallePedidoService $detalles,
    ) {}


    /*
     * =========================================================
     * CREAR PEDIDO
     * =========================================================
     *
     * Crea:
     *
     * 1. Pedido.
     * 2. Estado Pendiente.
     * 3. Evento de creación.
     * 4. Productos.
     * 5. Total.
     *
     * Todo dentro de una transacción.
     */

    public function crear(array $data): Pedido
    {
        return DB::transaction(function () use ($data) {

            /*
             * Obtenemos el estado inicial.
             */

            $estado = $this->estadoPedido(
                'Pendiente'
            );


            /*
             * Creamos el pedido.
             */

            $pedido = $this->pedidos->create([
                'id_usuario' => (int) $data['id_usuario'],

                'total' => 0,

                'id_estado' => $estado->id_estado,

                'fecha_pedido' => now(),
            ]);


            /*
             * Registramos el evento inicial.
             */

            $this->eventos->create([
                'id_pedido' => $pedido->id_pedido,

                'id_estado' => $estado->id_estado,

                'tipo_evento' => 'CREADO',

                'comentario' => 'Pedido creado.',

                'fecha' => now(),
            ]);


            /*
             * Obtenemos los productos enviados
             * desde create.blade.php.
             */

            $productos = $data['productos'] ?? [];


            /*
             * Creamos cada detalle.
             */

            foreach ($productos as $producto) {

                $this->detalles->agregar(
                    $pedido,
                    [
                        'id_producto' =>
                            (int) $producto['id_producto'],

                        'cantidad' =>
                            (int) $producto['cantidad'],
                    ]
                );
            }


            /*
             * Recalculamos el total.
             */

            $pedido = $this->pedidos
                ->recalculateTotal($pedido);


            /*
             * Devolvemos el pedido completo.
             */

            return $pedido->load([
                'usuario',
                'estado',
                'detalles.producto.categoria',
                'eventos.estado',
            ]);
        });
    }


    /*
     * =========================================================
     * AGREGAR PRODUCTO
     * =========================================================
     */

    public function agregarDetalle(
        Pedido $pedido,
        array $data
    ): Pedido {

        return DB::transaction(function () use (
            $pedido,
            $data
        ) {

            /*
             * Primero verificamos el estado REAL
             * del pedido en la base de datos.
             */

            $this->validarEditable(
                $pedido
            );


            /*
             * Agregamos el producto.
             */

            $this->detalles->agregar(
                $pedido,
                $data
            );


            /*
             * Recalculamos el total.
             */

            return $this->pedidos
                ->recalculateTotal($pedido)
                ->load([
                    'usuario',
                    'estado',
                    'detalles.producto.categoria',
                    'eventos.estado',
                ]);
        });
    }


    /*
     * =========================================================
     * MODIFICAR PRODUCTO
     * =========================================================
     */

    public function modificarDetalle(
        Pedido $pedido,
        int $detalleId,
        array $data
    ): Pedido {

        return DB::transaction(function () use (
            $pedido,
            $detalleId,
            $data
        ) {

            /*
             * Verificamos el estado REAL.
             */

            $this->validarEditable(
                $pedido
            );


            /*
             * Modificamos el detalle.
             */

            $this->detalles->modificar(
                $pedido,
                $detalleId,
                $data
            );


            /*
             * Recalculamos el total.
             */

            return $this->pedidos
                ->recalculateTotal($pedido)
                ->load([
                    'usuario',
                    'estado',
                    'detalles.producto.categoria',
                    'eventos.estado',
                ]);
        });
    }


    /*
     * =========================================================
     * ELIMINAR PRODUCTO
     * =========================================================
     */

    public function eliminarDetalle(
        Pedido $pedido,
        int $detalleId
    ): Pedido {

        return DB::transaction(function () use (
            $pedido,
            $detalleId
        ) {

            /*
             * Verificamos el estado REAL.
             */

            $this->validarEditable(
                $pedido
            );


            /*
             * Eliminamos el detalle.
             */

            $this->detalles->eliminar(
                $pedido,
                $detalleId
            );


            /*
             * Recalculamos el total.
             */

            return $this->pedidos
                ->recalculateTotal($pedido)
                ->load([
                    'usuario',
                    'estado',
                    'detalles.producto.categoria',
                    'eventos.estado',
                ]);
        });
    }


    /*
     * =========================================================
     * CAMBIAR ESTADO
     * =========================================================
     */

    public function cambiarEstado(
        Pedido $pedido,
        int $estadoId,
        ?string $comentario = null
    ): Pedido {

        return DB::transaction(function () use (
            $pedido,
            $estadoId,
            $comentario
        ) {

            /*
             * Buscamos el nuevo estado.
             */

            $estado = EstadoGeneral::findOrFail(
                $estadoId
            );


            /*
             * El pedido no puede cambiar al mismo estado.
             */

            if (
                (int) $pedido->id_estado ===
                (int) $estado->id_estado
            ) {

                throw ValidationException::withMessages([
                    'id_estado' =>
                        'El pedido ya tiene este estado.',
                ]);
            }


            /*
             * Actualizamos el pedido.
             */

            $this->pedidos->update(
                $pedido,
                [
                    'id_estado' =>
                        $estado->id_estado,
                ]
            );


            /*
             * Registramos el cambio.
             */

            $this->eventos->create([
                'id_pedido' =>
                    $pedido->id_pedido,

                'id_estado' =>
                    $estado->id_estado,

                'tipo_evento' =>
                    'CAMBIO_ESTADO',

                'comentario' =>
                    $comentario,

                'fecha' =>
                    now(),
            ]);


            /*
             * Devolvemos el pedido actualizado.
             */

            return $pedido->fresh([
                'usuario',
                'estado',
                'detalles.producto.categoria',
                'eventos.estado',
            ]);
        });
    }


    /*
     * =========================================================
     * REGISTRAR EVENTO
     * =========================================================
     */

    public function registrarEvento(
        Pedido $pedido,
        array $data
    ): void {

        $this->eventos->create([
            'id_pedido' =>
                $pedido->id_pedido,

            'id_estado' =>
                $data['id_estado'] ?? null,

            'tipo_evento' =>
                $data['tipo_evento'],

            'comentario' =>
                $data['comentario'] ?? null,

            'fecha' =>
                now(),
        ]);
    }


    /*
     * =========================================================
     * VALIDAR PEDIDO EDITABLE
     * =========================================================
     *
     * IMPORTANTE:
     *
     * Aquí está la corrección principal.
     *
     * No confiamos únicamente en:
     *
     * $pedido->estado
     *
     * Consultamos directamente:
     *
     * estado_general.id_estado
     *
     * utilizando:
     *
     * pedido.id_estado
     */

    private function validarEditable(
        Pedido $pedido
    ): void {

        /*
         * =====================================================
         * OBTENER ESTADO DIRECTAMENTE DE LA BD
         * =====================================================
         */

        $estado = EstadoGeneral::query()
            ->where(
                'id_estado',
                $pedido->id_estado
            )
            ->where(
                'tipo',
                'PEDIDO'
            )
            ->first();


        /*
         * =====================================================
         * ESTADO NO ENCONTRADO
         * =====================================================
         *
         * Si el pedido tiene un id_estado que no existe,
         * no debemos asumir que está pendiente.
         */

        if (!$estado) {

            throw ValidationException::withMessages([
                'pedido' =>
                    "El pedido #{$pedido->id_pedido} " .
                    "tiene un estado inválido.",
            ]);
        }


        /*
         * =====================================================
         * NORMALIZAR NOMBRE
         * =====================================================
         *
         * Convierte:
         *
         * Cancelado
         * CANCELADO
         * cancelado
         *
         * en:
         *
         * cancelado
         */

        $nombreEstado = strtolower(
            trim(
                $estado->nombre
            )
        );


        /*
         * =====================================================
         * ESTADOS BLOQUEADOS
         * =====================================================
         */

        $bloqueados = [
            'cancelado',
            'completado',
        ];


        /*
         * =====================================================
         * COMPROBAR SI ESTÁ BLOQUEADO
         * =====================================================
         */

        if (
            in_array(
                $nombreEstado,
                $bloqueados,
                true
            )
        ) {

            throw ValidationException::withMessages([
                'pedido' =>
                    "El pedido #{$pedido->id_pedido} " .
                    "no permite modificaciones porque " .
                    "su estado actual es '{$estado->nombre}'.",
            ]);
        }
    }


    /*
     * =========================================================
     * OBTENER ESTADO INICIAL
     * =========================================================
     */

    private function estadoPedido(
        string $nombre
    ): EstadoGeneral {

        /*
         * Buscamos el estado exclusivamente
         * dentro del tipo PEDIDO.
         */

        $estado = EstadoGeneral::query()
            ->where(
                'tipo',
                'PEDIDO'
            )
            ->where(
                'nombre',
                $nombre
            )
            ->first();


        /*
         * Si no existe, detenemos la creación.
         */

        if (!$estado) {

            throw new \RuntimeException(
                "No existe el estado '{$nombre}' " .
                "de tipo 'PEDIDO' en la tabla estado_general."
            );
        }


        return $estado;
    }
}