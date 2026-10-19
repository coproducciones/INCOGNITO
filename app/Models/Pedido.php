<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    use SoftDeletes;

    protected $table = 'pedido';
    protected $primaryKey = 'id_pedido';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'total',
        'id_estado',
        'fecha_pedido',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'fecha_pedido' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'id_pedido';
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(
            EstadoGeneral::class,
            'id_estado',
            'id_estado'
        );
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(
            DetallePedido::class,
            'id_pedido',
            'id_pedido'
        );
    }

    public function eventos(): HasMany
    {
        return $this->hasMany(
            PedidoEvento::class,
            'id_pedido',
            'id_pedido'
        )->orderByDesc('fecha');
    }
}
