<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega la relación con proveedores si la columna no existe.
     */
    public function up(): void
    {
        if (Schema::hasColumn('productos', 'id_proveedor')) {
            return;
        }

        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_proveedor')->nullable();

            $table->foreign('id_proveedor')
                ->references('id_proveedor')
                ->on('proveedor')
                ->nullOnDelete();
        });
    }

    /**
     * No elimina la columna para proteger datos preexistentes.
     */
    public function down(): void
    {
        // La columna podría existir antes de esta migración.
        // No la eliminamos automáticamente para evitar pérdida de datos.
    }
};
