<?php

namespace App\Services;

use App\Models\EstadoGeneral;
use App\Models\Pedido;
use App\Models\PedidoEvento;
use App\Models\Producto;
use App\Repositories\PedidoEventoRepository;
use App\Repositories\PedidoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\WhatsAppCloudService;
use Illuminate\Validation\ValidationException;

class PedidoService
{
    public function __construct(
        private PedidoRepository $pedidos,
        private PedidoEventoRepository $eventos,
        private DetallePedidoService $detalles,
    ) {}

    /**
     * Guarda el pedido y reserva el inventario en una transacción.
     * Después del commit intenta enviar una notificación a cada proveedor.
     * Un fallo de WhatsApp no revierte el pedido ni modifica el inventario.
     */
    public function crear(array $data): Pedido
    {
        $pedido = DB::transaction(function () use ($data) {
            $estado = $this->estadoPedido('Pendiente');

            $pedido = $this->pedidos->create([
                'id_usuario' => (int) $data['id_usuario'],
                'total' => 0,
                'id_estado' => $estado->id_estado,
                'fecha_pedido' => now(),
            ]);

            $this->eventos->create([
                'id_pedido' => $pedido->id_pedido,
                'id_estado' => $estado->id_estado,
                'tipo_evento' => 'CREADO',
                'comentario' => 'Pedido creado.',
                'fecha' => now(),
            ]);

            $productos = $data['productos'] ?? [];

            if (empty($productos)) {
                throw ValidationException::withMessages([
                    'productos' => 'No puedes crear un pedido sin productos.',
                ]);
            }

            foreach ($productos as $producto) {
                $this->detalles->agregar($pedido, [
                    'id_producto' => (int) $producto['id_producto'],
                    'cantidad' => (int) $producto['cantidad'],
                ]);
            }

            $this->reservarInventario(
                $pedido,
                'Inventario reservado al crear el pedido.'
            );

            return $this->pedidos->recalculateTotal($pedido);
        });

        return $this->recargar($pedido);
    }

    public function agregarDetalle(Pedido $pedido, array $data): Pedido
    {
        return DB::transaction(function () use ($pedido, $data) {
            $pedido = $this->pedidoBloqueado($pedido);
            $this->validarEditable($pedido);
            $this->asegurarInventarioReservado($pedido);
            $this->detalles->agregar($pedido, $data, true);

            return $this->recargar($this->pedidos->recalculateTotal($pedido));
        });
    }

    public function modificarDetalle(
        Pedido $pedido,
        int $detalleId,
        array $data
    ): Pedido {
        return DB::transaction(function () use ($pedido, $detalleId, $data) {
            $pedido = $this->pedidoBloqueado($pedido);
            $this->validarEditable($pedido);
            $this->asegurarInventarioReservado($pedido);
            $this->detalles->modificar($pedido, $detalleId, $data, true);

            return $this->recargar($this->pedidos->recalculateTotal($pedido));
        });
    }

    public function eliminarDetalle(Pedido $pedido, int $detalleId): Pedido
    {
        return DB::transaction(function () use ($pedido, $detalleId) {
            $pedido = $this->pedidoBloqueado($pedido);
            $this->validarEditable($pedido);
            $this->asegurarInventarioReservado($pedido);
            $this->detalles->eliminar($pedido, $detalleId, true);

            return $this->recargar($this->pedidos->recalculateTotal($pedido));
        });
    }

    public function cambiarEstado(
        Pedido $pedido,
        int $estadoId,
        ?string $comentario = null
    ): Pedido {
        return DB::transaction(function () use ($pedido, $estadoId, $comentario) {
            $pedido = $this->pedidoBloqueado($pedido);

            $estado = EstadoGeneral::query()
                ->where('id_estado', $estadoId)
                ->where('tipo', 'PEDIDO')
                ->firstOrFail();

            $actual = EstadoGeneral::query()
                ->where('id_estado', $pedido->id_estado)
                ->where('tipo', 'PEDIDO')
                ->first();

            if (!$actual) {
                throw ValidationException::withMessages([
                    'pedido' => 'El pedido tiene un estado actual inválido.',
                ]);
            }

            if ((int) $pedido->id_estado === (int) $estado->id_estado) {
                throw ValidationException::withMessages([
                    'id_estado' => 'El pedido ya tiene este estado.',
                ]);
            }

            $nombreActual = mb_strtolower(trim($actual->nombre));
            $nombreNuevo = mb_strtolower(trim($estado->nombre));

            if ($nombreActual === 'completado' && $nombreNuevo === 'cancelado') {
                throw ValidationException::withMessages([
                    'id_estado' => 'No se puede cancelar un pedido completado.',
                ]);
            }

            if ($nombreNuevo === 'cancelado') {
                $this->devolverInventarioSiReservado(
                    $pedido,
                    'Inventario devuelto por cancelación administrativa.'
                );
            }

            $this->pedidos->update($pedido, [
                'id_estado' => $estado->id_estado,
            ]);

            $this->eventos->create([
                'id_pedido' => $pedido->id_pedido,
                'id_estado' => $estado->id_estado,
                'tipo_evento' => 'CAMBIO_ESTADO',
                'comentario' => $comentario,
                'fecha' => now(),
            ]);

            return $pedido->fresh([
                'usuario', 'estado', 'detalles.producto.categoria',
                'eventos.estado',
            ]);
        });
    }

