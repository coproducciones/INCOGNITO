<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoStoreRequest;
use App\Http\Requests\ProductoUpdateRequest;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends Controller
{
    /**
     * Mostrar todos los productos.
     */
    public function index()
    {
        $productos = Producto::with('categoria')
            ->orderBy('nombre')
            ->get();

        return view('Productos.index', compact('productos'));
    }

    /**
     * Mostrar formulario para crear producto.
     */
    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('Productos.create', compact('categorias'));
    }

    /**
     * Guardar un nuevo producto.
     */
    public function store(ProductoStoreRequest $request)
    {
        $data = $request->validated();

        // Checkbox activo
        $data['activo'] = $request->has('activo');

        Producto::create($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Mostrar un producto.
     */
    public function show(Producto $producto)
    {
        $producto->load('categoria');

        return view('Productos.show', compact('producto'));
    }

    /**
     * Mostrar formulario para editar producto.
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('Productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Actualizar un producto.
     */
    public function update(
        ProductoUpdateRequest $request,
        Producto $producto
    ) {
        $data = $request->validated();

        // Checkbox activo
        $data['activo'] = $request->has('activo');

        $producto->update($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Eliminar un producto.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}