<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->bigIncrements('id_permiso');
            $table->string('nombre', 100);
            $table->string('modulo', 50);
            $table->unique(['nombre', 'modulo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permisos');
    }
};
