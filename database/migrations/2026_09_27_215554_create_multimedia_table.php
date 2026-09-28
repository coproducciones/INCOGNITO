<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('multimedia', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | ID
            |--------------------------------------------------------------------------
            |
            | La clave primaria se llama "id".
            |
            */

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Información multimedia
            |--------------------------------------------------------------------------
            */

            $table->string('url', 255);

            $table->string('tipo', 20);

            $table->boolean('destacado')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Relación con productos
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_producto')
                ->nullable()
                ->constrained('productos', 'id')
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Relación con contenido
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_contenido')
                ->nullable()
                ->constrained('contenido', 'id_contenido')
                ->restrictOnDelete();
        });


        /*
        |--------------------------------------------------------------------------
        | Regla: exactamente una asociación
        |--------------------------------------------------------------------------
        */

        $driver = Schema::getConnection()->getDriverName();


        /*
        |--------------------------------------------------------------------------
        | MySQL / MariaDB / PostgreSQL
        |--------------------------------------------------------------------------
        */

        if (in_array($driver, ['mysql', 'mariadb', 'pgsql'])) {

            DB::statement(
                'ALTER TABLE multimedia ADD CONSTRAINT chk_multimedia_un_destino CHECK (' .
                '(CASE WHEN id_producto IS NOT NULL THEN 1 ELSE 0 END + ' .
                'CASE WHEN id_contenido IS NOT NULL THEN 1 ELSE 0 END) = 1)'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SQLite
        |--------------------------------------------------------------------------
        */

        if ($driver === 'sqlite') {

            DB::unprepared("
                CREATE TRIGGER multimedia_un_destino_insert
                BEFORE INSERT ON multimedia
                WHEN (
                    (NEW.id_producto IS NOT NULL)
                    +
                    (NEW.id_contenido IS NOT NULL)
                ) <> 1
                BEGIN
                    SELECT RAISE(
                        ABORT,
                        'Debe informarse exactamente uno de id_producto o id_contenido.'
                    );
                END;
            ");


            DB::unprepared("
                CREATE TRIGGER multimedia_un_destino_update
                BEFORE UPDATE ON multimedia
                WHEN (
                    (NEW.id_producto IS NOT NULL)
                    +
                    (NEW.id_contenido IS NOT NULL)
                ) <> 1
                BEGIN
                    SELECT RAISE(
                        ABORT,
                        'Debe informarse exactamente uno de id_producto o id_contenido.'
                    );
                END;
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('multimedia');
    }
};
