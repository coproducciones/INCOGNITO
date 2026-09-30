<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de productos.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {

            // Clave primaria del producto
            $table->id();

            // Cada producto pertenece a una categoría
            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->onDelete('cascade');

            // Información del producto
            $table->string('nombre', 80);
            $table->text('descripcion')->nullable();

            // Información comercial
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(0);

            // Estado del producto
            $table->boolean('activo')->default(true);

            // Fechas de Laravel
            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla de productos.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
