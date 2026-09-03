<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioStoreRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Models\Usuario;
use App\Services\UsuarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    /**
     * Service de usuarios.
     */
    protected UsuarioService $usuarioService;

    /**
     * Constructor.
     */
    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    /**
     * Mostrar todos los usuarios.
     */
    public function index(): View
    {
        $usuarios = $this->usuarioService->getAll();

        return view('Usuarios.index', compact('usuarios'));
    }

    /**
     * Mostrar formulario para crear usuario.
     */
    public function create(): View
    {
        return view('Usuarios.create');
    }

    /**
     * Guardar un nuevo usuario.
     */
    public function store(
        UsuarioStoreRequest $request
    ): RedirectResponse {

        $this->usuarioService->create(
            $request->validated()
        );

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    /**
     * Mostrar información de un usuario.
     */
    public function show(Usuario $usuario): View
    {
        return view('Usuarios.show', compact('usuario'));
    }

    /**
     * Mostrar formulario para editar usuario.
     */
    public function edit(Usuario $usuario): View
    {
        return view('Usuarios.edit', compact('usuario'));
    }

    /**
     * Actualizar un usuario.
     */
    public function update(
        UsuarioUpdateRequest $request,
        Usuario $usuario
    ): RedirectResponse {

        $this->usuarioService->update(
            $usuario,
            $request->validated()
        );

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy(Usuario $usuario): RedirectResponse
    {
        $this->usuarioService->delete($usuario);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}