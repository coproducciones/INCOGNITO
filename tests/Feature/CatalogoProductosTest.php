<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Permiso;
use App\Models\Reseña;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Rol;
use App\Models\Usuario;
use Database\Seeders\PermisoSeeder;
use Database\Seeders\RolPermisoSeeder;
use Database\Seeders\RolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Catálogo público (Servicios), gestión administrativa de productos y
 * "Mis productos" del proveedor.
 */
class CatalogoProductosTest extends TestCase
{
    use RefreshDatabase;

    private Categoria $categoria;
    private Usuario $admin;
    private Usuario $cliente;
    private Usuario $provA;
    private Usuario $provB;
    private Usuario $provSinFicha;
    private Proveedor $fichaA;
    private Proveedor $fichaB;
    private Producto $pA1;
    private Producto $pA2Inactivo;
    private Producto $pB1;
    private Producto $pSinProveedor;
    private Producto $pProveedorEliminado;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RolSeeder::class, PermisoSeeder::class, RolPermisoSeeder::class]);

        // Regla del proyecto: el proveedor puede eliminar sus propios productos.
        $eliminar = Permiso::firstOrCreate(
            ['nombre' => 'productos.eliminar'],
            ['modulo' => 'productos']
        );
        Rol::where('nombre', 'Proveedor')->first()
            ->permisos()->syncWithoutDetaching([$eliminar->id_permiso]);

        $this->categoria = Categoria::create(['nombre' => 'Audiovisual', 'descripcion' => 'Foto y video']);

        $this->admin = $this->usuario('Admin', 'admin@test.local', 'Administrador');
        $this->cliente = $this->usuario('Cliente', 'cliente@test.local', 'Cliente');
        $this->provA = $this->usuario('Proveedor A', 'a@test.local', 'Proveedor');
        $this->provB = $this->usuario('Proveedor B', 'b@test.local', 'Proveedor');
        $this->provSinFicha = $this->usuario('Proveedor sin ficha', 'sf@test.local', 'Proveedor');

        $this->fichaA = $this->ficha($this->provA, '3114445566');
        $this->fichaB = $this->ficha($this->provB, '573000000001');
        $fichaEliminada = $this->ficha($this->usuario('Prov borrado', 'x@test.local', 'Proveedor'), '573000000002');

        $this->pA1 = $this->producto('Fotografía A1', $this->fichaA->id_proveedor, true);
        $this->pA2Inactivo = $this->producto('Video A2 inactivo', $this->fichaA->id_proveedor, false);
        $this->pB1 = $this->producto('Logo B1', $this->fichaB->id_proveedor, true);
        $this->pSinProveedor = $this->producto('Servicio propio sin proveedor', null, true);
        $this->pProveedorEliminado = $this->producto('Producto de proveedor eliminado', $fichaEliminada->id_proveedor, true);

        $fichaEliminada->delete(); // SoftDeletes
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

    private function ficha(Usuario $usuario, string $whatsapp): Proveedor
    {
        return Proveedor::create([
            'id_usuario' => $usuario->id,
            'especialidad' => 'Fotografía',
            'telefono' => '3000000000',
            'whatsapp' => $whatsapp,
        ]);
    }

    private function producto(string $nombre, ?int $idProveedor, bool $activo): Producto
    {
        return Producto::create([
            'categoria_id' => $this->categoria->id,
            'id_proveedor' => $idProveedor,
            'nombre' => $nombre,
            'descripcion' => 'Descripción de ' . $nombre,
            'precio' => 100000,
            'stock' => 5,
            'activo' => $activo,
        ]);
    }

    // ------------------------------------------------------------------
    // Visitante
    // ------------------------------------------------------------------

    public function test_visitante_ve_solo_productos_publicos_con_whatsapp_del_proveedor(): void
    {
        $r = $this->get(route('servicios'));

        $r->assertOk();
        $r->assertSee('Fotografía A1');
        $r->assertSee('Logo B1');
        $r->assertSee('Servicio propio sin proveedor');
        $r->assertDontSee('Video A2 inactivo');
        $r->assertDontSee('Producto de proveedor eliminado');

        // WhatsApp del proveedor (celular de 10 dígitos recibe indicativo 57).
        $r->assertSee('https://wa.me/573114445566?text=', false);
        // Sin proveedor: número de la empresa.
        $r->assertSee('https://wa.me/' . config('services.whatsapp.empresa_numero') . '?text=', false);

        // Sin acciones de gestión.
        $r->assertDontSee('Crear producto');
        $r->assertDontSee('Mis productos');
        $r->assertDontSee('Gestión de productos');
        $r->assertDontSee(route('productos.edit', $this->pA1), false);
    }

    public function test_detalle_publico_oculta_inactivos_y_de_proveedor_eliminado(): void
    {
        $this->get(route('servicios.detalle', $this->pA1))
            ->assertOk()
            ->assertSee('https://wa.me/573114445566?text=', false);

        $this->get(route('servicios.detalle', $this->pA2Inactivo))->assertNotFound();
        $this->get(route('servicios.detalle', $this->pProveedorEliminado))->assertNotFound();
        $this->get(route('servicios.detalle', $this->pSinProveedor))->assertOk();
    }

    public function test_visitante_no_accede_a_zonas_de_gestion(): void
    {
        $this->get(route('productos.index'))->assertRedirect(route('login'));
        $this->get(route('mis-productos.index'))->assertRedirect(route('login'));
        $this->get(route('productos.create'))->assertRedirect(route('login'));
    }

    // ------------------------------------------------------------------
    // Cliente
    // ------------------------------------------------------------------

    public function test_cliente_ve_el_catalogo_pero_no_gestiona_productos(): void
    {
        $this->actingAs($this->cliente)->get(route('servicios'))
            ->assertOk()
            ->assertDontSee('Crear producto')
            ->assertDontSee('Mis productos');

        $this->actingAs($this->cliente)->get(route('productos.index'))->assertForbidden();
        $this->actingAs($this->cliente)->get(route('mis-productos.index'))->assertForbidden();
    }

    // ------------------------------------------------------------------
    // Proveedor
    // ------------------------------------------------------------------

    public function test_proveedor_no_entra_al_listado_administrativo(): void
    {
        $this->actingAs($this->provA)->get(route('productos.index'))->assertForbidden();
    }

    public function test_proveedor_ve_solo_sus_productos_en_mis_productos(): void
    {
        $r = $this->actingAs($this->provA)->get(route('mis-productos.index'));

        $r->assertOk();
        $r->assertSee('Fotografía A1');
        $r->assertSee('Video A2 inactivo');
        $r->assertSee('Inactivo');
        $r->assertDontSee('Logo B1');
        $r->assertDontSee('Servicio propio sin proveedor');
        $r->assertSee(route('productos.create'), false);
    }

    public function test_proveedor_ve_crear_y_editar_solo_en_sus_productos_dentro_de_servicios(): void
    {
        $r = $this->actingAs($this->provA)->get(route('servicios'));

        $r->assertOk();
        $r->assertSee('Crear producto');
        $r->assertSee('Mis productos');
        $r->assertSee(route('productos.edit', $this->pA1), false);
        $r->assertDontSee(route('productos.edit', $this->pB1), false);
        $r->assertDontSee(route('productos.edit', $this->pSinProveedor), false);
    }

    public function test_proveedor_no_puede_ver_editar_ni_cambiar_productos_ajenos(): void
    {
        $u = $this->provA;

        $this->actingAs($u)->get(route('productos.show', $this->pB1))->assertNotFound();
        $this->actingAs($u)->get(route('productos.edit', $this->pB1))->assertNotFound();
        $this->actingAs($u)->patch(route('productos.estado', $this->pB1))->assertNotFound();
        $this->actingAs($u)->put(route('productos.update', $this->pB1), [
            'id_proveedor' => $this->fichaA->id_proveedor,
            'categoria_id' => $this->categoria->id,
            'nombre' => 'Hackeado',
            'precio' => 1,
            'stock' => 1,
        ])->assertNotFound();

        $this->assertSame('Logo B1', $this->pB1->fresh()->nombre);
    }

    public function test_proveedor_crea_producto_siempre_con_su_propia_ficha(): void
    {
        $r = $this->actingAs($this->provA)->post(route('productos.store'), [
            // Intento de crear a nombre de otro proveedor: se ignora.
            'id_proveedor' => $this->fichaB->id_proveedor,
            'categoria_id' => $this->categoria->id,
            'nombre' => 'Nuevo producto de A',
            'descripcion' => 'x',
            'precio' => 50000,
            'stock' => 3,
            'activo' => 1,
        ]);

        $r->assertRedirect(route('mis-productos.index'));

        $this->assertDatabaseHas('productos', [
            'nombre' => 'Nuevo producto de A',
            'id_proveedor' => $this->fichaA->id_proveedor,
        ]);
    }

    public function test_proveedor_edita_su_producto_y_vuelve_a_mis_productos(): void
    {
        $r = $this->actingAs($this->provA)->put(route('productos.update', $this->pA1), [
            'id_proveedor' => $this->fichaA->id_proveedor,
            'categoria_id' => $this->categoria->id,
            'nombre' => 'Fotografía A1 editada',
            'descripcion' => 'x',
            'precio' => 120000,
            'stock' => 4,
            'activo' => 1,
        ]);

        $r->assertRedirect(route('mis-productos.index'));
        $this->assertSame('Fotografía A1 editada', $this->pA1->fresh()->nombre);
    }

    public function test_proveedor_activa_y_desactiva_su_producto(): void
    {
        $this->actingAs($this->provA)->patch(route('productos.estado', $this->pA1))
            ->assertRedirect();
        $this->assertFalse($this->pA1->fresh()->activo);

        $this->actingAs($this->provA)->patch(route('productos.estado', $this->pA1));
        $this->assertTrue($this->pA1->fresh()->activo);

        // El resto de campos no cambia.
        $this->assertSame('Fotografía A1', $this->pA1->fresh()->nombre);
        $this->assertSame($this->fichaA->id_proveedor, (int) $this->pA1->fresh()->id_proveedor);
    }

    public function test_proveedor_elimina_su_propio_producto(): void
    {
        $this->actingAs($this->provA)
            ->delete(route('productos.destroy', $this->pA1))
            ->assertRedirect(route('mis-productos.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('productos', ['id' => $this->pA1->id]);
        // Los productos de otros proveedores no se tocan.
        $this->assertDatabaseHas('productos', ['id' => $this->pB1->id]);
    }

    public function test_proveedor_no_puede_eliminar_productos_ajenos(): void
    {
        $this->actingAs($this->provA)
            ->delete(route('productos.destroy', $this->pB1))
            ->assertNotFound();

        $this->assertDatabaseHas('productos', ['id' => $this->pB1->id]);
    }

    public function test_eliminar_un_producto_con_resenas_muestra_error_y_no_lo_borra(): void
    {
        $datos = [
            'id_usuario' => $this->cliente->id,
            'id_producto' => $this->pA1->id,
            'calificacion' => 5,
            'comentario' => 'Muy bueno',
            'fecha' => now(),
        ];

        if (Schema::hasColumn('reseña', 'id_cliente')) {
            $datos['id_cliente'] = Cliente::firstOrCreate(
                ['id_usuario' => $this->cliente->id],
                ['nombre' => 'Cliente']
            )->getKey();
        }

        Reseña::create($datos);

        $this->actingAs($this->provA)
            ->delete(route('productos.destroy', $this->pA1))
            ->assertRedirect(route('mis-productos.index'))
            ->assertSessionHasErrors('producto');

        $this->assertDatabaseHas('productos', ['id' => $this->pA1->id]);
    }

    public function test_mis_productos_muestra_eliminar_solo_en_productos_propios(): void
    {
        $r = $this->actingAs($this->provA)->get(route('mis-productos.index'));

        $r->assertOk();
        $r->assertSee(route('productos.destroy', $this->pA1), false);
        $r->assertDontSee(route('productos.destroy', $this->pB1), false);
    }

    public function test_proveedor_sin_ficha_es_enviado_a_completar_su_perfil(): void
    {
        $this->actingAs($this->provSinFicha)->get(route('mis-productos.index'))
            ->assertRedirect(route('proveedores.mi-perfil.create'));

        $this->actingAs($this->provSinFicha)->get(route('servicios'))
            ->assertOk()
            ->assertDontSee('Crear producto');
    }

    // ------------------------------------------------------------------
    // Administrador
    // ------------------------------------------------------------------

    public function test_admin_ve_todos_los_productos_en_gestion(): void
    {
        $r = $this->actingAs($this->admin)->get(route('productos.index'));

        $r->assertOk();
        $r->assertSee('Gestión de productos');
        foreach (['Fotografía A1', 'Video A2 inactivo', 'Logo B1', 'Servicio propio sin proveedor'] as $nombre) {
            $r->assertSee($nombre);
        }
    }

    public function test_admin_ve_enlace_de_gestion_en_servicios_y_edita_cualquier_producto(): void
    {
        $r = $this->actingAs($this->admin)->get(route('servicios'));

        $r->assertOk();
        $r->assertSee('Gestión de productos');
        $r->assertSee(route('productos.edit', $this->pB1), false);

        $this->actingAs($this->admin)->get(route('productos.edit', $this->pB1))->assertOk();
    }

    public function test_admin_vuelve_al_listado_administrativo_tras_guardar(): void
    {
        $r = $this->actingAs($this->admin)->post(route('productos.store'), [
            'id_proveedor' => $this->fichaB->id_proveedor,
            'categoria_id' => $this->categoria->id,
            'nombre' => 'Producto creado por admin',
            'precio' => 10,
            'stock' => 1,
            'activo' => 1,
        ]);

        $r->assertRedirect(route('productos.index'));
        $this->assertDatabaseHas('productos', [
            'nombre' => 'Producto creado por admin',
            'id_proveedor' => $this->fichaB->id_proveedor,
        ]);
    }

    // ------------------------------------------------------------------
    // Menú
    // ------------------------------------------------------------------

    public function test_menu_muestra_el_enlace_correcto_segun_el_rol(): void
    {
        $this->actingAs($this->provA)->get(route('nuestra.historia'))
            ->assertSee(route('mis-productos.index'), false)
            ->assertDontSee(route('productos.index'), false);

        $this->actingAs($this->admin)->get(route('nuestra.historia'))
            ->assertSee(route('productos.index'), false);
    }
}
