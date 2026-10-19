<?php

namespace App\Services;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CarritoService
{
    private const SESSION_KEY = 'carrito';

    public function obtener(Request $request): array
    {
        $items = $request->session()->get(self::SESSION_KEY, []);
        $items = $this->normalizarItems($items);

        if ($items === []) {
            return [
                'items' => collect(),
                'total' => 0,
                'cantidadProductos' => 0,
            ];
        }

        $productos = Producto::query()
            ->whereIn('id', array_keys($items))
            ->where('activo', true)
            ->get()
            ->keyBy('id');

        // Si un producto dejó de existir o quedó inactivo, se retira del carrito.
        $items = array_filter(
            $items,
            fn (int $cantidad, int|string $id): bool => $productos->has((int) $id),
            ARRAY_FILTER_USE_BOTH
        );

        $request->session()->put(self::SESSION_KEY, $items);

        $detalle = collect($items)->map(function (int $cantidad, int|string $id) use ($productos) {
            $producto = $productos->get((int) $id);
            $precio = (float) $producto->precio;
            $subtotal = $precio * $cantidad;

            return [
                'producto' => $producto,
                'cantidad' => $cantidad,
                'precio' => $precio,
                'subtotal' => $subtotal,
            ];
        })->values();

        return [
            'items' => $detalle,
            'total' => $detalle->sum('subtotal'),
            'cantidadProductos' => $detalle->sum('cantidad'),
        ];
    }

    public function agregar(Request $request, int $productoId, int $cantidad = 1): void
    {
        if ($cantidad < 1) {
            throw ValidationException::withMessages([
                'cantidad' => 'La cantidad debe ser como mínimo 1.',
            ]);
        }

        $producto = Producto::query()
            ->whereKey($productoId)
            ->where('activo', true)
            ->first();

        if (!$producto) {
            throw ValidationException::withMessages([
                'producto' => 'El producto no está disponible.',
            ]);
        }

        if ((int) $producto->stock < $cantidad) {
            throw ValidationException::withMessages([
                'cantidad' => "Solo hay {$producto->stock} unidades disponibles de este producto.",
            ]);
        }

        $items = $this->normalizarItems($request->session()->get(self::SESSION_KEY, []));
        $actual = $items[$productoId] ?? 0;
        $nuevaCantidad = $actual + $cantidad;

        if ($nuevaCantidad > (int) $producto->stock) {
            throw ValidationException::withMessages([
                'cantidad' => "No puedes agregar más de {$producto->stock} unidades de este producto.",
            ]);
        }

        $items[$productoId] = $nuevaCantidad;
        $request->session()->put(self::SESSION_KEY, $items);
    }

    public function actualizarCantidad(Request $request, int $productoId, int $cantidad): void
    {
        $items = $this->normalizarItems($request->session()->get(self::SESSION_KEY, []));

        if (!array_key_exists($productoId, $items)) {
            return;
        }

        if ($cantidad <= 0) {
            unset($items[$productoId]);
            $request->session()->put(self::SESSION_KEY, $items);
            return;
        }

        $producto = Producto::query()
            ->whereKey($productoId)
            ->where('activo', true)
            ->first();

        if (!$producto) {
            unset($items[$productoId]);
            $request->session()->put(self::SESSION_KEY, $items);
            return;
        }

        if ($cantidad > (int) $producto->stock) {
            throw ValidationException::withMessages([
                'cantidad' => "Solo hay {$producto->stock} unidades disponibles.",
            ]);
        }

        $items[$productoId] = $cantidad;
        $request->session()->put(self::SESSION_KEY, $items);
    }

    public function eliminar(Request $request, int $productoId): void
    {
        $items = $this->normalizarItems($request->session()->get(self::SESSION_KEY, []));
        unset($items[$productoId]);
        $request->session()->put(self::SESSION_KEY, $items);
    }

    public function vaciar(Request $request): void
    {
        $request->session()->forget(self::SESSION_KEY);
    }

    public function cantidad(Request $request): int
    {
        return array_sum($this->normalizarItems($request->session()->get(self::SESSION_KEY, [])));
    }

    /**
     * El checkout definitivo se conectará al PedidoService existente.
     * Este método valida nuevamente stock y devuelve los datos limpios del carrito.
     */
    public function prepararCheckout(Request $request): array
    {
        $carrito = $this->obtener($request);

        if ($carrito['items']->isEmpty()) {
            throw ValidationException::withMessages([
                'carrito' => 'El carrito está vacío.',
            ]);
        }

        foreach ($carrito['items'] as $item) {
            if ($item['cantidad'] > (int) $item['producto']->stock) {
                throw ValidationException::withMessages([
                    'carrito' => "No hay suficiente stock para {$item['producto']->nombre}.",
                ]);
            }
        }

        return $carrito;
    }

    private function normalizarItems(array $items): array
    {
        $normalizados = [];

        foreach ($items as $id => $cantidad) {
            $id = (int) $id;
            $cantidad = (int) $cantidad;

            if ($id > 0 && $cantidad > 0) {
                $normalizados[$id] = $cantidad;
            }
        }

        return $normalizados;
    }
}
