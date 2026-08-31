<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('Categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('Categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:40',
            'descripcion' => 'nullable|string|max:100',
        ]);

        Categoria::create($request->only('nombre', 'descripcion'));

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function show(Categoria $categoria)
    {
        return view('Categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        return view('Categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre'      => 'required|string|max:40',
            'descripcion' => 'nullable|string|max:100',
        ]);

        $categoria->update($request->only('nombre', 'descripcion'));

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}