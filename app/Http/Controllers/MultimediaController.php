<?php

namespace App\Http\Controllers;

use App\Http\Requests\MultimediaStoreRequest;
use App\Http\Requests\MultimediaUpdateRequest;
use App\Models\Contenido;
use App\Models\Multimedia;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Usuario;
use App\Services\MultimediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MultimediaController extends Controller
{
    public function __construct(
        protected MultimediaService $multimediaService
    ) {
    }

    public function index(): View
    {
        $proveedor = $this->proveedorPersonal();

        $consulta = Multimedia::query()->with(['producto', 'contenido']);

        if ($proveedor !== null) {
            $consulta->where(function ($query) use ($proveedor): void {
                $query->whereHas('producto', function ($producto) use ($proveedor): void {
                    $producto->where('id_proveedor', $proveedor->id_proveedor);
                })->orWhereHas('contenido', function ($contenido) use ($proveedor): void {
                    $contenido->where('id_proveedor', $proveedor->id_proveedor);
                });
            });
        }

        $medias = $consulta
            ->orderByDesc('destacado')
            ->orderBy('id')
            ->get();

        return view('Multimedias.index', compact('medias'));
    }

    public function create(): View
    {
        return view('Multimedias.create', $this->formOptions());
    }

    public function store(MultimediaStoreRequest $request): RedirectResponse
    {
        $proveedor = $this->proveedorPersonal();
        $data = $request->validated();

        $this->validarDestinoPropio($data, $proveedor);

        $this->multimediaService->create($data);

        return redirect()
            ->route('multimedias.index')
            ->with('success', 'Recurso multimedia guardado correctamente.');
    }

    public function show(Multimedia $media): View
    {
        $this->autorizarPropiedad($media);
        $media->load(['producto', 'contenido']);

        return view('Multimedias.show', compact('media'));
    }

    public function edit(Multimedia $media): View
    {
        $this->autorizarPropiedad($media);

        return view(
            'Multimedias.edit',
            array_merge(['media' => $media], $this->formOptions())
        );
    }

    public function update(
        MultimediaUpdateRequest $request,
        Multimedia $media
    ): RedirectResponse {
        $proveedor = $this->proveedorPersonal();
        $this->autorizarPropiedad($media);

        $data = $request->validated();
        $this->validarDestinoPropio($data, $proveedor);

        $this->multimediaService->update($media, $data);

        return redirect()
            ->route('multimedias.index')
            ->with('success', 'Recurso multimedia actualizado correctamente.');
    }

    public function destroy(Multimedia $media): RedirectResponse
    {
        $this->autorizarPropiedad($media);

        $this->multimediaService->delete($media);

        return redirect()
            ->route('multimedias.index')
            ->with('success', 'Recurso multimedia eliminado correctamente.');
    }

    /**
     * null significa acceso administrativo global.
     * En cualquier otro caso se exige una ficha de proveedor vinculada.
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

    /**
     * Autoriza por el propietario del producto o del contenido asociado.
     * La tabla multimedia no necesita duplicar id_proveedor.
     */
    private function autorizarPropiedad(Multimedia $media): void
    {
        $proveedor = $this->proveedorPersonal();

        if ($proveedor === null) {
            return;
        }

        $media->loadMissing(['producto', 'contenido']);

        $propietarioProducto = $media->producto?->id_proveedor;
        $propietarioContenido = $media->contenido?->id_proveedor;

        $esPropio = (int) ($propietarioProducto ?? $propietarioContenido ?? 0)
            === (int) $proveedor->id_proveedor;

        abort_unless($esPropio, 404);
    }

    /**
     * Evita asociar archivos a productos o contenidos de terceros.
     */
    private function validarDestinoPropio(array $data, ?Proveedor $proveedor): void
    {
        if ($proveedor === null) {
            return;
        }

        if (!empty($data['id_producto'])) {
            $esPropio = Producto::query()
                ->whereKey($data['id_producto'])
                ->where('id_proveedor', $proveedor->id_proveedor)
                ->exists();

            abort_unless($esPropio, 404, 'El producto seleccionado no pertenece a tu cuenta.');
        }

        if (!empty($data['id_contenido'])) {
            $esPropio = Contenido::query()
                ->whereKey($data['id_contenido'])
                ->where('id_proveedor', $proveedor->id_proveedor)
                ->exists();

            abort_unless($esPropio, 404, 'El contenido seleccionado no pertenece a tu cuenta.');
        }
    }

    private function formOptions(): array
    {
        $proveedor = $this->proveedorPersonal();

        $productos = Producto::query()
            ->when(
                $proveedor !== null,
                fn ($query) => $query->where('id_proveedor', $proveedor->id_proveedor)
            )
            ->orderBy('nombre')
            ->get();

        $contenidos = Contenido::query()
            ->when(
                $proveedor !== null,
                fn ($query) => $query->where('id_proveedor', $proveedor->id_proveedor)
            )
            ->orderBy('titulo')
            ->get();

        return compact('productos', 'contenidos');
    }
}
