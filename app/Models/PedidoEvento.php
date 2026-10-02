<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoEvento extends Model
{
    protected $table = 'pedido_evento';

    protected $primaryKey = 'id_evento';

    public $timestamps = false;

    protected $fillable = [
        'id_pedido',
        'id_estado',
        'tipo_evento',
        'comentario',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(
            Pedido::class,
            'id_pedido',
            'id_pedido'
        );
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(
            EstadoGeneral::class,
            'id_estado',
            'id_estado'
        );
    }
}