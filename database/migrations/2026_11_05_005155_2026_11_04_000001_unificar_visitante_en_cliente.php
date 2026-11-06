<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Unifica los usuarios registrados con rol Visitante dentro de Cliente.
 *
 * Los visitantes anónimos no se almacenan en usuarios y continúan
 * utilizando las rutas públicas sin autenticación.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function (): void {
            $cliente = DB::table('roles')
                ->whereRaw('LOWER(TRIM(nombre)) = ?', ['cliente'])
                ->first();

            if (!$cliente) {
                $clienteId = DB::table('roles')->insertGetId(
                    ['nombre' => 'Cliente'],
                    'id_rol'
                );
            } else {
                $clienteId = (int) $cliente->id_rol;
            }

            $visitante = DB::table('roles')
                ->whereRaw('LOWER(TRIM(nombre)) = ?', ['visitante'])
                ->first();

            if (!$visitante) {
                return;
            }

            $visitanteId = (int) $visitante->id_rol;

            // Primero se reasignan las cuentas para respetar la FK usuarios.id_rol.
            DB::table('usuarios')
                ->where('id_rol', $visitanteId)
                ->update(['id_rol' => $clienteId]);

            // Se eliminan las asignaciones del rol retirado.
            DB::table('rol_permiso')
                ->where('id_rol', $visitanteId)
                ->delete();

            // Finalmente se elimina el rol ya sin usuarios ni permisos.
            DB::table('roles')
                ->where('id_rol', $visitanteId)
                ->delete();
        });
    }

    public function down(): void
    {
        // La reversión recrea el rol, pero no mueve usuarios de Cliente
        // a Visitante porque no es posible distinguirlos de forma segura.
        $existe = DB::table('roles')
            ->where('nombre', 'Visitante')
            ->exists();

        if (!$existe) {
            DB::table('roles')->insert(['nombre' => 'Visitante']);
        }
    }
};
