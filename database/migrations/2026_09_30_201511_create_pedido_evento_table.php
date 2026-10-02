<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pedido_evento', function (Blueprint $table) {
            $table->id('id_evento');

            $table->unsignedBigInteger('id_pedido');

            $table->unsignedBigInteger('id_estado')->nullable();

            $table->string('tipo_evento', 50);

            $table->text('comentario')->nullable();

            $table->dateTime('fecha');

            $table->foreign('id_pedido')
                ->references('id_pedido')
                ->on('pedido')
                ->cascadeOnDelete();

            $table->foreign('id_estado')
                ->references('id_estado')
                ->on('estado_general')
                ->nullOnDelete();

            $table->index([
                'id_pedido',
                'fecha'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido_evento');
    }
};