<?php

namespace Tests\Feature;

use App\Models\Proveedor;
use App\Models\Rol;
use App\Models\Usuario;
use Database\Seeders\PermisoSeeder;
use Database\Seeders\RolPermisoSeeder;
use Database\Seeders\RolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProveedorAdminShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_ve_el_detalle_de_un_proveedor(): void
    {
        $this->seed([RolSeeder::class, PermisoSeeder::class, RolPermisoSeeder::class]);

        $admin = Usuario::create([
            'nombre' => 'Admin',
            'email' => 'admin-show@test.local',
            'password' => 'ClaveSegura123',
            'id_rol' => Rol::where('nombre', 'Administrador')->value('id_rol'),
        ]);

        $usuarioProveedor = Usuario::create([
            'nombre' => 'Laura Fotógrafa',
            'email' => 'laura@test.local',
            'password' => 'ClaveSegura123',
            'id_rol' => Rol::where('nombre', 'Proveedor')->value('id_rol'),
        ]);

        $proveedor = Proveedor::create([
            'id_usuario' => $usuarioProveedor->id,
            'especialidad' => 'Fotografía de eventos',
            'telefono' => '3001112233',
            'whatsapp' => '3114445566',
            'descripcion' => 'Cobertura de eventos deportivos.',
        ]);

        $this->actingAs($admin)
            ->get(route('proveedores.show', $proveedor))
            ->assertOk()
            ->assertSee('Laura Fotógrafa')
            ->assertSee('Fotografía de eventos')
            ->assertSee('https://wa.me/573114445566', false);
    }

    public function test_un_cliente_no_ve_el_detalle_administrativo(): void
    {
        $this->seed([RolSeeder::class, PermisoSeeder::class, RolPermisoSeeder::class]);

        $cliente = Usuario::create([
            'nombre' => 'Cliente',
            'email' => 'cliente-show@test.local',
            'password' => 'ClaveSegura123',
            'id_rol' => Rol::where('nombre', 'Cliente')->value('id_rol'),
        ]);

        $usuarioProveedor = Usuario::create([
            'nombre' => 'Prov',
            'email' => 'prov-show@test.local',
            'password' => 'ClaveSegura123',
            'id_rol' => Rol::where('nombre', 'Proveedor')->value('id_rol'),
        ]);

        $proveedor = Proveedor::create([
            'id_usuario' => $usuarioProveedor->id,
            'especialidad' => 'Diseño',
            'telefono' => '3000000000',
        ]);

        $this->actingAs($cliente)
            ->get(route('proveedores.show', $proveedor))
            ->assertForbidden();
    }
}
