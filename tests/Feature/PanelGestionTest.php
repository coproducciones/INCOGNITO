<?php

namespace Tests\Feature;

use App\Models\Permiso;
use App\Models\Rol;
use App\Models\Usuario;
use Database\Seeders\PermisoSeeder;
use Database\Seeders\RolPermisoSeeder;
use Database\Seeders\RolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * El panel de gestión solo enlaza módulos que el usuario puede abrir.
 */
class PanelGestionTest extends TestCase
{
    use RefreshDatabase;

    private function usuario(string $rol, string $email): Usuario
    {
        return Usuario::create([
            'nombre' => $rol,
            'email' => $email,
            'password' => 'ClaveSegura123',
            'id_rol' => Rol::where('nombre', $rol)->value('id_rol'),
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RolSeeder::class, PermisoSeeder::class, RolPermisoSeeder::class]);

        // El proveedor entra al panel (dashboard.ver) sin depender del seeder.
        $permiso = Permiso::firstOrCreate(['nombre' => 'dashboard.ver'], ['modulo' => 'dashboard']);
        Rol::where('nombre', 'Proveedor')->first()
            ->permisos()->syncWithoutDetaching([$permiso->id_permiso]);
    }

    public function test_el_proveedor_solo_ve_los_modulos_que_puede_abrir(): void
    {
        $r = $this->actingAs($this->usuario('Proveedor', 'p@test.local'))
            ->get(route('dashboard.gestion'));

        $r->assertOk();
        $r->assertSee(route('mis-productos.index'), false);
        $r->assertDontSee(route('productos.index'), false);

        // Módulos administrativos que darían 403 al proveedor.
        $r->assertDontSee('Seguridad de usuarios');
        $r->assertDontSee('Estados generales');
        $r->assertDontSee(route('roles.index'), false);
        $r->assertDontSee(route('permisos.index'), false);
    }

    public function test_el_administrador_ve_todos_los_modulos(): void
    {
        $r = $this->actingAs($this->usuario('Administrador', 'a@test.local'))
            ->get(route('dashboard.gestion'));

        $r->assertOk();
        $r->assertSee(route('productos.index'), false);
        $r->assertSee('Seguridad de usuarios');
        $r->assertSee('Estados generales');
        $r->assertSee(route('roles.index'), false);
        $r->assertSee(route('permisos.index'), false);
    }
}
