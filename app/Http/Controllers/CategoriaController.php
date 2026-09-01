<?php

namespace App\Http\Controllers;
use App\Http\Requests\CategoriaStoreRequest;
use App\Http\Requests\CategoriaUpdateRequest;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Mostrar todas las categorías.
     */
    public function index()
    {
        $categorias = Categoria::orderBy('id', 'desc')->get();

        return view('Categorias.index', compact('categorias'));
    }

    /**
     * Mostrar formulario para crear categoría.
     */
    public function create()
    {
        return view('Categorias.create');
    }

    /**
     * Guardar una nueva categoría.
     */
    public function store(CategoriaStoreRequest $request)
    {
        Categoria::create($request->validated());

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    /**
     * Mostrar una categoría.
     */
    public function show(Categoria $categoria)
    {
        return view('Categorias.show', compact('categoria'));
    }

    /**
     * Mostrar formulario para editar.
     */
    public function edit(Categoria $categoria)
    {
        return view('Categorias.edit', compact('categoria'));
    }

    /**
     * Actualizar una categoría.
     */
    public function update(
        CategoriaUpdateRequest $request,
        Categoria $categoria
    ) {
        $categoria->update($request->validated());

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    /**
     * Eliminar una categoría.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}