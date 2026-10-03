<?php

namespace App\Services;

use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use App\Repositories\DetallePedidoRepository;
use Illuminate\Validation\ValidationException;

class DetallePedidoService
{
    public function __construct(
        private DetallePedidoRepository $detalles
    ) {}
   /*
     * =========================================================
     * AGREGAR PRODUCTO AL PEDIDO=========================================================
     */

    public function agregar(
        Pedido $pedido,
        array $data
    ): DetallePedido {

        /*
         * Buscar el producto junto con su categoría.
         */

        $producto = Producto::with('categoria')
            ->findOrFail((int) $data['id_producto']);

        /*
         * El producto debe estar activo.
         */

        if (!$producto->activo) {
            throw ValidationException::withMessages([
                'id_producto' =>
                    'El producto seleccionado no está activo.',
            ]);
        }

        /*
         * Validar la cantidad solicitada.
         */

        $cantidad = (int) $data['cantidad'];

        if ($cantidad < 1) {
            throw ValidationException::withMessages([
                'cantidad' =>
                    'La cantidad debe ser como mínimo 1.',
            ]);
 }

        /*
         * Buscar si el producto ya está en el pedido.
         */

        $detalle = $pedido->detalles()
            ->where('id_producto', $producto->id)
            ->first();

        /*
         * Si existe, sumar la cantidad solicitada.
         * Si no existe, utilizar la cantidad nueva.
         */

        $cantidadFinal = $cantidad;

        if ($detalle) {
            $cantidadFinal =
                (int) $detalle->cantidad + $cantidad;
        }

        /*
         * Validar que exista suficiente stock.
         */

        if ($cantidadFinal > (int) $producto->stock) {
            throw ValidationException::withMessages([
                'cantidad' =>
                    "No hay suficiente stock. " .
                    "Stock disponible: {$producto->stock}.",
            ]);
        }

        /*
         * Obtener el precio actual del producto.
         */

        $precio = (float) $producto->precio;

        /*
         * Calcular el subtotal.
         */

        $subtotal = round(
            $cantidadFinal * $precio,
            2
        );

        /*
         * Actualizar el detalle existente o crear uno nuevo.
         */

        if ($detalle) {

            $detalle->cantidad = $cantidadFinal;
            $detalle->precio_unitario = $precio;
            $detalle->subtotal = $subtotal;

            $detalle->save();

        } else {

            $detalle = new DetallePedido();

            $detalle->id_pedido = $pedido->id_pedido;
            $detalle->id_producto = $producto->id;
            $detalle->cantidad = $cantidadFinal;
            $detalle->precio_unitario = $precio;
            $detalle->subtotal = $subtotal;

            $detalle->save();
        }

        /*
         * Actualizar el total del pedido.
         */

        $total = $pedido->detalles()->sum('subtotal');

        $pedido->total = $total;
        $pedido->save();

        /*
         * Recargar el detalle y devolver un objeto obligatorio.
         *
         * A diferencia de fresh(), findOrFail() no permite que
         * el método devuelva silenciosamente null.
         */

        return DetallePedido::with([
            'producto.categoria',
        ])->findOrFail(
            $detalle->id_detalle
        );
    }


    /*
     * =========================================================
     * MODIFICAR CANTIDAD DE UN PRODUCTO
     * =========================================================
     */

    public function modificar(
        Pedido $pedido,
        int $detalleId,
        array $data
    ): DetallePedido {

        /*
         * Buscar el detalle dentro del pedido correspondiente.
         */

        $detalle = $pedido->detalles()
            ->where('id_detalle', $detalleId)
            ->firstOrFail();

        /*
         * Validar la cantidad.
         */

        $cantidad = (int) $data['cantidad'];

        if ($cantidad < 1) {
            throw ValidationException::withMessages([
                'cantidad' =>
                    'La cantidad debe ser como mínimo 1.',
            ]);
        }

        /*
         * Obtener el producto relacionado.
         */

        $producto = Producto::with('categoria')
            ->find($detalle->id_producto);

        if (!$producto) {
            throw ValidationException::withMessages([
                'producto' =>
                    'El producto asociado ya no existe.',
            ]);
        }

        /*
         * Validar stock.
         */

        if ($cantidad > (int) $producto->stock) {
            throw ValidationException::withMessages([
                'cantidad' =>
                    "No hay suficiente stock. " .
                    "Stock disponible: {$producto->stock}.",
            ]);
        }

        /*
         * Mantener el precio histórico del detalle.
         */

        $precio = (float) $detalle->precio_unitario;

        /*
         * Actualizar cantidad y subtotal.
         */

        $detalle->cantidad = $cantidad;
        $detalle->subtotal = round(
            $cantidad * $precio,
            2
        );

        $detalle->save();

        /*
         * Recalcular el total del pedido.
         */

        $pedido->total = $pedido->detalles()->sum('subtotal');
        $pedido->save();

        /*
         * Devolver el detalle actualizado.
         */

        return DetallePedido::with([
            'producto.categoria',
        ])->findOrFail(
            $detalle->id_detalle
        );
    }


    /*
     * =========================================================
     * ELIMINAR PRODUCTO DEL PEDIDO
     * =========================================================
     */

    public function eliminar(
        Pedido $pedido,
        int $detalleId
    ): void {

        /*
         * Verificar que el detalle pertenezca al pedido.
         */

        $detalle = $pedido->detalles()
            ->where('id_detalle', $detalleId)
            ->firstOrFail();

        /*
         * Eliminar el detalle.
         */

        $detalle->delete();

        /*
         * Recalcular el total después de eliminarlo.
         */

        $pedido->total = $pedido->detalles()->sum('subtotal');
        $pedido->save();
    }
}

