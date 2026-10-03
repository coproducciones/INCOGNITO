<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoGeneral extends Model
{
    /*
     * =========================================================
     * CONFIGURACIÓN DE LA TABLA
     * =========================================================
     */

    protected $table = 'estado_general';


    /*
     * La PK se llama id_estado.
     */

    protected $primaryKey = 'id_estado';


    /*
     * Esta tabla sí utiliza:
     *
     * created_at
     * updated_at
     */

    public $timestamps = true;


    /*
     * =========================================================
     * CAMPOS ASIGNABLES
     * =========================================================
     */

    protected $fillable = [
        'tipo',
        'nombre',
    ];


    /*
     * =========================================================
     * ESTADO → PEDIDOS
     * =========================================================
     *
     * Un estado puede pertenecer a muchos pedidos.
     */

    public function pedidos(): HasMany
    {
        return $this->hasMany(
            Pedido::class,
            'id_estado',
            'id_estado'
        );
    }


    /*
     * =========================================================
     * ESTADO → EVENTOS
     * =========================================================
     *
     * Un estado puede aparecer en muchos
     * eventos del historial de pedidos.
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