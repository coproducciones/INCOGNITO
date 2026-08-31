<?php

namespace App\Repositories;

use App\Models\categoria;

class CategoriaRepository
{
    public function getAll()
    {
        return categoria::all();
    }

    public function findById($id)
    {
        return categoria::findOrFail($id);
    }

    public function create(array $data)
    {
        return categoria::create($data);
    }

    public function update($id, array $data)
    {
        $categoria = categoria::findOrFail($id);

        $categoria->update($data);

        return $categoria;
    }

    public function delete($id)
    {
        $categoria = categoria::findOrFail($id);

        return $categoria->delete();
    }
}