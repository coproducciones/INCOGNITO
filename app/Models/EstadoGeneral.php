<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoGeneral extends Model
{
    /**
     * Tabla asociada.
     */
    protected $table = 'estado_general';

    /**
     * Clave primaria.
     */
    protected $primaryKey = 'id_estado';

    /**
     * La tabla utiliza created_at y updated_at.
     */
    public $timestamps = true;

    /**
     * Campos permitidos para asignación masiva.
     */
    protected $fillable = [
        'tipo',
        'nombre',
    ];

    /**
     * Un estado puede tener muchos pedidos.
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(
            Pedido::class,
            'id_estado',
            'id_estado'
        );
    }

    /**
     * Un estado puede aparecer
     * en muchos eventos de pedido.
     */
    public function pedidoEventos(): HasMany
    {
        return $this->hasMany(
            PedidoEvento::class,
            'id_estado',
            'id_estado'
        );
    }
}