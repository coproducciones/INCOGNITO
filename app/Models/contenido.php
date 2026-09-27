<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contenido extends Model
{
    use HasFactory;

    protected $table = 'contenido';
    protected $primaryKey = 'id_contenido';

    // La tabla no tiene created_at / updated_at
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'seccion',
    ];

    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'id_contenido');
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(
            Categoria::class,
            'contenido_categorias',   // tabla pivote
            'id_contenido',           // clave en la tabla pivote que apunta a contenido
            'id_categoria'            // clave en la tabla pivote que apunta a categoria
        );
    }
}