<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de usuarios.
     *
     * La clave primaria es "id", generada por $table->id().
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            // Clave primaria: usuarios.id
            $table->id();

            // Información básica del usuario
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telefono', 20)->nullable();

            // Campos estándar de autenticación de Laravel
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            // Fechas de creación y actualización
            $table->timestamps();

            // Eliminación lógica
            $table->softDeletes();
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
