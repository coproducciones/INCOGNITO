<?php

namespace App\Http\Controllers;

use App\Http\Requests\MultimediaStoreRequest;
use App\Http\Requests\MultimediaUpdateRequest;
use App\Models\Multimedia;
use App\Repositories\ProductoRepository;
use App\Repositories\ContenidoRepository;
use App\Services\MultimediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MultimediaController extends Controller
{
    public function __construct(
        protected MultimediaService $multimediaService,
        protected ProductoRepository $productoRepository,
        protected ContenidoRepository $contenidoRepository,
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Listado
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $medias = $this->multimediaService->getAll();

        return view(
            'Multimedias.index',
            compact('medias')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Crear
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view(
            'Multimedias.create',
            $this->formOptions()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Guardar
    |--------------------------------------------------------------------------
    */

    public function store(
        MultimediaStoreRequest $request
    ): RedirectResponse {

        $this->multimediaService->create(
            $request->validated()
        );

        return redirect()
            ->route('multimedias.index')
            ->with(
                'success',
                'Media registrada correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Mostrar
    |--------------------------------------------------------------------------
    */

    public function show(Multimedia $media): View
    {
        $media->load([
            'producto',
            'contenido',
        ]);

        return view(
            'Multimedias.show',
            compact('media')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Editar
    |--------------------------------------------------------------------------
    */

    public function edit(Multimedia $media): View
    {
        return view(
            'Multimedias.edit',
            array_merge(
                [
                    'media' => $media,
                ],
                $this->formOptions()
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Actualizar
    |--------------------------------------------------------------------------
    */

    public function update(
        MultimediaUpdateRequest $request,
        Multimedia $media
    ): RedirectResponse {

        $this->multimediaService->update(
            $media,
            $request->validated()
        );

        return redirect()
            ->route('multimedias.index')
            ->with(
                'success',
                'Media actualizada correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Multimedia $media
    ): RedirectResponse {

        $this->multimediaService->delete($media);

        return redirect()
            ->route('multimedias.index')
            ->with(
                'success',
                'Media eliminada correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Opciones de formularios
    |--------------------------------------------------------------------------
    */

    private function formOptions(): array
    {
        return [
            'productos' => $this->productoRepository->all(),
            'contenidos' => $this->contenidoRepository->getAll(),
        ];
    }
}
