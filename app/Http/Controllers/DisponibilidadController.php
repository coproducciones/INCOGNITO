<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisponibilidadStoreRequest;
use App\Http\Requests\DisponibilidadUpdateRequest;
use App\Models\Disponibilidad;
use App\Models\Proveedor;
use App\Services\DisponibilidadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DisponibilidadController extends Controller
{
    public function __construct(
        private readonly DisponibilidadService $service
    ) {}

    public function index(Proveedor $proveedor): View
    {
        $disponibilidades = $this->service->listarPorProveedor($proveedor->id_proveedor);
        return view('Disponibilidad.index', compact('proveedor', 'disponibilidades'));
    }

    public function create(Proveedor $proveedor): View
    {
        return view('Disponibilidad.create', compact('proveedor'));
    }

    public function store(DisponibilidadStoreRequest $request, Proveedor $proveedor): RedirectResponse
    {
        $data = $request->validated();
        $data['id_proveedor'] = $proveedor->id_proveedor;
        $this->service->crear($data);

        return redirect()->route('proveedores.disponibilidades.index', $proveedor)
            ->with('success', 'Disponibilidad registrada correctamente.');
    }

    public function edit(Proveedor $proveedor, Disponibilidad $disponibilidad): View
    {
        abort_unless($disponibilidad->id_proveedor === $proveedor->id_proveedor, 404);
        return view('Disponibilidad.edit', compact('proveedor', 'disponibilidad'));
    }

    public function update(DisponibilidadUpdateRequest $request, Proveedor $proveedor, Disponibilidad $disponibilidad): RedirectResponse
    {
        abort_unless($disponibilidad->id_proveedor === $proveedor->id_proveedor, 404);

        $data = $request->validated();
        $data['id_proveedor'] = $proveedor->id_proveedor;
        $this->service->actualizar($disponibilidad, $data);

        return redirect()->route('proveedores.disponibilidades.index', $proveedor)
            ->with('success', 'Disponibilidad actualizada correctamente.');
    }

    public function destroy(Proveedor $proveedor, Disponibilidad $disponibilidad): RedirectResponse
    {
        abort_unless($disponibilidad->id_proveedor === $proveedor->id_proveedor, 404);
        $this->service->eliminar($disponibilidad);

        return redirect()->route('proveedores.disponibilidades.index', $proveedor)
            ->with('success', 'Disponibilidad eliminada correctamente.');
    }
}