    public function cancelar(Pedido $pedido): Pedido
    {
        return DB::transaction(function () use ($pedido) {
            $pedido = $this->pedidoBloqueado($pedido);

            $actual = EstadoGeneral::query()
                ->where('id_estado', $pedido->id_estado)
                ->where('tipo', 'PEDIDO')
                ->first();

            if (!$actual) {
                throw ValidationException::withMessages([
                    'pedido' => 'El estado del pedido no es válido.',
                ]);
            }

            $nombre = mb_strtolower(trim($actual->nombre));

            if ($nombre === 'cancelado') {
                return $pedido->load([
                    'usuario', 'estado', 'detalles.producto.categoria',
                    'eventos.estado',
                ]);
            }

            if ($nombre !== 'pendiente') {
                throw ValidationException::withMessages([
                    'pedido' => "Solo puedes cancelar pedidos Pendientes. El estado actual es '{$actual->nombre}'.",
                ]);
            }

            $cancelado = $this->estadoPedido('Cancelado');

            $this->devolverInventarioSiReservado(
                $pedido,
                'Inventario devuelto por cancelación del usuario.'
            );

            $this->pedidos->update($pedido, [
                'id_estado' => $cancelado->id_estado,
            ]);

            $this->eventos->create([
                'id_pedido' => $pedido->id_pedido,
                'id_estado' => $cancelado->id_estado,
                'tipo_evento' => 'CANCELADO',
                'comentario' => 'Pedido cancelado por el usuario.',
                'fecha' => now(),
            ]);

            return $pedido->fresh([
                'usuario', 'estado', 'detalles.producto.categoria',
                'eventos.estado',
            ]);
        });
    }

    /**
     * Elimina físicamente pedidos pendientes o cancelados.
     */
    public function eliminarDefinitivamente(Pedido $pedido): void
    {
        DB::transaction(function () use ($pedido) {
            $pedido = $this->pedidoBloqueado($pedido);

            $estado = EstadoGeneral::query()
                ->where('id_estado', $pedido->id_estado)
                ->where('tipo', 'PEDIDO')
                ->first();

            if (!$estado) {
                throw ValidationException::withMessages([
                    'pedido' => 'El estado del pedido no es válido.',
                ]);
            }

            $nombre = mb_strtolower(trim($estado->nombre));

            if (!in_array($nombre, ['pendiente', 'cancelado'], true)) {
                throw ValidationException::withMessages([
                    'pedido' => "No se puede eliminar un pedido con estado '{$estado->nombre}'.",
                ]);
            }

            $this->devolverInventarioSiReservado(
                $pedido,
                'Inventario verificado antes de eliminar el pedido.'
            );

            $pedido->detalles()->delete();
            $pedido->eventos()->delete();
            $pedido->forceDelete();
        });
    }

    public function registrarEvento(Pedido $pedido, array $data): void
    {
        $this->eventos->create([
            'id_pedido' => $pedido->id_pedido,
            'id_estado' => $data['id_estado'] ?? null,
            'tipo_evento' => $data['tipo_evento'],
            'comentario' => $data['comentario'] ?? null,
            'fecha' => now(),
        ]);
    }

    private function pedidoBloqueado(Pedido $pedido): Pedido
    {
        return Pedido::query()
            ->where('id_pedido', $pedido->id_pedido)
            ->lockForUpdate()
            ->firstOrFail();
    }

    private function tieneInventarioReservado(Pedido $pedido): bool
    {
        return PedidoEvento::query()
            ->where('id_pedido', $pedido->id_pedido)
            ->where('tipo_evento', 'INVENTARIO_RESERVADO')
            ->exists();
    }

