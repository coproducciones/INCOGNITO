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
    public function __construct(
        private PedidoRepository $pedidos,
        private PedidoEventoRepository $eventos,
        private DetallePedidoService $detalles,
    ) {}

    /**
     * Crea un nuevo pedido.
     */
    public function crear(array $data): Pedido
    {
        return DB::transaction(function () use ($data) {

            /*
             * 1. Buscar el estado inicial.
             */
            $estado = $this->estadoPedido('Pendiente');

            /*
             * 2. Crear el pedido.
             */
            $pedido = $this->pedidos->create([
                'id_usuario' => (int) $data['id_usuario'],
                'total' => 0,
                'id_estado' => $estado->id_estado,
                'fecha_pedido' => now(),
            ]);

            /*
             * 3. Registrar el primer evento.
             */
            $this->eventos->create([
                'id_pedido' => $pedido->id_pedido,
                'id_estado' => $estado->id_estado,
                'tipo_evento' => 'CREADO',
                'comentario' => 'Pedido creado.',
                'fecha' => now(),
            ]);

            /*
             * 4. Devolver solamente el pedido recién creado.
             *
             * No hacemos fresh() ni cargamos todas las relaciones
             * durante la transacción.
             */
            return $pedido;
        });
    }

    /**
     * Agrega un detalle al pedido.
     */
    public function agregarDetalle(
        Pedido $pedido,
        array $data
    ): Pedido {
        return DB::transaction(function () use (
            $pedido,
            $data
        ) {

            $this->validarEditable($pedido);

            $this->detalles->agregar(
                $pedido,
                $data
            );

            return $this->pedidos
                ->recalculateTotal($pedido)
                ->load([
                    'detalles.producto',
                    'estado'
                ]);
        });
    }

    /**
     * Modifica un detalle.
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

            $this->validarEditable($pedido);

            $this->detalles->modificar(
                $pedido,
                $detalleId,
                $data
            );

            return $this->pedidos
                ->recalculateTotal($pedido)
                ->load([
                    'detalles.producto',
                    'estado'
                ]);
        });
    }

    /**
     * Elimina un detalle.
     */
    public function eliminarDetalle(
        Pedido $pedido,
        int $detalleId
    ): Pedido {
        return DB::transaction(function () use (
            $pedido,
            $detalleId
        ) {

            $this->validarEditable($pedido);

            $this->detalles->eliminar(
                $pedido,
                $detalleId
            );

            return $this->pedidos
                ->recalculateTotal($pedido)
                ->load([
                    'detalles.producto',
                    'estado'
                ]);
        });
    }

    /**
     * Cambia el estado del pedido.
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

            $estado = EstadoGeneral::findOrFail(
                $estadoId
            );

            if (
                (int) $pedido->id_estado ===
                (int) $estado->id_estado
            ) {
                throw ValidationException::withMessages([
                    'id_estado' =>
                        'El pedido ya tiene este estado.'
                ]);
            }

            $this->pedidos->update(
                $pedido,
                [
                    'id_estado' => $estado->id_estado
                ]
            );

            $this->eventos->create([
                'id_pedido' => $pedido->id_pedido,
                'id_estado' => $estado->id_estado,
                'tipo_evento' => 'CAMBIO_ESTADO',
                'comentario' => $comentario,
                'fecha' => now(),
            ]);

            return $pedido->fresh([
                'usuario',
                'estado',
                'detalles.producto',
                'eventos.estado'
            ]);
        });
    }

    /**
     * Registra un evento manual.
     */
    public function registrarEvento(
        Pedido $pedido,
        array $data
    ): void {
        $this->eventos->create([
            'id_pedido' => $pedido->id_pedido,
            'id_estado' => $data['id_estado'] ?? null,
            'tipo_evento' => $data['tipo_evento'],
            'comentario' => $data['comentario'] ?? null,
            'fecha' => now(),
        ]);
    }

    /**
     * Verifica si el pedido permite modificaciones.
     */
    private function validarEditable(
        Pedido $pedido
    ): void {

        $bloqueados = [
            'Cancelado',
            'Completado',
        ];

        if (
            in_array(
                $pedido->estado?->nombre,
                $bloqueados,
                true
            )
        ) {
            throw ValidationException::withMessages([
                'pedido' =>
                    'El pedido no permite modificaciones en su estado actual.'
            ]);
        }
    }

    /**
     * Obtiene un estado de tipo PEDIDO.
     */
    private function estadoPedido(
        string $nombre
    ): EstadoGeneral {

        $estado = EstadoGeneral::where(
            'tipo',
            'PEDIDO'
        )
            ->where(
                'nombre',
                $nombre
            )
            ->first();

        if (!$estado) {
            throw new \RuntimeException(
                "No existe el estado '{$nombre}' de tipo 'PEDIDO' en la tabla estado_general."
            );
        }

        return $estado;
    }
}