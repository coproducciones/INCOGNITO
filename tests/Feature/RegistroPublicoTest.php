<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Proveedor;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistroPublicoTest extends TestCase
{
    // Ejecutar solo con la base de datos de pruebas configurada en phpunit.xml/.env.testing.
    use RefreshDatabase;

    private function crearRol(string $nombre): Rol
    {
        return Rol::firstOrCreate(['nombre' => $nombre]);
    }

    private function datosBase(array $sobrescribir = []): array
    {
        return array_merge([
            'nombre' => 'Persona Prueba',
            'email' => 'persona.prueba@example.test',
            'telefono' => '3001234567',
            'password' => 'ClaveSegura123',
            'password_confirmation' => 'ClaveSegura123',
            'tipo_cuenta' => 'visitante',
            'acepta_terminos' => '1',
        ], $sobrescribir);
    }

    public function test_visitante_se_registra_sin_ficha_de_cliente_ni_proveedor(): void
    {
        $this->crearRol('Visitante');

        $response = $this->post(route('registro.store'), $this->datosBase());

        $response->assertRedirect(route('mi-cuenta'));
        $this->assertDatabaseHas('usuarios', [
            'email' => 'persona.prueba@example.test',
            'id_rol' => Rol::where('nombre', 'Visitante')->value('id_rol'),
        ]);
        $usuario = Usuario::where('email', 'persona.prueba@example.test')->firstOrFail();
        $this->assertAuthenticatedAs($usuario);
        $this->assertDatabaseMissing('clientes', ['id_usuario' => $usuario->id]);
        $this->assertDatabaseMissing('proveedor', ['id_usuario' => $usuario->id]);
        $this->assertTrue(Hash::check('ClaveSegura123', $usuario->password));
    }

    public function test_cliente_crea_usuario_y_ficha_de_cliente(): void
    {
        $this->crearRol('Cliente');

        $response = $this->post(route('registro.store'), $this->datosBase([
            'email' => 'cliente@example.test',
            'tipo_cuenta' => 'cliente',
            'empresa' => 'Empresa de prueba',
        ]));

        $response->assertRedirect(route('mi-cuenta'));
        $usuario = Usuario::where('email', 'cliente@example.test')->firstOrFail();
        $this->assertDatabaseHas('clientes', [
            'id_usuario' => $usuario->id,
            'nombre' => 'Persona Prueba',
            'empresa' => 'Empresa de prueba',
        ]);
        $this->assertDatabaseMissing('proveedor', ['id_usuario' => $usuario->id]);
    }

    public function test_proveedor_crea_usuario_y_ficha_de_proveedor(): void
    {
        $this->crearRol('Proveedor');

        $response = $this->post(route('registro.store'), $this->datosBase([
            'email' => 'proveedor@example.test',
            'tipo_cuenta' => 'proveedor',
            'especialidad' => 'Diseño gráfico',
            'whatsapp' => '573001234567',
            'descripcion' => 'Servicios de diseño',
        ]));

        $response->assertRedirect(route('mi-cuenta'));
        $usuario = Usuario::where('email', 'proveedor@example.test')->firstOrFail();
        $this->assertDatabaseHas('proveedor', [
            'id_usuario' => $usuario->id,
            'especialidad' => 'Diseño gráfico',
            'telefono' => '3001234567',
            'whatsapp' => '573001234567',
        ]);
        $this->assertDatabaseMissing('clientes', ['id_usuario' => $usuario->id]);
    }

    public function test_no_permite_registrar_cuenta_administradora(): void
    {
        $this->crearRol('Administrador');

        $response = $this->post(route('registro.store'), $this->datosBase([
            'tipo_cuenta' => 'administrador',
            'email' => 'noadmin@example.test',
        ]));

        $response->assertSessionHasErrors('tipo_cuenta');
        $this->assertDatabaseMissing('usuarios', ['email' => 'noadmin@example.test']);
    }

    public function test_no_acepta_correo_duplicado_ignorando_mayusculas(): void
    {
        $this->crearRol('Visitante');
        Usuario::create([
            'nombre' => 'Ya existe',
            'email' => 'existente@example.test',
            'password' => 'ClaveSegura123',
            'id_rol' => Rol::where('nombre', 'Visitante')->value('id_rol'),
        ]);

        $response = $this->post(route('registro.store'), $this->datosBase([
            'email' => '  EXISTENTE@example.test ',
        ]));

        $response->assertSessionHasErrors('email');
        $this->assertSame(1, Usuario::where('email', 'existente@example.test')->count());
    }
}
