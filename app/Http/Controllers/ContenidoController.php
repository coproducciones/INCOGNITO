<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContenidoStoreRequest;
use App\Http\Requests\ContenidoUpdateRequest;
use App\Models\Categoria;
use App\Models\Contenido;
use App\Models\Proveedor;
use App\Models\Usuario;
use App\Services\ContenidoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ContenidoController extends Controller
{
    public function __construct(
        protected ContenidoService $contenidoService
    ) {
    }

    /**
     * El administrador consulta todos los contenidos.
     * El proveedor consulta únicamente los asociados a su ficha.
     */
    public function index(): View
    {
        $proveedor = $this->proveedorPersonal();

        $contenidos = $proveedor
            ? Contenido::query()
                ->with('categorias')
                ->where('id_proveedor', $proveedor->id_proveedor)
                ->orderBy('seccion')
                ->orderBy('titulo')
                ->get()
            : $this->contenidoService->getAll();

        return view('Contenidos.index', compact('contenidos'));
    }

    public function create(): View
    {
        $categorias = Categoria::query()->orderBy('nombre')->get();

        return view('Contenidos.create', compact('categorias'));
    }

    public function store(ContenidoStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $proveedor = $this->proveedorPersonal();

        DB::transaction(function () use ($data, $proveedor): void {
            $categoria = Categoria::findOrFail($data['categoria_id']);

            $contenido = $this->contenidoService->create([
                'titulo' => $data['titulo'],
                'descripcion' => $data['descripcion'] ?? null,
                'seccion' => $categoria->nombre,
                // El propietario se toma de la sesión, nunca del formulario.
                'id_proveedor' => $proveedor?->id_proveedor,
                'publicado' => false,
            ]);

            $contenido->categorias()->sync([$categoria->id]);
        });

        return redirect()
            ->route('contenidos.index')
            ->with('success', 'Contenido creado correctamente.');
    }

    public function show(Contenido $contenido): View
    {
        $this->autorizarPropiedad($contenido);
        $contenido->load('categorias', 'media', 'proveedor');

        return view('Contenidos.show', compact('contenido'));
    }

    public function edit(Contenido $contenido): View
    {
        $this->autorizarPropiedad($contenido);

        $categorias = Categoria::query()->orderBy('nombre')->get();
        $contenido->load('categorias');

        return view('Contenidos.edit', compact('contenido', 'categorias'));
    }

    public function update(
        ContenidoUpdateRequest $request,
        Contenido $contenido
    ): RedirectResponse {
        $this->autorizarPropiedad($contenido);

        $data = $request->validated();

        DB::transaction(function () use ($data, $contenido): void {
            $categoria = Categoria::findOrFail($data['categoria_id']);

            $this->contenidoService->update($contenido, [
                'titulo' => $data['titulo'],
                'descripcion' => $data['descripcion'] ?? null,
                'seccion' => $categoria->nombre,
                // id_proveedor y publicado no se aceptan desde este formulario.
            ]);

            $contenido->categorias()->sync([$categoria->id]);
        });

        return redirect()
            ->route('contenidos.index')
            ->with('success', 'Contenido actualizado correctamente.');
    }

    public function destroy(Contenido $contenido): RedirectResponse
    {
        $this->autorizarPropiedad($contenido);

        $this->contenidoService->delete($contenido);

        return redirect()
            ->route('contenidos.index')
            ->with('success', 'Contenido eliminado correctamente.');
    }

    /**
     * Devuelve null para administración global y la ficha propia para proveedor.
     */
    private function proveedorPersonal(): ?Proveedor
    {
        $usuario = Auth::user();
        abort_unless($usuario instanceof Usuario, 403);

        if ($usuario->tienePermiso('proveedores.ver')) {
            return null;
        }

        $proveedor = $usuario->proveedor()->first();
        abort_unless($proveedor !== null, 403);

        return $proveedor;
    }

    private function autorizarPropiedad(Contenido $contenido): void
    {
        $proveedor = $this->proveedorPersonal();

        if ($proveedor !== null) {
            abort_unless(
                (int) $contenido->id_proveedor === (int) $proveedor->id_proveedor,
                404
            );
        }
    }
}
