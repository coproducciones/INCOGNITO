<?php

namespace App\Repositories;

use App\Models\Categoria;

class CategoriaRepository
{
    public function getAll()
    {
        return Categoria::all();
    }

    public function findById($id)
    {
        return Categoria::findOrFail($id);
    }

    public function create(array $data)
    {
        return Categoria::create($data);
    }

    public function update($id, array $data)
    {
        $categoria = Categoria::findOrFail($id);

        $categoria->update($data);

        return $categoria;
    }

    public function delete($id)
    {
        $categoria = Categoria::findOrFail($id);

        return $categoria->delete();
    }
}