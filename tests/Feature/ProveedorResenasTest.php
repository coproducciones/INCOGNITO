<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Permiso;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Reseña;
use App\Models\Rol;
use App\Models\Usuario;
use Database\Seeders\PermisoSeeder;
use Database\Seeders\RolPermisoSeeder;
use Database\Seeders\RolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Reseñas de los productos del proveedor: consultar y responder.
 */
class ProveedorResenasTest extends TestCase
{
    use RefreshDatabase;

    private Usuario $cliente;
    private Usuario $provA;
    private Usuario $provSinFicha;
    private Producto $productoA;
    private Producto $productoB;
    private Reseña $resenaA;
    private Reseña $resenaB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RolSeeder::class, PermisoSeeder::class, RolPermisoSeeder::class]);

        // El permiso de responder se asegura aquí para que la prueba no dependa del seeder.
        $permiso = Permiso::firstOrCreate(
            ['nombre' => 'proveedor.resenas.responder'],
            ['modulo' => 'proveedor_resenas']
        );
        Rol::where('nombre', 'Proveedor')->first()
            ->permisos()->syncWithoutDetaching([$permiso->id_permiso]);

        $categoria = Categoria::create(['nombre' => 'Audiovisual', 'descripcion' => 'x']);

        $this->cliente = $this->usuario('Cliente Ana', 'ana@test.local', 'Cliente');
        $this->provA = $this->usuario('Proveedor A', 'a@test.local', 'Proveedor');
        $provB = $this->usuario('Proveedor B', 'b@test.local', 'Proveedor');
        $this->provSinFicha = $this->usuario('Sin ficha', 'sf@test.local', 'Proveedor');

        $fichaA = $this->ficha($this->provA);
        $fichaB = $this->ficha($provB);

        $this->productoA = $this->producto($categoria, 'Fotografía de A', $fichaA->id_proveedor);
        $this->productoB = $this->producto($categoria, 'Logo de B', $fichaB->id_proveedor);

        $this->resenaA = $this->resena($this->productoA, 'Excelente trabajo de A');
        $this->resenaB = $this->resena($this->productoB, 'Buen logo de B');
    }

    private function usuario(string $nombre, string $email, string $rol): Usuario
    {
        return Usuario::create([
            'nombre' => $nombre,
            'email' => $email,
            'password' => 'ClaveSegura123',
            'id_rol' => Rol::where('nombre', $rol)->value('id_rol'),
        ]);
    }

    private function ficha(Usuario $usuario): Proveedor
    {
        return Proveedor::create([
            'id_usuario' => $usuario->id,
            'especialidad' => 'Diseño',
            'telefono' => '3000000000',
        ]);
    }

    private function producto(Categoria $categoria, string $nombre, int $idProveedor): Producto
    {
        return Producto::create([
            'categoria_id' => $categoria->id,
            'id_proveedor' => $idProveedor,
            'nombre' => $nombre,
            'descripcion' => 'x',
            'precio' => 1000,
            'stock' => 1,
            'activo' => true,
        ]);
    }

    private function resena(Producto $producto, string $comentario): Reseña
    {
        $datos = [
            'id_usuario' => $this->cliente->id,
            'id_producto' => $producto->id,
            'calificacion' => 5,
            'comentario' => $comentario,
            'fecha' => now(),
        ];

        // Según la versión de la base, la reseña puede exigir id_cliente.
        if (Schema::hasColumn('reseña', 'id_cliente')) {
            $datos['id_cliente'] = Cliente::firstOrCreate(
                ['id_usuario' => $this->cliente->id],
                ['nombre' => 'Cliente Ana']
            )->getKey();
        }

        return Reseña::create($datos);
    }

    public function test_visitante_es_enviado_al_login(): void
    {
        $this->get(route('proveedor.resenas.index'))->assertRedirect(route('login'));

        $this->patch(route('proveedor.resenas.responder', $this->resenaA), ['respuesta' => 'Gracias'])
            ->assertRedirect(route('login'));
    }

    public function test_cliente_no_accede_a_las_reseñas_del_proveedor(): void
    {
        $this->actingAs($this->cliente)->get(route('proveedor.resenas.index'))->assertForbidden();
    }

    public function test_proveedor_sin_ficha_recibe_403(): void
    {
        $this->actingAs($this->provSinFicha)->get(route('proveedor.resenas.index'))->assertForbidden();
    }

    public function test_proveedor_ve_solo_las_reseñas_de_sus_productos(): void
    {
        $this->actingAs($this->provA)->get(route('proveedor.resenas.index'))
            ->assertOk()
            ->assertSee('Excelente trabajo de A')
            ->assertSee('Fotografía de A')
            ->assertDontSee('Buen logo de B');
    }

    public function test_proveedor_responde_una_reseña_de_su_producto(): void
    {
        $this->actingAs($this->provA)
            ->patch(route('proveedor.resenas.responder', $this->resenaA), [
                'respuesta' => 'Gracias por tu opinión.',
            ])
            ->assertRedirect(route('proveedor.resenas.index'))
            ->assertSessionHas('success');

        $this->assertSame('Gracias por tu opinión.', $this->resenaA->fresh()->respuesta);
        // La opinión original no cambia.
        $this->assertSame('Excelente trabajo de A', $this->resenaA->fresh()->comentario);
        $this->assertSame(5, $this->resenaA->fresh()->calificacion);
    }

    public function test_proveedor_no_puede_responder_reseñas_de_otro_proveedor(): void
    {
        $this->actingAs($this->provA)
            ->patch(route('proveedor.resenas.responder', $this->resenaB), [
                'respuesta' => 'Intento ajeno',
            ]);

        $this->assertNull($this->resenaB->fresh()->respuesta);
    }

    public function test_la_respuesta_es_obligatoria(): void
    {
        $this->actingAs($this->provA)
            ->patch(route('proveedor.resenas.responder', $this->resenaA), ['respuesta' => ''])
            ->assertSessionHasErrors('respuesta');

        $this->assertNull($this->resenaA->fresh()->respuesta);
    }
}
