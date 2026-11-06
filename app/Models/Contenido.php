<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contenido extends Model
{
    use HasFactory;

    protected $table = 'contenido';
    protected $primaryKey = 'id_contenido';

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'seccion',
        'id_proveedor',
        'publicado',
    ];

    protected $casts = [
        'publicado' => 'boolean',
    ];

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(
            Proveedor::class,
            'id_proveedor',
            'id_proveedor'
        );
    }

    public function media(): HasMany
    {
        return $this->hasMany(
            Multimedia::class,
            'id_contenido',
            'id_contenido'
        );
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(
            Categoria::class,
            'contenido_categorias',
            'id_contenido',
            'id_categoria',
            'id_contenido',
            'id'
        );
    }
}
