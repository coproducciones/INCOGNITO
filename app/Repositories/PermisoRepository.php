<?php

namespace App\Repositories;

use App\Models\Permiso;

class PermisoRepository
{
    public function all()
    {
        return Permiso::withCount('roles')->orderBy('modulo')->orderBy('nombre')->get();
    }

    public function find(int $id): Permiso
    {
        return Permiso::findOrFail($id);
    }

    public function create(array $data): Permiso
    {
        return Permiso::create($data);
    }

    public function update(Permiso $permiso, array $data): Permiso
    {
        $permiso->update($data);
        return $permiso->refresh();
    }

    public function delete(Permiso $permiso): void
    {
        $permiso->delete();
    }
}
