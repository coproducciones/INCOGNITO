<?php

namespace App\Repositories;

use App\Models\Disponibilidad;
use Illuminate\Database\Eloquent\Collection;

class DisponibilidadRepository
{
    public function allByProveedor(int $idProveedor): Collection
    {
        return Disponibilidad::where('id_proveedor', $idProveedor)
            ->orderBy('fecha')
            ->get();
    }

    public function find(int $id): Disponibilidad
    {
        return Disponibilidad::with('proveedor')->findOrFail($id);
    }

    public function findByProveedorAndFecha(int $idProveedor, string $fecha): ?Disponibilidad
    {
        return Disponibilidad::where('id_proveedor', $idProveedor)
            ->whereDate('fecha', $fecha)
            ->first();
    }

    public function create(array $data): Disponibilidad
    {
        return Disponibilidad::create($data);
    }

    public function update(Disponibilidad $disponibilidad, array $data): bool
    {
        return $disponibilidad->update($data);
    }

    public function delete(Disponibilidad $disponibilidad): bool
    {
        return (bool) $disponibilidad->delete();
    }
}
