<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoProveedorEstado extends Model
{
    protected $table = 'pedido_proveedor_estado';
    protected $primaryKey = 'id_pedido_proveedor_estado';

    protected $fillable = [
        'id_pedido',
        'id_proveedor',
        'id_estado',
        'actualizado_por',
        'comentario',
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

    public function usuarioActualizacion(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'actualizado_por', 'id');
    }
}
