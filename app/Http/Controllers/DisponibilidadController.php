<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisponibilidadStoreRequest;
use App\Http\Requests\DisponibilidadUpdateRequest;
use App\Models\Disponibilidad;
use App\Models\Proveedor;
use App\Services\DisponibilidadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DisponibilidadController extends Controller
{
    public function __construct(
        private readonly DisponibilidadService $service
    ) {}

    /*
    |--------------------------------------------------------------------------
    | DISPONIBILIDAD ADMINISTRATIVA
    |--------------------------------------------------------------------------
    */

    public function index(Proveedor $proveedor): View
    {
        $disponibilidades = $this->service->listarPorProveedor(
            $proveedor->id_proveedor
        );

        $esMiDisponibilidad = false;

        return view(
            'Disponibilidad.index',
            compact('proveedor', 'disponibilidades', 'esMiDisponibilidad')
        );
    }

    public function create(Proveedor $proveedor): View
    {
        $esMiDisponibilidad = false;

        return view(
            'Disponibilidad.create',
            compact('proveedor', 'esMiDisponibilidad')
        );
    }

    public function store(
        DisponibilidadStoreRequest $request,
        Proveedor $proveedor
    ): RedirectResponse {
        $data = $request->validated();

        // El proveedor se determina desde la ruta administrativa.
        $data['id_proveedor'] = $proveedor->id_proveedor;

        $this->service->crear($data);

        return redirect()
            ->route('proveedores.disponibilidades.index', $proveedor)
            ->with('success', 'Disponibilidad registrada correctamente.');
    }

    public function edit(
        Proveedor $proveedor,
        Disponibilidad $disponibilidad
    ): View {
        abort_unless(
            (int) $disponibilidad->id_proveedor ===
            (int) $proveedor->id_proveedor,
            404
        );

        $esMiDisponibilidad = false;

        return view(
            'Disponibilidad.edit',
            compact('proveedor', 'disponibilidad', 'esMiDisponibilidad')
        );
    }

    public function update(
        DisponibilidadUpdateRequest $request,
        Proveedor $proveedor,
        Disponibilidad $disponibilidad
    ): RedirectResponse {
        abort_unless(
            (int) $disponibilidad->id_proveedor ===
            (int) $proveedor->id_proveedor,
            404
        );

        $data = $request->validated();
        $data['id_proveedor'] = $proveedor->id_proveedor;

        $this->service->actualizar($disponibilidad, $data);

        return redirect()
            ->route('proveedores.disponibilidades.index', $proveedor)
            ->with('success', 'Disponibilidad actualizada correctamente.');
    }

    public function destroy(
        Proveedor $proveedor,
        Disponibilidad $disponibilidad
    ): RedirectResponse {
        abort_unless(
            (int) $disponibilidad->id_proveedor ===
            (int) $proveedor->id_proveedor,
            404
        );

        $this->service->eliminar($disponibilidad);

        return redirect()
            ->route('proveedores.disponibilidades.index', $proveedor)
            ->with('success', 'Disponibilidad eliminada correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | DISPONIBILIDAD PERSONAL DEL PROVEEDOR
    |--------------------------------------------------------------------------
    */

    private function obtenerMiProveedor(): Proveedor
    {
        return Proveedor::where('id_usuario', Auth::id())
            ->firstOrFail();
    }

    private function verificarPropiedad(
        Proveedor $proveedor,
        Disponibilidad $disponibilidad
    ): void {
        abort_unless(
            (int) $disponibilidad->id_proveedor ===
            (int) $proveedor->id_proveedor,
            404
        );
    }

    public function miIndex(): View|RedirectResponse
    {
        $proveedor = Proveedor::where('id_usuario', Auth::id())
            ->first();

        if (!$proveedor) {
            return redirect()
                ->route('proveedores.mi-perfil.create')
                ->with(
                    'info',
                    'Primero debes crear tu perfil de proveedor.'
                );
        }

        $disponibilidades = $this->service->listarPorProveedor(
            $proveedor->id_proveedor
        );

        $esMiDisponibilidad = true;

        return view(
            'Disponibilidad.index',
            compact('proveedor', 'disponibilidades', 'esMiDisponibilidad')
        );
    }

    public function miCreate(): View|RedirectResponse
    {
        $proveedor = Proveedor::where('id_usuario', Auth::id())
            ->first();

        if (!$proveedor) {
            return redirect()
                ->route('proveedores.mi-perfil.create')
                ->with(
                    'info',
                    'Primero debes crear tu perfil de proveedor.'
                );
        }

        $esMiDisponibilidad = true;

        return view(
            'Disponibilidad.create',
            compact('proveedor', 'esMiDisponibilidad')
        );
    }

    public function miStore(
        DisponibilidadStoreRequest $request
    ): RedirectResponse {
        $proveedor = $this->obtenerMiProveedor();

        $data = $request->validated();

        // Ignorar cualquier proveedor enviado por el navegador.
        $data['id_proveedor'] = $proveedor->id_proveedor;

        $this->service->crear($data);

        return redirect()
            ->route('mi-disponibilidad.index')
            ->with('success', 'Tu disponibilidad fue registrada correctamente.');
    }

    public function miEdit(
        Disponibilidad $disponibilidad
    ): View|RedirectResponse {
        $proveedor = Proveedor::where('id_usuario', Auth::id())
            ->first();

        if (!$proveedor) {
            return redirect()
                ->route('proveedores.mi-perfil.create');
        }

        $this->verificarPropiedad($proveedor, $disponibilidad);

        $esMiDisponibilidad = true;

        return view(
            'Disponibilidad.edit',
            compact('proveedor', 'disponibilidad', 'esMiDisponibilidad')
        );
    }

    public function miUpdate(
        DisponibilidadUpdateRequest $request,
        Disponibilidad $disponibilidad
    ): RedirectResponse {
        $proveedor = $this->obtenerMiProveedor();

        $this->verificarPropiedad($proveedor, $disponibilidad);

        $data = $request->validated();

        // No permitir cambiar la disponibilidad a otro proveedor.
        $data['id_proveedor'] = $proveedor->id_proveedor;

        $this->service->actualizar($disponibilidad, $data);

        return redirect()
            ->route('mi-disponibilidad.index')
            ->with('success', 'Tu disponibilidad fue actualizada correctamente.');
    }

    public function miDestroy(
        Disponibilidad $disponibilidad
    ): RedirectResponse {
        $proveedor = $this->obtenerMiProveedor();

        $this->verificarPropiedad($proveedor, $disponibilidad);

        $this->service->eliminar($disponibilidad);

        return redirect()
            ->route('mi-disponibilidad.index')
            ->with('success', 'Tu disponibilidad fue eliminada correctamente.');
    }
}
