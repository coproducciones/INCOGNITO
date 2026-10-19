<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContenidoStoreRequest;
use App\Http\Requests\ContenidoUpdateRequest;
use App\Models\Categoria;
use App\Models\Contenido;
use App\Services\ContenidoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ContenidoController extends Controller
{
    public function __construct(
        protected ContenidoService $contenidoService
    ) {
    }

    /**
     * Listar contenidos.
     */
    public function index(): View
    {
        $contenidos = $this->contenidoService->getAll();

        return view('Contenidos.index', compact('contenidos'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create(): View
    {
        $categorias = Categoria::query()
            ->orderBy('nombre')
            ->get();

        return view('Contenidos.create', compact('categorias'));
    }

    /**
     * Guardar un contenido nuevo.
     */
    public function store(
        ContenidoStoreRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        DB::transaction(function () use ($data): void {
            $categoria = Categoria::findOrFail(
                $data['categoria_id']
            );

            $contenido = $this->contenidoService->create([
                'titulo' => $data['titulo'],
                'descripcion' => $data['descripcion'] ?? null,
                'seccion' => $categoria->nombre,
            ]);

            $contenido->categorias()->sync([
                $categoria->id,
            ]);
        });

        return redirect()
            ->route('contenidos.index')
            ->with('success', 'Contenido creado correctamente.');
    }

    /**
     * Mostrar el detalle de un contenido.
     */
    public function show(Contenido $contenido): View
    {
        $contenido->load('categorias', 'media');

        return view('Contenidos.show', compact('contenido'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Contenido $contenido): View
    {
        $categorias = Categoria::query()
            ->orderBy('nombre')
            ->get();

        $contenido->load('categorias');

        return view(
            'Contenidos.edit',
            compact('contenido', 'categorias')
        );
    }

    /**
     * Actualizar un contenido.
     */
    public function update(
        ContenidoUpdateRequest $request,
        Contenido $contenido
    ): RedirectResponse {
        $data = $request->validated();

        DB::transaction(function () use ($data, $contenido): void {
            $categoria = Categoria::findOrFail(
                $data['categoria_id']
            );

            $this->contenidoService->update($contenido, [
                'titulo' => $data['titulo'],
                'descripcion' => $data['descripcion'] ?? null,
                'seccion' => $categoria->nombre,
            ]);

            $contenido->categorias()->sync([
                $categoria->id,
            ]);
        });

        return redirect()
            ->route('contenidos.index')
            ->with('success', 'Contenido actualizado correctamente.');
    }

    /**
     * Eliminar un contenido.
     */
    public function destroy(
        Contenido $contenido
    ): RedirectResponse {
        $this->contenidoService->delete($contenido);

        return redirect()
            ->route('contenidos.index')
            ->with('success', 'Contenido eliminado correctamente.');
    }
}