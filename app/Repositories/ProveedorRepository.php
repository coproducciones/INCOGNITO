<?php

namespace App\Repositories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Collection;

class ProveedorRepository
{
    public function all(): Collection
    {
        return Proveedor::with(['usuario', 'categorias'])
            ->orderBy('especialidad')
            ->get();
    }

    public function find(int $id): Proveedor
    {
        return Proveedor::with(['usuario', 'disponibilidades', 'categorias'])
            ->findOrFail($id);
    }

    public function findByUser(int $idUsuario): ?Proveedor
    {
        return Proveedor::where('id_usuario', $idUsuario)->first();
    }

    public function create(array $data): Proveedor
    {
        return Proveedor::create($data);
    }

    public function update(Proveedor $proveedor, array $data): bool
    {
        return $proveedor->update($data);
    }

    public function delete(Proveedor $proveedor): bool
    {
        return (bool) $proveedor->delete();
    }
}
