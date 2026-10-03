<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    use SoftDeletes;

    /*
     * =========================================================
     * CONFIGURACIÓN DE LA TABLA
     * =========================================================
     */

    protected $table = 'pedido';

    /*
     * La clave primaria de pedido no se llama "id".
     */
    protected $primaryKey = 'id_pedido';

    /*
     * La tabla pedido no utiliza:
     *
     * created_at
     * updated_at
     */
    public $timestamps = false;


    /*
     * =========================================================
     * CAMPOS ASIGNABLES
     * =========================================================
     */

    protected $fillable = [
        'id_usuario',
        'total',
        'id_estado',
        'fecha_pedido',
    ];


    /*
     * =========================================================
     * CASTS
     * =========================================================
     */

    protected $casts = [
        'total' => 'decimal:2',
        'fecha_pedido' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    /*
     * =========================================================
     * ROUTE MODEL BINDING
     * =========================================================
     *
     * Permite que:
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


    /*
     * =========================================================
     * PEDIDO → USUARIO
     * =========================================================
     */

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'id_usuario',
            'id'
        );
    }


    /*
     * =========================================================
     * PEDIDO → ESTADO GENERAL
     * =========================================================
     *
     * pedido.id_estado
     *        ↓
     * estado_general.id_estado
     */

    public function estado(): BelongsTo
    {
        return $this->belongsTo(
            EstadoGeneral::class,
            'id_estado',
            'id_estado'
        );
    }


    /*
     * =========================================================
     * PEDIDO → DETALLES
     * =========================================================
     *
     * Un pedido puede tener muchos productos.
     *
     * pedido
     *   ↓
     * detalle_pedido
     *   ↓
     * producto
     */

    public function detalles(): HasMany
    {
        return $this->hasMany(
            DetallePedido::class,
            'id_pedido',
            'id_pedido'
        );
    }


    /*
     * =========================================================
     * PEDIDO → EVENTOS
     * =========================================================
     *
     * Guarda el historial del pedido.
     */

    public function eventos(): HasMany
    {
        return $this->hasMany(
            PedidoEvento::class,
            'id_pedido',
            'id_pedido'
        )
        ->orderByDesc('fecha');
    }
}