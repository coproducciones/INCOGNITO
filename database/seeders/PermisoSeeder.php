<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    public function run(): void
    {
        $permisos = [

            /*
            |--------------------------------------------------------------------------
            | USUARIOS
            |--------------------------------------------------------------------------
            */
            [
                'nombre' => 'usuarios.ver',
                'modulo' => 'usuarios',
            ],
            [
                'nombre' => 'usuarios.crear',
                'modulo' => 'usuarios',
            ],
            [
                'nombre' => 'usuarios.editar',
                'modulo' => 'usuarios',
            ],
            [
                'nombre' => 'usuarios.eliminar',
                'modulo' => 'usuarios',
            ],

            /*
            |--------------------------------------------------------------------------
            | ROLES
            |--------------------------------------------------------------------------
            */
            [
                'nombre' => 'roles.ver',
                'modulo' => 'roles',
            ],
            [
                'nombre' => 'roles.crear',
                'modulo' => 'roles',
            ],
            [
                'nombre' => 'roles.editar',
                'modulo' => 'roles',
            ],
            [
                'nombre' => 'roles.eliminar',
                'modulo' => 'roles',
            ],

            /*
            |--------------------------------------------------------------------------
            | PERMISOS
            |--------------------------------------------------------------------------
            */
            [
                'nombre' => 'permisos.ver',
                'modulo' => 'permisos',
            ],
            [
                'nombre' => 'permisos.crear',
                'modulo' => 'permisos',
            ],
            [
                'nombre' => 'permisos.editar',
                'modulo' => 'permisos',
            ],
            [
                'nombre' => 'permisos.eliminar',
                'modulo' => 'permisos',
            ],

            /*
            |--------------------------------------------------------------------------
            | PRODUCTOS
            |--------------------------------------------------------------------------
            */
            [
                'nombre' => 'productos.ver',
                'modulo' => 'productos',
            ],
            [
                'nombre' => 'productos.crear',
                'modulo' => 'productos',
            ],
            [
                'nombre' => 'productos.editar',
                'modulo' => 'productos',
            ],
            [
                'nombre' => 'productos.eliminar',
                'modulo' => 'productos',
            ],

            /*
            |--------------------------------------------------------------------------
            | CATEGORÍAS
            |--------------------------------------------------------------------------
            */
            [
                'nombre' => 'categorias.ver',
                'modulo' => 'categorias',
            ],
            [
                'nombre' => 'categorias.crear',
                'modulo' => 'categorias',
            ],
            [
                'nombre' => 'categorias.editar',
                'modulo' => 'categorias',
            ],
            [
                'nombre' => 'categorias.eliminar',
                'modulo' => 'categorias',
            ],

            /*
            |--------------------------------------------------------------------------
            | PEDIDOS
            |--------------------------------------------------------------------------
            */
            [
                'nombre' => 'pedidos.ver',
                'modulo' => 'pedidos',
            ],
            [
                'nombre' => 'pedidos.crear',
                'modulo' => 'pedidos',
            ],
            [
                'nombre' => 'pedidos.editar',
                'modulo' => 'pedidos',
            ],
            [
                'nombre' => 'pedidos.cancelar',
                'modulo' => 'pedidos',
            ],

            /*
            |--------------------------------------------------------------------------
            | PAGOS
            |--------------------------------------------------------------------------
            */
            [
                'nombre' => 'pagos.ver',
                'modulo' => 'pagos',
            ],
            [
                'nombre' => 'pagos.crear',
                'modulo' => 'pagos',
            ],
            [
                'nombre' => 'pagos.editar',
                'modulo' => 'pagos',
            ],

            /*
            |--------------------------------------------------------------------------
            | RESEÑAS
            |--------------------------------------------------------------------------
            */
            [
                'nombre' => 'resenas.ver',
                'modulo' => 'resenas',
            ],
            [
                'nombre' => 'resenas.crear',
                'modulo' => 'resenas',
            ],
            [
                'nombre' => 'resenas.editar',
                'modulo' => 'resenas',
            ],
            [
                'nombre' => 'resenas.eliminar',
                'modulo' => 'resenas',
            ],

            /*
            |--------------------------------------------------------------------------
            | PROVEEDORES
            |--------------------------------------------------------------------------
            */
            [
                'nombre' => 'proveedores.ver',
                'modulo' => 'proveedores',
            ],
            [
                'nombre' => 'proveedores.crear',
                'modulo' => 'proveedores',
            ],
            [
                'nombre' => 'proveedores.editar',
                'modulo' => 'proveedores',
            ],
            [
                'nombre' => 'proveedores.eliminar',
                'modulo' => 'proveedores',
            ],

            /*
            |--------------------------------------------------------------------------
            | DISPONIBILIDAD
            |--------------------------------------------------------------------------
            */
            [
                'nombre' => 'disponibilidad.ver',
                'modulo' => 'disponibilidad',
            ],
            [
                'nombre' => 'disponibilidad.crear',
                'modulo' => 'disponibilidad',
            ],
            [
                'nombre' => 'disponibilidad.editar',
                'modulo' => 'disponibilidad',
            ],
            [
                'nombre' => 'disponibilidad.eliminar',
                'modulo' => 'disponibilidad',
            ],

            /*
            |--------------------------------------------------------------------------
            | CONTENIDO
            |--------------------------------------------------------------------------
            */
            [
                'nombre' => 'contenido.ver',
                'modulo' => 'contenido',
            ],
            [
                'nombre' => 'contenido.crear',
                'modulo' => 'contenido',
            ],
            [
                'nombre' => 'contenido.editar',
                'modulo' => 'contenido',
            ],
            [
                'nombre' => 'contenido.eliminar',
                'modulo' => 'contenido',
            ],

            /*
            |--------------------------------------------------------------------------
            | MULTIMEDIA
            |--------------------------------------------------------------------------
            */
            [
                'nombre' => 'multimedia.ver',
                'modulo' => 'multimedia',
            ],
            [
                'nombre' => 'multimedia.crear',
                'modulo' => 'multimedia',
            ],
            [
                'nombre' => 'multimedia.editar',
                'modulo' => 'multimedia',
            ],
            [
                'nombre' => 'multimedia.eliminar',
                'modulo' => 'multimedia',
            ],

            /*
            |--------------------------------------------------------------------------
            | CLIENTES
            |--------------------------------------------------------------------------
            */
            [
                'nombre' => 'clientes.ver',
                'modulo' => 'clientes',
            ],
            [
                'nombre' => 'clientes.crear',
                'modulo' => 'clientes',
            ],
            [
                'nombre' => 'clientes.editar',
                'modulo' => 'clientes',
            ],
            [
                'nombre' => 'clientes.eliminar',
                'modulo' => 'clientes',
            ],
        ];

        foreach ($permisos as $permiso) {
            Permiso::updateOrCreate(
                [
                    'nombre' => $permiso['nombre'],
                    'modulo' => $permiso['modulo'],
                ],
                $permiso
            );
        }
    }
}