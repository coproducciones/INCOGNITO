<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permiso extends Model
{
    protected $table = 'permisos';

    protected $primaryKey = 'id_permiso';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'modulo',
    ];

    /*
     * =========================================================
     * ROLES
     * =========================================================
     *
     * Un permiso puede pertenecer a varios roles.
     */

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Rol::class,
            'rol_permiso',
            'id_permiso',
            'id_rol',
            'id_permiso',
            'id_rol'
        );
    }

    /*
     * =========================================================
     * PERMISOS INDIVIDUALES
     * =========================================================
     *
     * Permite saber qué usuarios tienen una excepción
     * para este permiso.
     */

    public function usuariosPermisos(): HasMany
    {
        return $this->hasMany(
            UsuarioPermiso::class,
            'id_permiso',
            'id_permiso'
        );
    }

    /*
     * =========================================================
     * ROUTE MODEL BINDING
     * =========================================================
     */

    public function getRouteKeyName(): string
    {
        return 'id_permiso';
    }
}
