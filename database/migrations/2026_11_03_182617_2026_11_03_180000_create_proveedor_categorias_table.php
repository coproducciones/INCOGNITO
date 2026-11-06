<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la relación muchos a muchos entre proveedores y categorías.
     * No modifica ni elimina datos de las tablas existentes.
     */
    public function up(): void
    {
        Schema::create('proveedor_categorias', function (Blueprint $table) {
            $table->unsignedBigInteger('id_proveedor');
            $table->unsignedBigInteger('id_categoria');

            $table->foreign('id_proveedor')
                ->references('id_proveedor')
                ->on('proveedor')
                ->cascadeOnDelete();

            $table->foreign('id_categoria')
                ->references('id')
                ->on('categorias')
                ->cascadeOnDelete();

            $table->primary(['id_proveedor', 'id_categoria']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedor_categorias');
    }
};
