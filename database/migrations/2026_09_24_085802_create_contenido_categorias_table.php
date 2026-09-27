<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('contenido_categorias', function (Blueprint $table) {
        $table->unsignedBigInteger('id_contenido');
        $table->unsignedBigInteger('id_categoria');

        // Claves foráneas
        $table->foreign('id_contenido')
              ->references('id_contenido')
              ->on('contenido')
              ->onDelete('cascade');

        $table->foreign('id_categoria')
              ->references('id')          // ajusta si la clave primaria de categorias es diferente
              ->on('categorias')
              ->onDelete('cascade');

        // Evitar duplicados
        $table->primary(['id_contenido', 'id_categoria']);
    });
}
    public function down(): void
{
    Schema::dropIfExists('contenido_categorias');
}
};
