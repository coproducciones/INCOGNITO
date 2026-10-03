<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    /*
     * =========================================================
     * TABLA
     * =========================================================
     */

    protected $table = 'productos';


    /*
     * =========================================================
     * CAMPOS ASIGNABLES
     * =========================================================
     */

    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'activo',
    ];


    /*
     * =========================================================
     * CASTS
     * =========================================================
     */

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'activo' => 'boolean',
    ];


    /*
     * =========================================================
     * PRODUCTO → CATEGORÍA
     *
     * Ejemplo:
     *
     * Producto:
     * Cámara Sony
     *
     * Categoría:
     * Audiovisual
     * =========================================================
     */

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(
            Categoria::class,
            'categoria_id',
            'id'
        );
    }


    /*
     * =========================================================
     * PRODUCTO → DETALLES DE PEDIDO
     *
     * Un producto puede estar en muchos pedidos.
     * =========================================================
     */

    public function detallesPedido(): HasMany
    {
        return $this->hasMany(
            DetallePedido::class,
            'id_producto',
            'id'
        );
    }
}