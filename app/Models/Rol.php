<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    protected $table = 'roles';

    /*
     * =========================================================
     * CLAVE PRIMARIA
     * =========================================================
     */

    protected $primaryKey = 'id_rol';

    /*
     * La tabla roles no utiliza timestamps.
     */

    public $timestamps = false;

    /*
     * =========================================================
     * CAMPOS ASIGNABLES
     * =========================================================
     */

    protected $fillable = [
        'nombre',
    ];

    /*
     * =========================================================
     * PERMISOS DEL ROL
     * =========================================================
     *
     * roles
     *    ↓
     * rol_permiso
     *    ↓
     * permisos
     *
     * Un rol puede tener muchos permisos.
     */

    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(
            Permiso::class,
            'rol_permiso',
            'id_rol',
            'id_permiso',
            'id_rol',
            'id_permiso'
        );
    }

    /*
     * =========================================================
     * USUARIOS DEL ROL
     * =========================================================
     *
     * Un rol puede tener muchos usuarios.
     *
     * usuarios.id_rol
     *       ↓
     * roles.id_rol
     */

    public function usuarios(): HasMany
    {
        return $this->hasMany(
            Usuario::class,
            'id_rol',
            'id_rol'
        );
    }

    /*
     * =========================================================
     * ROUTE MODEL BINDING
     * =========================================================
     *
     * Las rutas que utilizan {rol} buscarán por:
     *
     * roles.id_rol
     */

    public function getRouteKeyName(): string
    {
        return 'id_rol';
    }
}
