<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoProveedorEvento extends Model
{
    protected $table = 'pedido_proveedor_evento';
    protected $primaryKey = 'id_evento_proveedor';
    public $timestamps = false;

    protected $fillable = [
        'id_pedido',
        'id_proveedor',
        'id_estado',
        'id_usuario',
        'tipo_evento',
        'comentario',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoGeneral::class, 'id_estado', 'id_estado');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }
}
