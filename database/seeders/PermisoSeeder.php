<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Registra los permisos disponibles en el sistema.
     *
     * El módulo de pagos no forma parte del proyecto.
     * Se eliminan sus permisos antiguos y sus asignaciones.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            // Obtener todos los permisos antiguos del módulo pagos.
            $idsPagos = Permiso::query()
                ->where('modulo', 'pagos')
                ->orWhere('nombre', 'like', 'pagos.%')
                ->pluck('id_permiso');

            // Eliminar primero las asignaciones individuales.
            if ($idsPagos->isNotEmpty()) {
                DB::table('usuario_permiso')
                    ->whereIn('id_permiso', $idsPagos)
                    ->delete();

                // Eliminar las asignaciones a roles.
                DB::table('rol_permiso')
                    ->whereIn('id_permiso', $idsPagos)
                    ->delete();

                // Eliminar los permisos obsoletos.
                Permiso::query()
                    ->whereIn('id_permiso', $idsPagos)
                    ->delete();
            }

            /*
             * Permisos vigentes.
             *
             * Se utiliza el nombre como identificador para evitar
             * crear duplicados al ejecutar el seeder nuevamente.
             */
            $permisos = [
                // Usuarios
                ['nombre' => 'usuarios.ver', 'modulo' => 'usuarios'],
                ['nombre' => 'usuarios.crear', 'modulo' => 'usuarios'],
                ['nombre' => 'usuarios.editar', 'modulo' => 'usuarios'],
                ['nombre' => 'usuarios.eliminar', 'modulo' => 'usuarios'],

                // Roles
                ['nombre' => 'roles.ver', 'modulo' => 'roles'],
                ['nombre' => 'roles.crear', 'modulo' => 'roles'],
                ['nombre' => 'roles.editar', 'modulo' => 'roles'],
                ['nombre' => 'roles.eliminar', 'modulo' => 'roles'],

                // Permisos
                ['nombre' => 'permisos.ver', 'modulo' => 'permisos'],
                ['nombre' => 'permisos.crear', 'modulo' => 'permisos'],
                ['nombre' => 'permisos.editar', 'modulo' => 'permisos'],
                ['nombre' => 'permisos.eliminar', 'modulo' => 'permisos'],

                // Productos
                ['nombre' => 'productos.ver', 'modulo' => 'productos'],
                ['nombre' => 'productos.crear', 'modulo' => 'productos'],
                ['nombre' => 'productos.editar', 'modulo' => 'productos'],
                ['nombre' => 'productos.eliminar', 'modulo' => 'productos'],

                // Categorías
                ['nombre' => 'categorias.ver', 'modulo' => 'categorias'],
                ['nombre' => 'categorias.crear', 'modulo' => 'categorias'],
                ['nombre' => 'categorias.editar', 'modulo' => 'categorias'],
                ['nombre' => 'categorias.eliminar', 'modulo' => 'categorias'],

                // Pedidos
                ['nombre' => 'pedidos.ver', 'modulo' => 'pedidos'],
                ['nombre' => 'pedidos.crear', 'modulo' => 'pedidos'],
                ['nombre' => 'pedidos.editar', 'modulo' => 'pedidos'],
                ['nombre' => 'pedidos.cancelar', 'modulo' => 'pedidos'],

                // Reseñas
                ['nombre' => 'resenas.ver', 'modulo' => 'resenas'],
                ['nombre' => 'resenas.crear', 'modulo' => 'resenas'],
                ['nombre' => 'resenas.editar', 'modulo' => 'resenas'],
                ['nombre' => 'resenas.eliminar', 'modulo' => 'resenas'],

                // Proveedores
                ['nombre' => 'proveedores.ver', 'modulo' => 'proveedores'],
                ['nombre' => 'proveedores.crear', 'modulo' => 'proveedores'],
                ['nombre' => 'proveedores.editar', 'modulo' => 'proveedores'],
                ['nombre' => 'proveedores.eliminar', 'modulo' => 'proveedores'],

                // Disponibilidad
                ['nombre' => 'disponibilidad.ver', 'modulo' => 'disponibilidad'],
                ['nombre' => 'disponibilidad.crear', 'modulo' => 'disponibilidad'],
                ['nombre' => 'disponibilidad.editar', 'modulo' => 'disponibilidad'],
                ['nombre' => 'disponibilidad.eliminar', 'modulo' => 'disponibilidad'],

                // Contenido
                ['nombre' => 'contenido.ver', 'modulo' => 'contenido'],
                ['nombre' => 'contenido.crear', 'modulo' => 'contenido'],
                ['nombre' => 'contenido.editar', 'modulo' => 'contenido'],
                ['nombre' => 'contenido.eliminar', 'modulo' => 'contenido'],

                // Multimedia
                ['nombre' => 'multimedia.ver', 'modulo' => 'multimedia'],
                ['nombre' => 'multimedia.crear', 'modulo' => 'multimedia'],
                ['nombre' => 'multimedia.editar', 'modulo' => 'multimedia'],
                ['nombre' => 'multimedia.eliminar', 'modulo' => 'multimedia'],

                // Clientes
                ['nombre' => 'clientes.ver', 'modulo' => 'clientes'],
                ['nombre' => 'clientes.crear', 'modulo' => 'clientes'],
                ['nombre' => 'clientes.editar', 'modulo' => 'clientes'],
                ['nombre' => 'clientes.eliminar', 'modulo' => 'clientes'],
            ];

            foreach ($permisos as $permiso) {
                Permiso::updateOrCreate(
                    ['nombre' => $permiso['nombre']],
                    ['modulo' => $permiso['modulo']]
                );
            }
        });
    }
}
