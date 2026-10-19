<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega id_proveedor a productos sin reconstruir ni borrar las tablas.
     * Es nullable para permitir que los productos existentes sigan ahí
     * mientras se les asigna un proveedor desde el formulario de edición.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_proveedor')->nullable();

            $table->foreign('id_proveedor')
                ->references('id_proveedor')
                ->on('proveedor')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['id_proveedor']);
            $table->dropColumn('id_proveedor');
        });
    }
};
