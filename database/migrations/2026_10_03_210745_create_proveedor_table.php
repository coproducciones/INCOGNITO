<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedor', function (Blueprint $table) {
            $table->id('id_proveedor');
            $table->unsignedBigInteger('id_usuario')->unique();
            $table->string('especialidad', 150);
            $table->string('telefono', 20);
            $table->string('whatsapp', 20)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('foto_url', 255)->nullable();
            $table->dateTime('creado_en');
            $table->dateTime('actualizado_en');
            $table->dateTime('eliminado_en')->nullable();

            $table->foreign('id_usuario')
                ->references('id')
                ->on('usuarios')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};
