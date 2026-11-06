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

                // Panel de gestión
                ['nombre' => 'dashboard.ver', 'modulo' => 'dashboard'],

                // Estados generales
                ['nombre' => 'estados.ver', 'modulo' => 'estados'],
                ['nombre' => 'estados.crear', 'modulo' => 'estados'],
                ['nombre' => 'estados.editar', 'modulo' => 'estados'],
                ['nombre' => 'estados.eliminar', 'modulo' => 'estados'],

                // Pedidos administrativos (separados de los pedidos personales).
                ['nombre' => 'pedidos.admin.ver', 'modulo' => 'pedidos'],
                ['nombre' => 'pedidos.admin.crear', 'modulo' => 'pedidos'],
                ['nombre' => 'pedidos.admin.editar', 'modulo' => 'pedidos'],
                ['nombre' => 'pedidos.admin.eliminar', 'modulo' => 'pedidos'],

                // Contacto con proveedores.
                ['nombre' => 'proveedores.contactar', 'modulo' => 'proveedores'],

                // Reseñas de productos del proveedor: consulta y respuesta,
                // sin permisos para modificar o eliminar la opinión del cliente.
                ['nombre' => 'proveedor.resenas.ver', 'modulo' => 'proveedor_resenas'],
                ['nombre' => 'proveedor.resenas.responder', 'modulo' => 'proveedor_resenas'],

                // Gestión de pedidos recibidos por el proveedor.
                ['nombre' => 'proveedor.pedidos.ver', 'modulo' => 'proveedor_pedidos'],
                ['nombre' => 'proveedor.pedidos.estado.actualizar', 'modulo' => 'proveedor_pedidos'],

                // Carrito de compras.
                ['nombre' => 'carrito.ver', 'modulo' => 'carrito'],
                ['nombre' => 'carrito.crear', 'modulo' => 'carrito'],
                ['nombre' => 'carrito.editar', 'modulo' => 'carrito'],
                ['nombre' => 'carrito.eliminar', 'modulo' => 'carrito'],

                // Perfil personal.
                ['nombre' => 'perfil.ver', 'modulo' => 'perfil'],
                ['nombre' => 'perfil.editar', 'modulo' => 'perfil'],

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
