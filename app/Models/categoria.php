<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    /**
     * Nombre de la tabla asociada con este modelo.
     *
     * @var string
     */
    protected $table = 'categorias';

    /**
     * Atributos que se pueden asignar de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Obtiene los productos pertenecientes a esta categoría.
     *
     * Relación: una categoría tiene muchos productos.
     *
     * @return HasMany
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }

    /**
     * Obtiene los contenidos asociados a esta categoría.
     *
     * Relación: muchos a muchos entre categorías y contenidos,
     * mediante la tabla intermedia contenido_categorias.
     *
     * @return BelongsToMany
     */
    public function contenidos(): BelongsToMany
    {
        return $this->belongsToMany(
            Contenido::class,
            'contenido_categorias',
            'id_categoria',
            'id_contenido',
            'id',
            'id_contenido'
        );
    }
}
