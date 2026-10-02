<?php

namespace App\Services;

use App\Models\Pedido;
use App\Models\Producto;
use App\Repositories\DetallePedidoRepository;
use Illuminate\Validation\ValidationException;

class DetallePedidoService
{
    public function __construct(
        private DetallePedidoRepository $detalles
    ) {}

    public function agregar(
        Pedido $pedido,
        array $data
    ) {
        $producto = Producto::findOrFail(
            $data['id_producto']
        );

        $cantidad = (int) $data['cantidad'];

        if (!$producto->estado) {
            throw ValidationException::withMessages([
                'id_producto' =>
                    'El producto no está activo.'
            ]);
        }

        if ((int) $producto->stock < $cantidad) {
            throw ValidationException::withMessages([
                'cantidad' =>
                    'La cantidad supera el stock disponible.'
            ]);
        }

        if (
            $pedido
                ->detalles()
                ->where(
                    'id_producto',
                    $producto->getKey()
                )
                ->exists()
        ) {
            throw ValidationException::withMessages([
                'id_producto' =>
                    'El producto ya existe en el detalle del pedido.'
            ]);
        }

        $precio = (float) $producto->precio;

        return $this->detalles->create([
            'id_pedido' => $pedido->id_pedido,
            'id_producto' => $producto->getKey(),
            'cantidad' => $cantidad,
            'precio_unitario' => $precio,
            'subtotal' => $precio * $cantidad,
        ]);
    }

    public function modificar(
        Pedido $pedido,
        int $detalleId,
        array $data
    ) {
        $detalle = $this->detalles->find($detalleId);

        if (
            !$this->detalles
                ->belongsToPedido($detalle, $pedido)
        ) {
            throw ValidationException::withMessages([
                'detalle' =>
                    'El detalle no pertenece al pedido indicado.'
            ]);
        }

        $cantidad = (int) $data['cantidad'];

        $producto = $detalle->producto;

        if ((int) $producto->stock < $cantidad) {
            throw ValidationException::withMessages([
                'cantidad' =>
                    'La cantidad supera el stock disponible.'
            ]);
        }

        $precio = (float) $detalle->precio_unitario;

        $this->detalles->update($detalle, [
            'cantidad' => $cantidad,
            'subtotal' => $precio * $cantidad,
        ]);

        return $detalle;
    }

    public function eliminar(
        Pedido $pedido,
        int $detalleId
    ): void {
        $detalle = $this->detalles->find($detalleId);

        if (
            !$this->detalles
                ->belongsToPedido($detalle, $pedido)
        ) {
            throw ValidationException::withMessages([
                'detalle' =>
                    'El detalle no pertenece al pedido indicado.'
            ]);
        }

        $this->detalles->delete($detalle);
    }
}