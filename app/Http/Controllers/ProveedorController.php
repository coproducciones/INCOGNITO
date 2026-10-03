<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorStoreRequest;
use App\Http\Requests\ProveedorUpdateRequest;
use App\Models\Proveedor;
use App\Models\Usuario;
use App\Services\ProveedorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProveedorController extends Controller
{
    public function __construct(
        private readonly ProveedorService $service
    ) {}

    public function index(): View
    {
        $proveedores = $this->service->listar();
        return view('Proveedores.index', compact('proveedores'));
    }

    public function create(): View
    {
        $usuarios = Usuario::orderBy('nombre')->get();
        return view('Proveedores.create', compact('usuarios'));
    }

    public function store(ProveedorStoreRequest $request): RedirectResponse
    {
        $this->service->crear($request->validated());
        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor registrado correctamente.');
    }

    public function show(Proveedor $proveedor): View
    {
        $proveedor = $this->service->obtener($proveedor->id_proveedor);
        return view('Proveedores.show', compact('proveedor'));
    }

    public function edit(Proveedor $proveedor): View
    {
        $usuarios = Usuario::orderBy('nombre')->get();
        return view('Proveedores.edit', compact('proveedor', 'usuarios'));
    }

    public function update(ProveedorUpdateRequest $request, Proveedor $proveedor): RedirectResponse
    {
        $this->service->actualizar($proveedor, $request->validated());
        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Proveedor $proveedor): RedirectResponse
    {
        $this->service->eliminar($proveedor);
        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}
