<?php

namespace App\Repositories;

use App\Models\EstadoGeneral;

class EstadoGeneralRepository
{
    public function all()
    {
        return EstadoGeneral::orderBy('tipo')->orderBy('nombre')->get();
    }

    public function find(int $id): EstadoGeneral
    {
        return EstadoGeneral::findOrFail($id);
    }

    public function create(array $data): EstadoGeneral
    {
        return EstadoGeneral::create($data);
    }

    public function update(EstadoGeneral $estado, array $data): EstadoGeneral
    {
        $estado->update($data);
        return $estado->refresh();
    }

    public function delete(EstadoGeneral $estado): void
    {
        $estado->delete();
    }
}
