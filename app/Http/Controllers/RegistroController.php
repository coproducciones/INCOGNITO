<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Proveedor;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegistroController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Registro público seguro de Visitante, Cliente o Proveedor.
     * No acepta id_rol ni permite crear cuentas administrativas.
     */
    public function store(Request $request): RedirectResponse
    {
        // Normalizar antes de validar unicidad: Usuario@Correo.com y usuario@correo.com
        // deben tratarse como la misma dirección.
        $request->merge([
            'nombre' => is_string($request->input('nombre')) ? trim($request->input('nombre')) : $request->input('nombre'),
            'email' => is_string($request->input('email')) ? Str::lower(trim($request->input('email'))) : $request->input('email'),
            'telefono' => is_string($request->input('telefono')) ? trim($request->input('telefono')) : $request->input('telefono'),
            'especialidad' => is_string($request->input('especialidad')) ? trim($request->input('especialidad')) : $request->input('especialidad'),
        ]);

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email'],
            'telefono' => ['nullable', 'string', 'max:20', 'required_if:tipo_cuenta,proveedor'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'tipo_cuenta' => ['required', 'string', 'in:visitante,cliente,proveedor'],
            'acepta_terminos' => ['accepted'],
            'empresa' => ['nullable', 'string', 'max:150'],
            'especialidad' => ['required_if:tipo_cuenta,proveedor', 'nullable', 'string', 'max:150'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'descripcion' => ['nullable', 'string', 'max:5000'],
        ], [
            'nombre.required' => 'Escribe tu nombre completo.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Escribe un correo electrónico válido.',
            'email.unique' => 'Ya existe una cuenta con este correo.',
            'telefono.required_if' => 'El teléfono es obligatorio para crear una cuenta de proveedor.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'tipo_cuenta.required' => 'Selecciona el tipo de cuenta.',
            'tipo_cuenta.in' => 'El tipo de cuenta seleccionado no es válido.',
            'especialidad.required_if' => 'Indica la especialidad de tu negocio o servicio.',
            'acepta_terminos.accepted' => 'Debes aceptar los términos para crear una cuenta.',
        ]);

        $nombreRol = match ($data['tipo_cuenta']) {
            'visitante' => 'visitante',
            'cliente' => 'cliente',
            'proveedor' => 'proveedor',
        };

        $rol = DB::table('roles')
            ->whereRaw('LOWER(TRIM(nombre)) = ?', [$nombreRol])
            ->first();

        if (!$rol) {
            throw ValidationException::withMessages([
                'tipo_cuenta' => "El rol {$this->etiquetaRol($nombreRol)} no está configurado. Solicita al administrador que ejecute la configuración de roles.",
            ]);
        }

        $estadoActivo = DB::table('estado_general')
            ->whereRaw("LOWER(TRIM(tipo)) = 'usuario'")
            ->whereRaw("LOWER(TRIM(nombre)) = 'activo'")
            ->value('id_estado');

        $usuario = DB::transaction(function () use ($data, $rol, $estadoActivo): Usuario {
            $usuario = Usuario::create([
                'nombre' => $data['nombre'],
                'email' => $data['email'],
                'telefono' => $data['telefono'] ?? null,
                'password' => Hash::make($data['password']),
                'id_rol' => $rol->id_rol,
                'id_estado' => $estadoActivo,
            ]);

            if ($data['tipo_cuenta'] === 'cliente') {
                Cliente::create([
                    'id_usuario' => $usuario->id,
                    'nombre' => $usuario->nombre,
                    'empresa' => $data['empresa'] ?? null,
                    'logo_url' => null,
                ]);
            }

            if ($data['tipo_cuenta'] === 'proveedor') {
                Proveedor::create([
                    'id_usuario' => $usuario->id,
                    'especialidad' => $data['especialidad'],
                    'telefono' => $data['telefono'],
                    'whatsapp' => $data['whatsapp'] ?? null,
                    'descripcion' => $data['descripcion'] ?? null,
                    'foto_url' => null,
                ]);
            }

            return $usuario;
        });

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('mi-cuenta')
            ->with('success', 'Tu cuenta se creó correctamente. ¡Bienvenido/a!');
    }

    private function etiquetaRol(string $rol): string
    {
        return match ($rol) {
            'visitante' => 'Visitante',
            'cliente' => 'Cliente',
            'proveedor' => 'Proveedor',
            default => ucfirst($rol),
        };
    }
}
