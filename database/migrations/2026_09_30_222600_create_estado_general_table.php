<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estado_general', function (Blueprint $table) {
            $table->id('id_estado');

            $table->string('tipo', 50);

            $table->string('nombre', 100);

            $table->timestamps();

            $table->unique([
                'tipo',
                'nombre'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estado_general');
    }
};