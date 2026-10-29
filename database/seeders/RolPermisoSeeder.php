<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolPermisoSeeder extends Seeder
{
    /**
     * Asigna los permisos correspondientes a cada rol.
     */
    public function run(): void
    {
        $roles = Rol::query()
            ->get()
            ->keyBy('nombre');

        $permisos = Permiso::query()
            ->where('modulo', '!=', 'pagos')
            ->where('nombre', 'not like', 'pagos.%')
            ->get()
            ->keyBy('nombre');

        /*
         * ADMINISTRADOR
         *
         * Recibe todos los permisos vigentes.
         */
        if ($roles->has('Administrador')) {
            $roles->get('Administrador')
                ->permisos()
                ->sync($permisos->pluck('id_permiso')->all());
        }

        /*
         * CLIENTE
         *
         * Conserva los permisos conocidos del rol,
         * sin incluir permisos de pagos.
         */
        $permisosCliente = [
            'productos.ver',
            'categorias.ver',
            'pedidos.ver',
            'pedidos.crear',
            'resenas.ver',
            'resenas.crear',
        ];

        if ($roles->has('Cliente')) {
            $idsCliente = $permisos
                ->only($permisosCliente)
                ->pluck('id_permiso')
                ->all();

            $roles->get('Cliente')
                ->permisos()
                ->sync($idsCliente);
        }

        /*
         * PROVEEDOR
         *
         * Se conservan permisos de productos y disponibilidad.
         * No se incluyen permisos de pagos.
         */
        $permisosProveedor = [
            'productos.ver',
            'productos.crear',
            'productos.editar',
            'disponibilidad.ver',
            'disponibilidad.crear',
            'disponibilidad.editar',
        ];

        if ($roles->has('Proveedor')) {
            $idsProveedor = $permisos
                ->only($permisosProveedor)
                ->pluck('id_permiso')
                ->all();

            $roles->get('Proveedor')
                ->permisos()
                ->sync($idsProveedor);
        }

        /*
         * VISITANTE Y USUARIO AUTORIZADO
         *
         * Se mantienen sin permisos asignados por este seeder,
         * tal como estaba definido en la configuración revisada.
         */
        foreach (['Visitante', 'Usuario autorizado'] as $nombreRol) {
            if ($roles->has($nombreRol)) {
                $roles->get($nombreRol)
                    ->permisos()
                    ->sync([]);
            }
        }
    }
}
