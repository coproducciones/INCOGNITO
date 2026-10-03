<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_pedido', function (Blueprint $table) {

            $table->id('id_detalle');

            $table->unsignedBigInteger('id_pedido');

            $table->unsignedBigInteger('id_producto');

            $table->unsignedInteger('cantidad');

            /*
             * Guardamos el precio que tenía el producto
             * en el momento de agregarlo al pedido.
             */
            $table->decimal('precio_unitario', 12, 2);

            /*
             * cantidad × precio_unitario
             */
            $table->decimal('subtotal', 12, 2);

            /*
             * Un mismo producto no puede aparecer
             * dos veces dentro del mismo pedido.
             */
            $table->unique([
                'id_pedido',
                'id_producto',
            ]);

            /*
             * Relación con pedido.
             */
            $table->foreign('id_pedido')
                ->references('id_pedido')
                ->on('pedido')
                ->cascadeOnDelete();

            /*
             * Relación con productos.
             *
             * productos utiliza "id" como PK.
             */
            $table->foreign('id_producto')
                ->references('id')
                ->on('productos')
                ->restrictOnDelete();

            $table->index('id_pedido');
            $table->index('id_producto');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_pedido');
    }
};