<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('id_cliente');

            /*
             * Una cuenta de usuario puede tener una ficha de cliente.
             * Se permite NULL para no romper registros de clientes
             * existentes durante el desarrollo del proyecto.
             */
            $table->foreignId('id_usuario')
                ->nullable()
                ->unique()
                ->constrained('usuarios', 'id')
                ->nullOnDelete();

            $table->string('nombre', 100);
            $table->string('empresa', 150)->nullable();
            $table->string('logo_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
