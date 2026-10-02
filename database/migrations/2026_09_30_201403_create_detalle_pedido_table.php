<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detalle_pedido', function (Blueprint $table) {
            $table->id('id_detalle');

            $table->unsignedBigInteger('id_pedido');

            $table->unsignedBigInteger('id_producto');

            $table->unsignedInteger('cantidad');

            $table->decimal('precio_unitario', 12, 2);

            $table->decimal('subtotal', 12, 2);

            $table->foreign('id_pedido')
                ->references('id_pedido')
                ->on('pedido')
                ->cascadeOnDelete();

            $table->foreign('id_producto')
                ->references('id')
                ->on('productos')
                ->restrictOnDelete();

            $table->unique([
                'id_pedido',
                'id_producto'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_pedido');
    }
};