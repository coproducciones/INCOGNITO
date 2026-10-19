<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario_permiso', function (Blueprint $table) {

            $table->id();

            /*
             * Usuario al que se aplica la excepción.
             */
            $table->unsignedBigInteger('id_usuario');

            /*
             * Permiso que se concede o revoca.
             */
            $table->unsignedBigInteger('id_permiso');

            /*
             * true  = permite el permiso.
             * false = bloquea el permiso.
             */
            $table->boolean('permitido')->default(true);

            /*
             * Un usuario no puede tener dos reglas
             * para el mismo permiso.
             */
            $table->unique(
                ['id_usuario', 'id_permiso'],
                'usuario_permiso_unico'
            );

            /*
             * Relación con usuarios.
             */
            $table->foreign('id_usuario')
                ->references('id')
                ->on('usuarios')
                ->cascadeOnDelete();

            /*
             * Relación con permisos.
             */
            $table->foreign('id_permiso')
                ->references('id_permiso')
                ->on('permisos')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_permiso');
    }
};