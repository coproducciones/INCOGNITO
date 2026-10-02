<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;

class DashboardController extends Controller
{
    /**
     * Mostrar el Dashboard principal de Incógnito Group.
     *
     * Esta vista funciona como la página principal
     * del sistema y recibe:
     *
     * - Las categorías registradas.
     * - La cantidad de productos de cada categoría.
     * - Los productos activos.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | CATEGORÍAS
        |--------------------------------------------------------------------------
        |
        | Obtenemos todas las categorías registradas.
        |
        | withCount('productos') agrega automáticamente
        | el atributo:
        |
        | $categoria->productos_count
        |
        | Esto permite mostrar cuántos productos tiene
        | cada categoría.
        |
        */

        $categorias = Categoria::withCount('productos')
            ->orderBy('nombre')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PRODUCTOS
        |--------------------------------------------------------------------------
        |
        | Obtenemos únicamente los productos activos.
        |
        | with('categoria') carga la categoría relacionada
        | para poder utilizar:
        |
        | $producto->categoria->nombre
        |
        | desde Blade.
        |
        */

        $productos = Producto::with('categoria')
            ->where('activo', true)
            ->latest()
            ->take(6)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | VISTA
        |--------------------------------------------------------------------------
        |
        | Enviamos ambas variables al Dashboard.
        |
        */

        return view('dashboard.index', compact(
            'categorias',
            'productos'
        ));
    }
}