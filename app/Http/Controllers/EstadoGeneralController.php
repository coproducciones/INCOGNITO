<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadoGeneralStoreRequest;
use App\Http\Requests\EstadoGeneralUpdateRequest;
use App\Models\EstadoGeneral;
use App\Services\EstadoGeneralService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EstadoGeneralController extends Controller
{
    public function __construct(private EstadoGeneralService $service) {}
    public function index(): View { return view('Estados.index', ['estados' => $this->service->listar()]); }
    public function create(): View { return view('Estados.create'); }
    public function store(EstadoGeneralStoreRequest $request): RedirectResponse { $this->service->crear($request->validated()); return redirect()->route('estados.index')->with('success','Estado creado correctamente.'); }
    public function edit(EstadoGeneral $estado): View { return view('Estados.edit', compact('estado')); }
    public function update(EstadoGeneralUpdateRequest $request, EstadoGeneral $estado): RedirectResponse { $this->service->actualizar($estado,$request->validated()); return redirect()->route('estados.index')->with('success','Estado actualizado correctamente.'); }
    public function destroy(EstadoGeneral $estado): RedirectResponse { try { $this->service->eliminar($estado); } catch (\RuntimeException $e) { return back()->with('error',$e->getMessage()); } return redirect()->route('estados.index')->with('success','Estado eliminado correctamente.'); }
}
