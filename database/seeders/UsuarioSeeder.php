<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Crea el administrador inicial únicamente cuando se proporcionan
     * credenciales explícitas en el entorno.
     *
     * No modifica cuentas existentes ni restablece contraseñas al
     * volver a ejecutar los seeders.
     */
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');
        $nombre = config('admin.name', 'Administrador');

        // No crear cuentas administrativas con credenciales predecibles.
        if (empty($email) || empty($password)) {
            return;
        }

        $administrador = Rol::query()
            ->where('nombre', 'Administrador')
            ->first();

        if (!$administrador) {
            return;
        }

        Usuario::query()->firstOrCreate(
            ['email' => $email],
            [
                'nombre' => $nombre,
                'password' => Hash::make($password),
                'id_rol' => $administrador->id_rol,
            ]
        );
    }
}
