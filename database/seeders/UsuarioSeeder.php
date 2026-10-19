<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $administrador = Rol::where(
            'nombre',
            'Administrador'
        )->first();

        if (!$administrador) {
            return;
        }

        Usuario::updateOrCreate(
            [
                'email' => 'coproducciones3311@gmail.com',
            ],
            [
                'nombre' => 'Cesar Ortiz',
                'password' => Hash::make('password'),
                'id_rol' => $administrador->id_rol,
            ]
        );
    }
}