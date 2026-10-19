<?php

namespace App\Http\Controllers;

use App\Http\Requests\MiProveedorStoreRequest;
use App\Http\Requests\ProveedorStoreRequest;
use App\Http\Requests\ProveedorUpdateRequest;
use App\Models\Proveedor;
use App\Models\Usuario;
use App\Services\ProveedorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProveedorController extends Controller
{
    public function __construct(
        private readonly ProveedorService $service
    ) {}

    /**
     * Listar proveedores.
     */
    public function index(): View
    {
        $proveedores = $this->service->listar();

        return view('Proveedores.index', compact('proveedores'));
    }

    /**
     * Mostrar formulario administrativo.
     */
    public function create(): View
    {
        $usuarios = Usuario::orderBy('nombre')->get();

        return view('Proveedores.create', compact('usuarios'));
    }

    /**
     * Registrar un proveedor desde administración.
     */
    public function store(ProveedorStoreRequest $request): RedirectResponse
    {
        $this->service->crear($request->validated());

        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor registrado correctamente.');
    }

    /**
     * Mostrar un proveedor.
     */
    public function show(Proveedor $proveedor): View
    {
        $proveedor = $this->service->obtener(
            $proveedor->id_proveedor
        );

        return view('Proveedores.show', compact('proveedor'));
    }

    /**
     * Mostrar formulario administrativo de edición.
     */
    public function edit(Proveedor $proveedor): View
    {
        $usuarios = Usuario::orderBy('nombre')->get();

        return view(
            'Proveedores.edit',
            compact('proveedor', 'usuarios')
        );
    }

    /**
     * Actualizar un proveedor desde administración.
     */
    public function update(
        ProveedorUpdateRequest $request,
        Proveedor $proveedor
    ): RedirectResponse {
        $this->service->actualizar(
            $proveedor,
            $request->validated()
        );

        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Eliminar un proveedor desde administración.
     */
    public function destroy(Proveedor $proveedor): RedirectResponse
    {
        $this->service->eliminar($proveedor);

        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }

    /**
     * Mostrar el formulario para crear el perfil propio.
     */
    public function crearMiPerfil(): View|RedirectResponse
    {
        $proveedor = Proveedor::where(
            'id_usuario',
            Auth::id()
        )->first();

        if ($proveedor) {
            return redirect()
                ->route('proveedores.index')
                ->with(
                    'success',
                    'Ya tienes un perfil de proveedor registrado.'
                );
        }

        return view('Proveedores.mi-perfil-create');
    }

    /**
     * Registrar el perfil del usuario autenticado.
     */
    public function guardarMiPerfil(
        MiProveedorStoreRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        // No confiar en un id_usuario enviado por el navegador.
        $data['id_usuario'] = Auth::id();

        $this->service->crear($data);

        return redirect()
            ->route('proveedores.index')
            ->with(
                'success',
                'Tu perfil de proveedor se registró correctamente.'
            );
    }
}
