<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    use SoftDeletes;

    /**
     * Nombre de la tabla.
     */
    protected $table = 'pedido';

    /**
     * Clave primaria.
     */
    protected $primaryKey = 'id_pedido';

    /**
     * La tabla pedido no utiliza created_at ni updated_at.
     */
    public $timestamps = false;

    /**
     * Campos que pueden asignarse masivamente.
     */
    protected $fillable = [
        'id_usuario',
        'total',
        'id_estado',
        'fecha_pedido',
    ];

    /**
     * Conversión de tipos.
     */
    protected $casts = [
        'total' => 'decimal:2',
        'fecha_pedido' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Indica a Laravel qué columna utilizar
     * para Route Model Binding.
     *
     * Esto permite que:
     *
     * /pedidos/1
     *
     * busque:
     *
     * id_pedido = 1
     */
    public function getRouteKeyName(): string
    {
        return 'id_pedido';
    }

    /**
     * Relación con el usuario.
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
     * Relación con el estado.
     */
    public function estado(): BelongsTo
    {
        return $this->belongsTo(
            EstadoGeneral::class,
            'id_estado',
            'id_estado'
        );
    }

    /**
     * Relación con los detalles.
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(
            DetallePedido::class,
            'id_pedido',
            'id_pedido'
        );
    }

    /**
     * Relación con los eventos.
     */
    public function eventos(): HasMany
    {
        return $this->hasMany(
            PedidoEvento::class,
            'id_pedido',
            'id_pedido'
        )->orderByDesc('fecha');
    }
}