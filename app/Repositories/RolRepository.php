<?php

namespace App\Repositories;

use App\Models\Rol;
use Illuminate\Database\Eloquent\Collection;

class RolRepository
{
    /*
    |--------------------------------------------------------------------------
    | LISTAR TODOS LOS ROLES
    |--------------------------------------------------------------------------
    */

    public function all(): Collection
    {
        return Rol::query()
            ->withCount('permisos')
            ->orderBy('nombre')
            ->get();
    }


    /*
    |--------------------------------------------------------------------------
    | BUSCAR ROL POR ID
    |--------------------------------------------------------------------------
    */

    public function find(int $id): Rol
    {
        return Rol::query()
            ->with('permisos')
            ->findOrFail($id);
    }


    /*
    |--------------------------------------------------------------------------
    | BUSCAR ROL POR NOMBRE
    |--------------------------------------------------------------------------
    |
    | Este método es utilizado por RolService para comprobar
    | que no existan dos roles con el mismo nombre.
    |
    */

    public function findByName(string $nombre): ?Rol
    {
        return Rol::query()
            ->where('nombre', $nombre)
            ->first();
    }


    /*
    |--------------------------------------------------------------------------
    | CREAR ROL
    |--------------------------------------------------------------------------
    */

    public function create(array $data): Rol
    {
        return Rol::create($data);
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR ROL
    |--------------------------------------------------------------------------
    */

    public function update(
        Rol $rol,
        array $data
    ): bool {
        return $rol->update($data);
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR ROL
    |--------------------------------------------------------------------------
    */

    public function delete(Rol $rol): bool
    {
        return (bool) $rol->delete();
    }
}