    private function reservarInventario(Pedido $pedido, string $comentario): void
    {
        $cantidades = $pedido->detalles()->get()
            ->groupBy('id_producto')
            ->map(fn ($lineas) => (int) $lineas->sum('cantidad'));

        $productos = Producto::query()
            ->whereIn('id', $cantidades->keys()->all())
            ->orderBy('id')
            ->lockForUpdate()
            ->get()
            ->keyBy('id');

        foreach ($cantidades as $id => $cantidad) {
            $producto = $productos->get($id);

            if (!$producto) {
                throw ValidationException::withMessages([
                    'productos' => "El producto #{$id} ya no existe.",
                ]);
            }

            if ((int) $producto->stock < $cantidad) {
                throw ValidationException::withMessages([
                    'productos' => "Stock insuficiente para '{$producto->nombre}'. Disponible: {$producto->stock}; solicitado: {$cantidad}.",
                ]);
            }
        }

        foreach ($cantidades as $id => $cantidad) {
            $productos->get($id)->decrement('stock', $cantidad);
        }

        $this->eventos->create([
            'id_pedido' => $pedido->id_pedido,
            'id_estado' => $pedido->id_estado,
            'tipo_evento' => 'INVENTARIO_RESERVADO',
            'comentario' => $comentario,
            'fecha' => now(),
        ]);
    }

    private function asegurarInventarioReservado(Pedido $pedido): void
    {
        if (!$this->tieneInventarioReservado($pedido)) {
            $this->reservarInventario(
                $pedido,
                'Inventario reservado al editar un pedido antiguo.'
            );
        }
    }

    private function devolverInventarioSiReservado(
        Pedido $pedido,
        string $comentario
    ): void {
        if (!$this->tieneInventarioReservado($pedido)) {
            return;
        }

        $yaDevuelto = PedidoEvento::query()
            ->where('id_pedido', $pedido->id_pedido)
            ->where('tipo_evento', 'INVENTARIO_DEVUELTO')
            ->exists();

        if ($yaDevuelto) {
            return;
        }

        $cantidades = $pedido->detalles()->get()
            ->groupBy('id_producto')
            ->map(fn ($lineas) => (int) $lineas->sum('cantidad'));

        $productos = Producto::query()
            ->whereIn('id', $cantidades->keys()->all())
            ->orderBy('id')
            ->lockForUpdate()
            ->get()
            ->keyBy('id');

        foreach ($cantidades as $id => $cantidad) {
            $producto = $productos->get($id);

            if (!$producto) {
                throw ValidationException::withMessages([
                    'inventario' => "No existe el producto #{$id}; no se puede devolver su inventario.",
                ]);
            }

            $producto->increment('stock', $cantidad);
        }

        $this->eventos->create([
            'id_pedido' => $pedido->id_pedido,
            'id_estado' => $pedido->id_estado,
            'tipo_evento' => 'INVENTARIO_DEVUELTO',
            'comentario' => $comentario,
            'fecha' => now(),
        ]);
    }

    private function validarEditable(Pedido $pedido): void
    {
        $estado = EstadoGeneral::query()
            ->where('id_estado', $pedido->id_estado)
            ->where('tipo', 'PEDIDO')
            ->first();

        if (!$estado) {
            throw ValidationException::withMessages([
                'pedido' => "El pedido #{$pedido->id_pedido} tiene un estado inválido.",
            ]);
        }

        if (mb_strtolower(trim($estado->nombre)) !== 'pendiente') {
            throw ValidationException::withMessages([
                'pedido' => "El pedido #{$pedido->id_pedido} solo permite modificaciones cuando está Pendiente. Estado actual: '{$estado->nombre}'.",
            ]);
        }
    }

    private function estadoPedido(string $nombre): EstadoGeneral
    {
        return EstadoGeneral::firstOrCreate([
            'tipo' => 'PEDIDO',
            'nombre' => $nombre,
        ]);
    }

    private function recargar(Pedido $pedido): Pedido
    {
        return $pedido->load([
            'usuario', 'estado', 'detalles.producto.categoria',
            'eventos.estado',
        ]);
    }

    public function misPedidos(int $usuarioId)
    {
        return $this->pedidos->forUsuario($usuarioId);
    }

    public function miPedido(int $pedidoId, int $usuarioId): Pedido
    {
        return $this->pedidos->findForUsuario($pedidoId, $usuarioId);
    }
}
