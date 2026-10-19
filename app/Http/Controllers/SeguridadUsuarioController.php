<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioSeguridadUpdateRequest;
use App\Models\EstadoGeneral;
use App\Models\Rol;
use App\Models\UsuarioSeguridad;
use App\Services\UsuarioSeguridadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SeguridadUsuarioController extends Controller
{
    public function __construct(
        private UsuarioSeguridadService $service
    ) {}

    /**
     * Listar usuarios para administrar su seguridad.
     */
    public function index(): View
    {
        return view('Seguridad.index', [
            'usuarios' => $this->service->listar(),
        ]);
    }

    /**
     * Editar el rol y el estado de un usuario.
     */
    public function edit(UsuarioSeguridad $usuario): View
    {
        // Solo cargar estados correspondientes a usuarios.
        $estados = EstadoGeneral::where('tipo', 'USUARIO')
            ->orderBy('nombre')
            ->get();

        return view('Seguridad.edit', [
            'usuario' => $usuario,
            'roles' => Rol::orderBy('nombre')->get(),
            'estados' => $estados,
        ]);
    }

    /**
     * Guardar los cambios de seguridad del usuario.
     */
    public function update(
        UsuarioSeguridadUpdateRequest $request,
        UsuarioSeguridad $usuario
    ): RedirectResponse {
        $this->service->actualizar(
            $usuario,
            $request->validated()
        );

        return redirect()
            ->route('seguridad.usuarios.index')
            ->with(
                'success',
                'Usuario actualizado correctamente.'
            );
    }
}
