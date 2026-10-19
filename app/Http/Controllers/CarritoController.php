<?php

namespace App\Http\Controllers;

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

    public function index(Request $request): View
    {
        $carrito = $this->carritoService->obtener($request);

        return view('Carrito.index', $carrito);
    }

    public function add(Request $request, int $producto): RedirectResponse
    {
        $cantidad = (int) $request->input('cantidad', 1);

        $this->carritoService->agregar($request, $producto, $cantidad);

        return redirect()
            ->route('carrito.index')
            ->with('success', 'Producto agregado al carrito.');
    }

    public function update(Request $request, int $producto): RedirectResponse
    {
        $cantidad = (int) $request->input('cantidad');

        $this->carritoService->actualizarCantidad($request, $producto, $cantidad);

        return redirect()
            ->route('carrito.index')
            ->with('success', 'Cantidad actualizada.');
    }

    public function remove(Request $request, int $producto): RedirectResponse
    {
        $this->carritoService->eliminar($request, $producto);

        return redirect()
            ->route('carrito.index')
            ->with('success', 'Producto eliminado del carrito.');
    }

    /**
     * Convierte el carrito de sesión en un pedido real.
     * El usuario y los precios se obtienen en el servidor.
     */
    public function confirmar(Request $request): RedirectResponse
    {
        $carrito = $this->carritoService->prepararCheckout($request);

        $productos = $carrito['items']->map(function (array $item) {
            return [
                'id_producto' => (int) $item['producto']->id,
                'cantidad' => (int) $item['cantidad'],
            ];
        })->values()->all();

        $pedido = $this->pedidoService->crear([
            'id_usuario' => (int) $request->user()->getAuthIdentifier(),
            'productos' => $productos,
        ]);

        // Solo vaciamos el carrito después de que PedidoService haya creado todo.
        $this->carritoService->vaciar($request);

        return redirect()
            ->route('mi-cuenta.pedidos.show', $pedido->id_pedido)
            ->with('success', "Pedido #{$pedido->id_pedido} creado correctamente.");
    }

    public function clear(Request $request): RedirectResponse
    {
        $this->carritoService->vaciar($request);

        return redirect()
            ->route('carrito.index')
            ->with('success', 'El carrito fue vaciado.');
    }
}
 