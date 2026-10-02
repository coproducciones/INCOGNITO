<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedido', function (Blueprint $table) {
            $table->id('id_pedido');

            /*
             * Relación con usuarios.
             *
             * IMPORTANTE:
             * usuarios utiliza "id" como clave primaria.
             *
             * Por eso:
             *
             * pedido.id_usuario
             *          ↓
             * usuarios.id
             */
            $table->unsignedBigInteger('id_usuario');

            /*
             * Total del pedido.
             *
             * Se inicializa en 0 porque los detalles
             * se agregan posteriormente.
             */
            $table->decimal('total', 12, 2)
                ->default(0);

            /*
             * Estado general del pedido.
             */
            $table->unsignedBigInteger('id_estado');

            /*
             * Fecha en que se creó el pedido.
             */
            $table->dateTime('fecha_pedido');

            /*
             * Eliminación lógica.
             */
            $table->softDeletes('deleted_at');

            /*
             * FK: pedido → usuarios
             */
            $table->foreign('id_usuario')
                ->references('id')
                ->on('usuarios')
                ->restrictOnDelete();

            /*
             * FK: pedido → estado_general
             */
            $table->foreign('id_estado')
                ->references('id_estado')
                ->on('estado_general')
                ->restrictOnDelete();

            /*
             * Índice para consultas por usuario y estado.
             */
            $table->index([
                'id_usuario',
                'id_estado',
            ]);

            /*
             * Índice para ordenar/buscar por fecha.
             */
            $table->index('fecha_pedido');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido');
    }
};