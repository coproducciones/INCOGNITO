<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de clientes.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {

            // Identificador único del cliente
            $table->id('id_cliente');

            // Información del cliente
            $table->string('nombre', 150);
            $table->string('empresa', 150)->nullable();

            // URL del logo, si el cliente tiene uno
            $table->string('logo_url', 255)->nullable();
        });
    }

    /**
     * Elimina la tabla de clientes.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
