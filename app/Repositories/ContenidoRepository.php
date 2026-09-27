<?php

namespace App\Repositories;

use App\Models\Contenido;
use Illuminate\Database\Eloquent\Collection;

class ContenidoRepository
{
    public function getAll(): Collection
    {
        return Contenido::orderBy('seccion')->orderBy('titulo')->get();
    }

    public function create(array $data): Contenido
    {
        return Contenido::create($data);
    }

    public function findOrFail(int $id): Contenido
    {
        return Contenido::findOrFail($id);
    }

    public function update(Contenido $contenido, array $data): Contenido
    {
        $contenido->update($data);
        return $contenido->refresh();
    }

    public function delete(Contenido $contenido): bool
    {
        return (bool) $contenido->delete();
    }
}
