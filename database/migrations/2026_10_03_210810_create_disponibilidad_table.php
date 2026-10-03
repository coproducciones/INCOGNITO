<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disponibilidad', function (Blueprint $table) {
            $table->id('id_disponibilidad');
            $table->unsignedBigInteger('id_proveedor');
            $table->date('fecha');
            $table->boolean('disponible');

            $table->unique(['id_proveedor', 'fecha']);

            $table->foreign('id_proveedor')
                ->references('id_proveedor')
                ->on('proveedor')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disponibilidad');
    }
};
