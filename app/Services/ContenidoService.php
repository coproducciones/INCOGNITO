<?php

namespace App\Services;

use App\Models\Contenido;
use App\Repositories\ContenidoRepository;
use Illuminate\Database\Eloquent\Collection;

class ContenidoService
{
    public function __construct(
        protected ContenidoRepository $contenidoRepository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->contenidoRepository->getAll();
    }

    public function create(array $data): Contenido
    {
        return $this->contenidoRepository->create($data);
    }

    public function update(Contenido $contenido, array $data): Contenido
    {
        return $this->contenidoRepository->update($contenido, $data);
    }

    public function delete(Contenido $contenido): bool
    {
        return $this->contenidoRepository->delete($contenido);
    }
}
