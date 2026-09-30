<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reseña extends Model
{
    use HasFactory;

    protected $table = 'reseña';

    protected $primaryKey = 'id_reseña';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_producto',
        'id_cliente',
        'calificacion',
        'comentario',
        'respuesta',
        'fecha',
    ];

    protected $casts = [
        'calificacion' => 'integer',
        'fecha' => 'datetime',
    ];

    /**
     * La reseña pertenece a un usuario.
     *
     * reseña.id_usuario
     *       ↓
     * usuarios.id
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'id_usuario',
            'id'
        );
    }

    /**
     * La reseña pertenece a un producto.
     *
     * reseña.id_producto
     *       ↓
     * productos.id
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(
            Producto::class,
            'id_producto',
            'id'
        );
    }

    /**
     * La reseña pertenece a un cliente.
     *
     * reseña.id_cliente
     *       ↓
     * clientes.id_cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(
            Cliente::class,
            'id_cliente',
            'id_cliente'
        );
    }
}
