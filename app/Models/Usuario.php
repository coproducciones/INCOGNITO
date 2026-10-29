<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Usuario extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'usuarios';

    /*
     * =========================================================
     * CLAVE PRIMARIA
     * =========================================================
     */

    protected $primaryKey = 'id';

    /*
     * =========================================================
     * CAMPOS ASIGNABLES
     * =========================================================
     */

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'telefono',
        'id_rol',
        'id_estado',
        'email_verified_at',
    ];

    /*
     * =========================================================
     * CAMPOS OCULTOS
     * =========================================================
     */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
     * =========================================================
     * CASTS
     * =========================================================
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*
     * =========================================================
     * RELACIÓN CON ROL
     * =========================================================
     */

    public function rol(): BelongsTo
    {
        return $this->belongsTo(
            Rol::class,
            'id_rol',
            'id_rol'
        );
    }

    /*
     * =========================================================
     * RELACIÓN CON ESTADO
     * =========================================================
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
     * PERMISOS INDIVIDUALES
     * =========================================================
     */

    public function permisosIndividuales(): BelongsToMany
    {
        return $this->belongsToMany(
            Permiso::class,
            'usuario_permiso',
            'id_usuario',
            'id_permiso',
            'id',
            'id_permiso'
        )->withPivot('permitido');
    }

    /*
     * =========================================================
     * CLIENTE
     * =========================================================
     *
     * Una cuenta puede estar asociada a una ficha de cliente.
     */
    public function cliente(): HasOne
    {
        return $this->hasOne(
            Cliente::class,
            'id_usuario',
            'id'
        );
    }

    /*
     * =========================================================
     * PROVEEDOR
     * =========================================================
     * Una cuenta puede tener una ficha de proveedor.
     */
    public function proveedor(): HasOne
    {
        return $this->hasOne(
            Proveedor::class,
            'id_usuario',
            'id'
        );
    }

    /*
     * =========================================================
     * PEDIDOS
     * =========================================================
     */

    public function pedidos(): HasMany
    {
        return $this->hasMany(
            Pedido::class,
            'id_usuario',
            'id'
        );
    }

    /*
     * =========================================================
     * RESEÑAS
     * =========================================================
     */

    public function resenas(): HasMany
    {
        return $this->hasMany(
            Reseña::class,
            'id_usuario',
            'id'
        );
    }

    /*
     * =========================================================
     * COMPROBAR UN PERMISO
     * =========================================================
     */


public function tienePermiso(string $nombrePermiso): bool
    {
        // El nombre debe identificar un único permiso en la base de datos.
        // Si hay duplicados entre módulos, denegamos por seguridad.
        $idsPermiso = Permiso::query()
            ->where('nombre', $nombrePermiso)
            ->pluck('id_permiso');

        if ($idsPermiso->count() !== 1) {
            return false;
        }

        $idPermiso = (int) $idsPermiso->first();

        // Una regla individual explícita prevalece sobre los permisos del rol.
        $reglaIndividual = UsuarioPermiso::query()
            ->where('id_usuario', $this->getKey())
            ->where('id_permiso', $idPermiso)
            ->first();

        if ($reglaIndividual !== null) {
            return (bool) $reglaIndividual->permitido;
        }

        // Sin rol asignado, el acceso se deniega por defecto.
        if (!$this->id_rol) {
            return false;
        }

        // Comprobar el permiso heredado del rol.
        return $this->rol()
            ->whereHas('permisos', function ($query) use ($idPermiso) {
                $query->where('permisos.id_permiso', $idPermiso);
            })
            ->exists();
    }

    /*
     * =========================================================
     * COMPROBAR CUALQUIERA DE VARIOS PERMISOS
     * =========================================================
     */

    public function tieneAlgunPermiso(array $permisos): bool
    {
        foreach ($permisos as $permiso) {
            if ($this->tienePermiso($permiso)) {
                return true;
            }
        }

        return false;
    }

    /*
     * =========================================================
     * COMPROBAR TODOS LOS PERMISOS
     * =========================================================
     */

    public function tieneTodosLosPermisos(array $permisos): bool
    {
        foreach ($permisos as $permiso) {
            if (!$this->tienePermiso($permiso)) {
                return false;
            }
        }

        return true;
    }
}