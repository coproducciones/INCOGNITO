<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class RegistroController extends Controller
{
    /**
     * Mostrar el formulario público para elegir Cliente o Proveedor.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Registrar una cuenta pública.
     *
     * IMPORTANTE:
     * - El formulario solo acepta cliente o proveedor.
     * - Nunca se toma id_rol desde el formulario.
     * - El rol se resuelve en el servidor por su nombre.
     * - No se cambian ni se eliminan roles/usuarios existentes.
     */
    public function store(\Illuminate\Http\Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'tipo_cuenta' => ['required', 'string', 'in:cliente,proveedor'],
            'acepta_terminos' => ['accepted'],
        ], [
            'nombre.required' => 'Escribe tu nombre completo.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Escribe un correo electrónico válido.',
            'email.unique' => 'Ya existe una cuenta con este correo.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'tipo_cuenta.required' => 'Selecciona el tipo de cuenta.',
            'tipo_cuenta.in' => 'El tipo de cuenta seleccionado no es válido.',
            'acepta_terminos.accepted' => 'Debes aceptar los términos para crear una cuenta.',
        ]);

        // Los nombres de rol se verifican en la base de datos; jamás se acepta un id_rol del cliente.
        $nombresRol = $data['tipo_cuenta'] === 'cliente'
            ? ['cliente']
            : ['proveedor', 'empresa'];

        $rol = DB::table('roles')
            ->whereIn(DB::raw('LOWER(TRIM(nombre))'), $nombresRol)
            ->orderByRaw("CASE LOWER(TRIM(nombre)) WHEN 'proveedor' THEN 0 WHEN 'empresa' THEN 1 ELSE 2 END")
            ->first();

        if (!$rol) {
            throw ValidationException::withMessages([
                'tipo_cuenta' => $data['tipo_cuenta'] === 'cliente'
                    ? 'El rol Cliente todavía no está configurado. Solicita al administrador que lo cree.'
                    : 'El rol Proveedor (o Empresa) todavía no está configurado. Solicita al administrador que lo cree.',
            ]);
        }

        // Si existe el estado general "Activo" para usuarios, se asigna.
        // Si no existe, id_estado queda null; no se inventan estados ni se toca el esquema.
        $estadoActivo = DB::table('estado_general')
            ->whereRaw("LOWER(TRIM(tipo)) = 'usuario'")
            ->whereRaw("LOWER(TRIM(nombre)) = 'activo'")
            ->value('id_estado');

        $usuario = DB::transaction(function () use ($data, $rol, $estadoActivo) {
            return Usuario::create([
                'nombre' => trim($data['nombre']),
                'email' => Str::lower(trim($data['email'])),
                'telefono' => $data['telefono'] ?? null,
                'password' => Hash::make($data['password']),
                'id_rol' => $rol->id_rol,
                'id_estado' => $estadoActivo,
            ]);
        });

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()
            ->route('mi-cuenta')
            ->with('success', 'Tu cuenta se creó correctamente. ¡Bienvenido/a!');
    }
}
