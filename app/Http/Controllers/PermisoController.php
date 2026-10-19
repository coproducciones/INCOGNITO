<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermisoStoreRequest;
use App\Http\Requests\PermisoUpdateRequest;
use App\Models\Permiso;
use App\Services\PermisoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PermisoController extends Controller
{
    public function __construct(
        private PermisoService $service
    ) {}

    public function index(): View
    {
        return view('Permisos.index', [
            'permisos' => $this->service->listar(),
        ]);
    }

    public function create(): View
    {
        return view('Permisos.create');
    }

    public function store(PermisoStoreRequest $request): RedirectResponse
    {
        $this->service->crear($request->validated());

        return redirect()
            ->route('permisos.index')
            ->with('success', 'Permiso creado correctamente.');
    }

    public function edit(Permiso $permiso): View
    {
        return view('Permisos.edit', compact('permiso'));
    }

    public function update(
        PermisoUpdateRequest $request,
        Permiso $permiso
    ): RedirectResponse {
        $this->service->actualizar(
            $permiso,
            $request->validated()
        );

        return redirect()
            ->route('permisos.index')
            ->with('success', 'Permiso actualizado correctamente.');
    }

    public function destroy(Permiso $permiso): RedirectResponse
    {
        try {
            $this->service->eliminar($permiso);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('permisos.index')
            ->with('success', 'Permiso eliminado correctamente.');
    }
}
