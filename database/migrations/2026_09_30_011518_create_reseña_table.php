<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de reseñas.
     *
     * Cada reseña pertenece a:
     * - un usuario
     * - un producto
     * - un cliente
     */
    public function up(): void
    {
        Schema::create('reseña', function (Blueprint $table) {

            /*
             * Clave primaria.
             */
            $table->id('id_reseña');


            /*
             * Usuario que registra la reseña.
             *
             * usuarios.id
             */
            $table->unsignedBigInteger('id_usuario');


            /*
             * Producto que está siendo reseñado.
             *
             * productos.id
             */
            $table->unsignedBigInteger('id_producto');


            /*
             * Cliente que realiza la reseña.
             *
             * clientes.id_cliente
             */
            $table->unsignedBigInteger('id_cliente');


            /*
             * Calificación de 1 a 5.
             */
            $table->unsignedTinyInteger('calificacion');


            /*
             * Comentario escrito por el cliente.
             */
            $table->text('comentario')->nullable();


            /*
             * Respuesta del administrador o empresa.
             */
            $table->text('respuesta')->nullable();


            /*
             * Fecha de creación de la reseña.
             */
            $table->dateTime('fecha');


            /*
             * Relación con usuarios.
             */
            $table->foreign('id_usuario')
                ->references('id')
                ->on('usuarios')
                ->cascadeOnUpdate()
                ->restrictOnDelete();


            /*
             * Relación con productos.
             */
            $table->foreign('id_producto')
                ->references('id')
                ->on('productos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();


            /*
             * Relación con clientes.
             */
            $table->foreign('id_cliente')
                ->references('id_cliente')
                ->on('clientes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            /*
             * Evita que un mismo usuario registre
             * dos veces la misma combinación:
             *
             * usuario + producto + cliente
             */
            $table->unique(
                [
                    'id_usuario',
                    'id_producto',
                    'id_cliente'
                ],
                'resena_usuario_producto_cliente_unique'
            );
        });
    }

    /**
     * Elimina la tabla de reseñas.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseña');
    }
};

