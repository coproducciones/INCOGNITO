<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de usuarios.
     *
     * Relaciones:
     *
     * Usuario
     *   ├── pertenece a un Rol
     *   ├── pertenece a un Estado
     *   ├── puede tener muchos Pedidos
     *   └── puede tener muchas Reseñas
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {

            // =====================================================
            // CLAVE PRIMARIA
            // =====================================================

            $table->id();

            // =====================================================
            // INFORMACIÓN BÁSICA DEL USUARIO
            // =====================================================

            $table->string('nombre');

            $table->string('email')->unique();

            $table->string('password');

            $table->string('telefono', 20)->nullable();

            // =====================================================
            // RELACIÓN USUARIO → ROL
            // =====================================================

            /*
             * Un usuario puede tener un rol.
             *
             * Ejemplo:
             *
             * usuarios.id_rol = 1
             *       ↓
             * roles.id_rol = 1
             */
            $table->unsignedBigInteger('id_rol')
                ->nullable();

            // =====================================================
            // RELACIÓN USUARIO → ESTADO
            // =====================================================

            /*
             * Un usuario puede tener un estado.
             *
             * Ejemplo:
             *
             * usuarios.id_estado = 1
             *       ↓
             * estado_general.id_estado = 1
             */
            $table->unsignedBigInteger('id_estado')
                ->nullable();

            // =====================================================
            // CAMPOS ESTÁNDAR DE AUTENTICACIÓN DE LARAVEL
            // =====================================================

            $table->timestamp('email_verified_at')->nullable();

            $table->rememberToken();

            // =====================================================
            // FECHAS
            // =====================================================

            $table->timestamps();

            // =====================================================
            // ELIMINACIÓN LÓGICA
            // =====================================================

            $table->softDeletes();

            // =====================================================
            // FOREIGN KEY: USUARIO → ROL
            // =====================================================

            $table->foreign('id_rol')
                ->references('id_rol')
                ->on('roles')
                ->nullOnDelete();

            // =====================================================
            // FOREIGN KEY: USUARIO → ESTADO
            // =====================================================

            $table->foreign('id_estado')
                ->references('id_estado')
                ->on('estado_general')
                ->nullOnDelete();
        });
    }

    /**
     * Elimina la tabla de usuarios.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};

