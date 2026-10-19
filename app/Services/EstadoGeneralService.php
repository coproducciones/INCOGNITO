<?php

namespace App\Services;

use App\Models\EstadoGeneral;
use App\Repositories\EstadoGeneralRepository;

class EstadoGeneralService
{
    public function __construct(private EstadoGeneralRepository $repository) {}
    public function listar() { return $this->repository->all(); }
    public function obtener(int $id) { return $this->repository->find($id); }
    public function crear(array $data) { return $this->repository->create($data); }
    public function actualizar(EstadoGeneral $estado, array $data) { return $this->repository->update($estado, $data); }

    public function eliminar(EstadoGeneral $estado): void
    {
        if ($estado->usuarios()->exists()) {
            throw new \RuntimeException('No se puede eliminar un estado que tiene usuarios asociados.');
        }
        $this->repository->delete($estado);
    }
}
