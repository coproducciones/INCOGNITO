<?php

namespace App\Repositories;

use App\Models\Cliente;

class ClienteRepository
{
    public function all()
    {
        return Cliente::withCount('reseñas')
            ->orderBy('nombre')
            ->get();
    }

    public function findOrFail(int $id): Cliente
    {
        return Cliente::withCount('reseñas')
            ->findOrFail($id);
    }

    public function create(array $data): Cliente
    {
        return Cliente::create($data);
    }

    public function update(Cliente $cliente, array $data): Cliente
    {
        $cliente->update($data);

        return $cliente->refresh();
    }

    public function delete(Cliente $cliente): bool
    {
        return (bool) $cliente->delete();
    }
}
