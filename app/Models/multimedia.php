<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Multimedia extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Configuración de la tabla
    |--------------------------------------------------------------------------
    */

    protected $table = 'multimedia';

    /*
    |--------------------------------------------------------------------------
    | Clave primaria
    |--------------------------------------------------------------------------
    |
    | IMPORTANTE:
    | La migración creó la columna:
    |
    |     $table->id('id');
    |
    | Por eso la clave primaria real es "id".
    |
    */

    protected $primaryKey = 'id';

    /*
    |--------------------------------------------------------------------------
    | Timestamps
    |--------------------------------------------------------------------------
    |
    | La tabla multimedia no tiene created_at ni updated_at.
    |
    */

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Asignación masiva
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'url',
        'tipo',
        'destacado',
        'id_producto',
        'id_contenido',
    ];

    /*
    |--------------------------------------------------------------------------
    | Conversión de tipos
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'destacado' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relación con Producto
    |--------------------------------------------------------------------------
    */

    public function producto(): BelongsTo
    {
        return $this->belongsTo(
            Producto::class,
            'id_producto',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relación con Contenido
    |--------------------------------------------------------------------------
    */

    public function contenido(): BelongsTo
    {
        return $this->belongsTo(
            Contenido::class,
            'id_contenido',
            'id_contenido'
        );
    }
}
