<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contenido', function (Blueprint $table) {
            $table->id('id_contenido');
            $table->string('titulo', 150);
            $table->text('descripcion')->nullable();
            $table->string('seccion', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contenido');
    }
    
};
