
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contenido', function (Blueprint $table) {
            $table->unsignedBigInteger('id_proveedor')
                ->nullable()
                ->after('id_contenido');

            $table->boolean('publicado')
                ->default(false);

            $table->foreign('id_proveedor')
                ->references('id_proveedor')
                ->on('proveedor')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('contenido', function (Blueprint $table) {
            $table->dropForeign(['id_proveedor']);
            $table->dropColumn(['id_proveedor', 'publicado']);
        });
    }
};
