<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Services\CarritoService;
use App\Services\PedidoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarritoController extends Controller
{
    public function __construct(
        protected CarritoService $carritoService,
        protected PedidoService $pedidoService
    ) {
    }

    /**
     * Muestra el carrito de compras.
     */
    public function index(Request $request): View
    {
        $carrito = $this->carritoService->obtener($request);

        return view('Carrito.index', $carrito);
    }

    /**
     * Agrega un producto al carrito.
     */
    public function add(
        Request $request,
        int $producto
    ): RedirectResponse {
        $cantidad = (int) $request->input('cantidad', 1);

        $this->carritoService->agregar(
            $request,
            $producto,
            $cantidad
        );

        return redirect()
            ->route('carrito.index')
            ->with('success', 'Producto agregado al carrito.');
    }

    /**
     * Actualiza la cantidad de un producto del carrito.
     */
    public function update(
        Request $request,
        int $producto
    ): RedirectResponse {
        $cantidad = (int) $request->input('cantidad');

        $this->carritoService->actualizarCantidad(
            $request,
            $producto,
            $cantidad
        );

        return redirect()
            ->route('carrito.index')
            ->with('success', 'Cantidad actualizada.');
    }

    /**
     * Elimina un producto del carrito.
     */
    public function remove(
        Request $request,
        int $producto
    ): RedirectResponse {
        $this->carritoService->eliminar(
            $request,
            $producto
        );

        return redirect()
            ->route('carrito.index')
            ->with('success', 'Producto eliminado del carrito.');
    }

    /**
     * Crea el pedido a partir del carrito.
     *
     * El pedido y el inventario se gestionan desde PedidoService.
     * Después de crearlo, se determina el proveedor de sus productos.
     *
     * Si hay un solo proveedor, se abre el flujo de WhatsApp.
     * Si hay varios, se muestra el detalle del pedido para que el
     * cliente pueda elegir a cuál proveedor contactar.
     */
    public function confirmar(Request $request): RedirectResponse
    {
        $usuario = $request->user();

        abort_unless($usuario, 401);

        // Verificar el carrito y volver a validar productos y stock.
        $carrito = $this->carritoService->prepararCheckout($request);

        $productos = $carrito['items']
            ->map(function (array $item): array {
                return [
                    'id_producto' => (int) $item['producto']->id,
                    'cantidad' => (int) $item['cantidad'],
                ];
            })
            ->values()
            ->all();

        // Crear el pedido. Si falla, no se vacía el carrito.
        $pedido = $this->pedidoService->crear([
            'id_usuario' => (int) $usuario->getAuthIdentifier(),
            'productos' => $productos,
        ]);

        // Cargar los proveedores asociados a los productos del pedido.
        $pedido->load('detalles.producto.proveedor');

        $proveedores = $pedido->detalles
            ->map(function ($detalle) {
                return $detalle->producto?->proveedor;
            })
            ->filter()
            ->unique('id_proveedor')
            ->values();

        // Vaciar el carrito solo después de crear correctamente el pedido.
        $this->carritoService->vaciar($request);

        // Si no hay proveedor relacionado, conservar el pedido y mostrarlo.
        if ($proveedores->isEmpty()) {
            return redirect()
                ->route('mi-cuenta.pedidos.show', $pedido->id_pedido)
                ->with(
                    'warning',
                    'El pedido se creó, pero no se encontró un proveedor asociado a sus productos.'
                );
        }

        // Un único proveedor: abrir directamente su WhatsApp.
        if ($proveedores->count() === 1) {
            $proveedor = $proveedores->first();

            return redirect()->route('pedidos.whatsapp.proveedor', [
                'pedido' => $pedido->id_pedido,
                'proveedor' => $proveedor->id_proveedor,
            ]);
        }

        // Varios proveedores: no elegir uno arbitrariamente.
        // La vista del pedido permitirá seleccionar cada proveedor.
        return redirect()
            ->route('mi-cuenta.pedidos.show', $pedido->id_pedido)
            ->with(
                'success',
                "Pedido #{$pedido->id_pedido} creado correctamente. Como contiene productos de varios proveedores, selecciona a quién deseas contactar por WhatsApp."
            );
    }

    /**
     * Vacía el carrito.
     */
    public function clear(Request $request): RedirectResponse
    {
        $this->carritoService->vaciar($request);

        return redirect()
            ->route('carrito.index')
            ->with('success', 'El carrito fue vaciado.');
    }
}