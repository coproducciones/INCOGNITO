<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Registra los roles principales de la aplicación.
     */
    public function run(): void
    {
        $roles = [
            'Administrador',
            'Cliente',
            'Proveedor',
            'Visitante',
            'Usuario autorizado',
        ];

        foreach ($roles as $nombre) {
            Rol::firstOrCreate([
                'nombre' => $nombre,
            ]);
        }
    }
}
