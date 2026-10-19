<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'id_proveedor',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'activo' => 'boolean',
    ];

    /** Un producto pertenece a una categoría. */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(
            Categoria::class,
            'categoria_id',
            'id'
        );
    }

    /** Un producto pertenece a un proveedor. */
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(
            Proveedor::class,
            'id_proveedor',
            'id_proveedor'
        );
    }

    /** Un producto puede aparecer en varios detalles de pedido. */
    public function detallesPedido(): HasMany
    {
        return $this->hasMany(
            DetallePedido::class,
            'id_producto',
            'id'
        );
    }
}
