<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolPermisoSeeder extends Seeder
{
    /**
     * Asigna permisos por rol sin conceder permisos administrativos globales
     * a clientes o proveedores.
     */
    public function run(): void
    {
        $roles = Rol::query()->get()->keyBy(
            fn (Rol $rol) => mb_strtolower(trim($rol->nombre))
        );

        $permisos = Permiso::query()
            ->where('modulo', '!=', 'pagos')
            ->where('nombre', 'not like', 'pagos.%')
            ->get()
            ->keyBy('nombre');

        // Administrador: todos los permisos registrados.
        $this->sincronizar($roles, 'administrador', $permisos->pluck('id_permiso')->all());

        // Cliente: solo funciones personales y de compra.
        $permisosCliente = [
            'pedidos.ver',
            'pedidos.crear',
            'pedidos.editar',
            'pedidos.cancelar',
            'carrito.ver',
            'carrito.crear',
            'carrito.editar',
            'carrito.eliminar',
            'proveedores.contactar',
            'perfil.ver',
            'perfil.editar',
            'resenas.ver',
            'resenas.crear',
            'resenas.editar',
            'resenas.eliminar',
        ];
        $this->sincronizar($roles, 'cliente', $this->ids($permisos, $permisosCliente));

        // Proveedor: administra recursos propios; no recibe acceso global administrativo.
        $permisosProveedor = [
            'dashboard.ver',
            'productos.ver',
            'productos.crear',
            'productos.editar',
            'productos.eliminar',
            'contenido.ver',
            'contenido.crear',
            'contenido.editar',
            'contenido.eliminar',
            'multimedia.ver',
            'multimedia.crear',
            'multimedia.editar',
            'multimedia.eliminar',
            'proveedor.resenas.ver',
            'proveedor.resenas.responder',
            'disponibilidad.ver',
            'disponibilidad.crear',
            'disponibilidad.editar',
            'disponibilidad.eliminar',
            'proveedor.pedidos.ver',
            'proveedor.pedidos.estado.actualizar',
            'perfil.ver',
            'perfil.editar',
        ];
        $this->sincronizar($roles, 'proveedor', $this->ids($permisos, $permisosProveedor));

        // Usuario autorizado: acceso al panel, sin privilegios administrativos.
        $this->sincronizar(
            $roles,
            'usuario autorizado',
            $this->ids($permisos, ['dashboard.ver', 'perfil.ver', 'perfil.editar'])
        );
    }

    private function ids($permisos, array $nombres): array
    {
        return $permisos->whereIn('nombre', $nombres)->pluck('id_permiso')->all();
    }

    private function sincronizar($roles, string $nombre, array $ids): void
    {
        if ($roles->has($nombre)) {
            $roles->get($nombre)->permisos()->sync($ids);
        }
    }
}
