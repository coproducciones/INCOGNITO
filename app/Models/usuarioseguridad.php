<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo auxiliar para la gestión de seguridad sobre la tabla usuarios.
 * Mantiene como PK la columna estándar id del proyecto actual.
 */
class usuarioseguridad extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'id_rol',
        'id_estado',
    ];

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoGeneral::class, 'id_estado', 'id_estado');
    }
}
