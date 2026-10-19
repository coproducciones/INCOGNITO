<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioStoreRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Http\Requests\UsuarioProfileUpdateRequest;
use App\Models\Usuario;
use App\Services\UsuarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * =========================================================
     * AUTENTICACIÓN
     * =========================================================
     */

    /**
     * Mostrar formulario de inicio de sesión.
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Iniciar sesión.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate(
            [
                'email' => [
                    'required',
                    'email',
                ],
                'password' => [
                    'required',
                    'string',
                ],
            ],
            [
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El correo electrónico no es válido.',
                'password.required' => 'La contraseña es obligatoria.',
            ]
        );

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $usuario = Auth::user();

            return redirect()
                ->intended(route('dashboard'))
                ->with(
                    'success',
                    'Bienvenido, ' . $usuario->nombre . '.'
                );
        }

        return back()
            ->withInput(
                $request->only('email', 'remember')
            )
            ->withErrors([
                'email' => 'Las credenciales no son correctas.',
            ]);
    }

    /**
     * Cerrar sesión.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Sesión cerrada correctamente.'
            );
    }

    /**
     * =========================================================
     * MI CUENTA / MI PERFIL
     * =========================================================
     */

    /**
     * Mostrar la página principal de Mi cuenta.
     */
    public function miCuenta(Request $request): View
    {
        /** @var Usuario $usuario */
        $usuario = $request->user();

        return view(
            'MiCuenta.index',
            compact('usuario')
        );
    }

    /**
     * Mostrar el perfil del usuario autenticado.
     */
    public function perfil(Request $request): View
    {
        /** @var Usuario $usuario */
        $usuario = $request->user();

        return view(
            'MiCuenta.perfil',
            compact('usuario')
        );
    }

    /**
     * Mostrar formulario para editar el perfil.
     */
    public function editProfile(Request $request): View
    {
        /** @var Usuario $usuario */
        $usuario = $request->user();

        return view(
            'MiCuenta.edit',
            compact('usuario')
        );
    }

    /**
     * Actualizar únicamente el perfil del usuario autenticado.
     */
    public function updateProfile(
        UsuarioProfileUpdateRequest $request
    ): RedirectResponse {
        /** @var Usuario $usuario */
        $usuario = $request->user();

        $usuario = $this->usuarioService->updateProfile(
            $usuario,
            $request->validated()
        );

        /*
         * Si el usuario cambió su correo electrónico,
         * la sesión actual sigue siendo válida.
         * No se modifica ningún dato de rol o permisos.
         */
        Auth::setUser($usuario);

        return redirect()
            ->route('mi-cuenta.perfil')
            ->with(
                'success',
                'Tu perfil se actualizó correctamente.'
            );
    }

    /**
     * =========================================================
     * CRUD DE USUARIOS
     * =========================================================
     */

    /**
     * Mostrar todos los usuarios.
     */
    public function index(): View
    {
        $usuarios = $this->usuarioService->getAll();

        return view(
            'Usuarios.index',
            compact('usuarios')
        );
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
            ->with(
                'success',
                'Usuario registrado correctamente.'
            );
    }

    /**
     * Mostrar información de un usuario.
     */
    public function show(
        Usuario $usuario
    ): View {
        return view(
            'Usuarios.show',
            compact('usuario')
        );
    }

    /**
     * Mostrar formulario para editar usuario.
     */
    public function edit(
        Usuario $usuario
    ): View {
        return view(
            'Usuarios.edit',
            compact('usuario')
        );
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
            ->with(
                'success',
                'Usuario actualizado correctamente.'
            );
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy(
        Usuario $usuario
    ): RedirectResponse {
        $this->usuarioService->delete($usuario);

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuario eliminado correctamente.'
            );
    }
}
