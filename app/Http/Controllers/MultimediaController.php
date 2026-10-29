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

    public function index(): View
    {
        $medias = $this->multimediaService->getAll();

        return view('Multimedias.index', compact('medias'));
    }

    public function create(): View
    {
        return view('Multimedias.create', $this->formOptions());
    }

    public function store(
        MultimediaStoreRequest $request
    ): RedirectResponse {
        $this->multimediaService->create($request->validated());

        return redirect()
            ->route('multimedias.index')
            ->with('success', 'Recurso multimedia guardado correctamente.');
    }

    public function show(Multimedia $media): View
    {
        $media->load(['producto', 'contenido']);

        return view('Multimedias.show', compact('media'));
    }

    public function edit(Multimedia $media): View
    {
        return view(
            'Multimedias.edit',
            array_merge(['media' => $media], $this->formOptions())
        );
    }

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
            ->with('success', 'Recurso multimedia actualizado correctamente.');
    }

    public function destroy(Multimedia $media): RedirectResponse
    {
        $this->multimediaService->delete($media);

        return redirect()
            ->route('multimedias.index')
            ->with('success', 'Recurso multimedia eliminado correctamente.');
    }

    private function formOptions(): array
    {
        return [
            'productos' => $this->productoRepository->all(),
            'contenidos' => $this->contenidoRepository->getAll(),
        ];
    }
}