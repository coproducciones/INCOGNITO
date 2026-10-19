<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolPermisoSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | VISITANTE
        |--------------------------------------------------------------------------
        |
        | No recibe permisos administrativos.
        |
        */
        $visitante = Rol::where('nombre', 'Visitante')->first();

        if ($visitante) {
            $visitante->permisos()->sync([]);
        }

        /*
        |--------------------------------------------------------------------------
        | CLIENTE
        |--------------------------------------------------------------------------
        */
        $cliente = Rol::where('nombre', 'Cliente')->first();

        if ($cliente) {
            $permisosCliente = [
                'productos.ver',
                'categorias.ver',

                'pedidos.ver',
                'pedidos.crear',

                'pagos.ver',
                'pagos.crear',

                'resenas.ver',
                'resenas.crear',
            ];

            $cliente->permisos()->sync(
                Permiso::whereIn('nombre', $permisosCliente)
                    ->pluck('id_permiso')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PROVEEDOR
        |--------------------------------------------------------------------------
        */
        $proveedor = Rol::where('nombre', 'Proveedor')->first();

        if ($proveedor) {
            $permisosProveedor = [
                'productos.ver',
                'productos.crear',
                'productos.editar',

                'disponibilidad.ver',
                'disponibilidad.crear',
                'disponibilidad.editar',
            ];

            $proveedor->permisos()->sync(
                Permiso::whereIn('nombre', $permisosProveedor)
                    ->pluck('id_permiso')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
        |
        | El administrador tiene todos los permisos existentes.
        |
        */
        $administrador = Rol::where('nombre', 'Administrador')->first();

        if ($administrador) {
            $administrador->permisos()->sync(
                Permiso::pluck('id_permiso')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | USUARIO AUTORIZADO
        |--------------------------------------------------------------------------
        |
        | Empieza sin permisos de rol.
        | Sus permisos pueden asignarse individualmente
        | mediante usuario_permiso.
        |
        */
        $usuarioAutorizado = Rol::where(
            'nombre',
            'Usuario autorizado'
        )->first();

        if ($usuarioAutorizado) {
            $usuarioAutorizado->permisos()->sync([]);
        }
    }
}