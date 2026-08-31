<?php

namespace App\Services;

use App\Repositories\CategoriaRepository;

class CategoriaService
{
    private CategoriaRepository $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function getAll()
    {
        return $this->categoriaRepository->getAll();
    }

    public function findById($id)
    {
        return $this->categoriaRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->categoriaRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->categoriaRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->categoriaRepository->delete($id);
    }
}