<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Estado actual de cada proveedor dentro de un pedido.
        Schema::create('pedido_proveedor_estado', function (Blueprint $table) {
            $table->id('id_pedido_proveedor_estado');
            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_proveedor');
            $table->unsignedBigInteger('id_estado');
            $table->unsignedBigInteger('actualizado_por');
            $table->text('comentario')->nullable();
            $table->timestamps();

            $table->unique(['id_pedido', 'id_proveedor'], 'pedido_proveedor_estado_unico');
            $table->foreign('id_pedido')->references('id_pedido')->on('pedido')->cascadeOnDelete();
            $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedor')->restrictOnDelete();
            $table->foreign('id_estado')->references('id_estado')->on('estado_general')->restrictOnDelete();
            $table->foreign('actualizado_por')->references('id')->on('usuarios')->restrictOnDelete();
            $table->index(['id_proveedor', 'updated_at']);
        });

        // Historial independiente: conserva cada cambio y quién lo realizó.
        Schema::create('pedido_proveedor_evento', function (Blueprint $table) {
            $table->id('id_evento_proveedor');
            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_proveedor');
            $table->unsignedBigInteger('id_estado');
            $table->unsignedBigInteger('id_usuario');
            $table->string('tipo_evento', 50)->default('ESTADO_ACTUALIZADO');
            $table->text('comentario')->nullable();
            $table->dateTime('fecha');

            $table->foreign('id_pedido')->references('id_pedido')->on('pedido')->cascadeOnDelete();
            $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedor')->restrictOnDelete();
            $table->foreign('id_estado')->references('id_estado')->on('estado_general')->restrictOnDelete();
            $table->foreign('id_usuario')->references('id')->on('usuarios')->restrictOnDelete();
            $table->index(['id_pedido', 'id_proveedor', 'fecha'], 'pedido_proveedor_evento_busqueda');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido_proveedor_evento');
        Schema::dropIfExists('pedido_proveedor_estado');
    }
};
