<?php

namespace Tests\Feature;

use App\Models\Pedido;
use App\Models\Rol;
use App\Models\Usuario;
use App\Models\EstadoGeneral;
use Database\Seeders\EstadoGeneralSeeder;
use Database\Seeders\PermisoSeeder;
use Database\Seeders\RolPermisoSeeder;
use Database\Seeders\RolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PedidoEventoTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Usuario
    {
        $this->seed([RolSeeder::class, PermisoSeeder::class, RolPermisoSeeder::class, EstadoGeneralSeeder::class]);

        return Usuario::create([
            'nombre' => 'Admin',
            'email' => 'admin-evento@test.local',
            'password' => 'ClaveSegura123',
            'id_rol' => Rol::where('nombre', 'Administrador')->value('id_rol'),
        ]);
    }

    public function test_admin_registra_un_evento_en_el_historial_del_pedido(): void
    {
        $admin = $this->admin();

        $pedido = Pedido::create([
            'id_usuario' => $admin->id,
            'total' => 0,
            'id_estado' => EstadoGeneral::query()->value('id_estado'),
            'fecha_pedido' => now(),
        ]);

        $this->actingAs($admin)
            ->post(route('pedidos.eventos.store', $pedido), [
                'tipo_evento' => 'nota',
                'comentario' => 'Cliente confirmó por WhatsApp.',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('pedido_evento', [
            'id_pedido' => $pedido->id_pedido,
            'tipo_evento' => 'nota',
        ]);
    }

    public function test_tipo_de_evento_es_obligatorio(): void
    {
        $admin = $this->admin();

        $pedido = Pedido::create([
            'id_usuario' => $admin->id,
            'total' => 0,
            'id_estado' => EstadoGeneral::query()->value('id_estado'),
            'fecha_pedido' => now(),
        ]);

        $this->actingAs($admin)
            ->post(route('pedidos.eventos.store', $pedido), ['comentario' => 'sin tipo'])
            ->assertSessionHasErrors('tipo_evento');
    }
}
