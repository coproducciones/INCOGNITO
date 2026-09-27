<?php

namespace App\Http\Controllers;


use App\Http\Requests\ContenidoStoreRequest;
use App\Http\Requests\ContenidoUpdateRequest;
use App\Models\Contenido;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Services\ContenidoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContenidoController extends Controller
{
    public function __construct(
        protected ContenidoService $contenidoService) {

    }

    public function index(): View
    {
        $contenidos = $this->contenidoService->getAll();
        return view('Contenidos.index', compact('contenidos'));
    }

    public function create(): View
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('Contenidos.create', compact('categorias'));
    }

public function store(Request $request)
{
    $request->validate([
        'titulo'       => 'required|string|max:255',
        'categoria_id' => 'required|exists:categorias,id',
        'descripcion'  => 'nullable|string',
    ]);

    // Buscamos el nombre de la categoría seleccionada
    $categoria = Categoria::findOrFail($request->categoria_id);

    // Creamos el contenido
    $contenido = Contenido::create([
        'titulo'      => $request->titulo,
        'descripcion' => $request->descripcion,
        'seccion'     => $categoria->nombre,   // ← guardamos el nombre de la categoría
    ]);

    // Asociamos la categoría (relación muchos a muchos)
    $contenido->categorias()->attach($request->categoria_id);

    return redirect()->route('contenidos.create')
                     ->with('success', 'Contenido creado correctamente.');
}

    public function show(Contenido $contenido): View
    {
        return view('Contenidos.show', compact('contenido'));
    }

    public function edit(Contenido $contenido): View
    {
        return view('Contenidos.edit', compact('contenido'));
    }

    public function update(ContenidoUpdateRequest $request, Contenido $contenido): RedirectResponse
    {
        $this->contenidoService->update($contenido, $request->validated());

        return redirect()
            ->route('contenidos.index')
            ->with('success', 'Contenido actualizado correctamente.');
    }

    public function destroy(Contenido $contenido): RedirectResponse
    {
        $this->contenidoService->delete($contenido);

        return redirect()
            ->route('contenidos.index')
            ->with('success', 'Contenido eliminado correctamente.');
    }
}
