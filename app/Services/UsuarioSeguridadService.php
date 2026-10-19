<?php

namespace App\Services;

use App\Models\UsuarioSeguridad;
use App\Repositories\UsuarioSeguridadRepository;

class UsuarioSeguridadService
{
    public function __construct(
        private UsuarioSeguridadRepository $repository
    ) {}

    public function listar()
    {
        return $this->repository->all();
    }

    public function obtener(int $id)
    {
        return $this->repository->find($id);
    }

    public function actualizar(
        UsuarioSeguridad $usuario,
        array $data
    ) {
        return $this->repository->update($usuario, $data);
    }
}
