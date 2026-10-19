<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsuarioPermiso extends Model
{
    protected $table = 'usuario_permiso';

    protected $fillable = [
        'id_usuario',
        'id_permiso',
        'permitido',
    ];

    protected $casts = [
        'permitido' => 'boolean',
    ];

    /*
     * Usuario al que pertenece esta regla.
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
     * Permiso al que pertenece esta regla.
     */
    public function permiso(): BelongsTo
    {
        return $this->belongsTo(
            Permiso::class,
            'id_permiso',
            'id_permiso'
        );
    }
}
