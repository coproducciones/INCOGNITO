<?php

namespace App\Services;

use App\Models\Multimedia;
use App\Repositories\MultimediaRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class MultimediaService
{
    public function __construct(
        protected MultimediaRepository $multimediaRepository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->multimediaRepository->getAll();
    }

    public function create(array $data): Multimedia
    {
        $data = $this->normalizeTarget($data);

        $data['destacado'] = (bool) ($data['destacado'] ?? false);

        return $this->multimediaRepository->create($data);
    }

    public function update(
        Multimedia $multimedia,
        array $data
    ): Multimedia {
        $data = $this->normalizeTarget($data);

        $data['destacado'] = (bool) ($data['destacado'] ?? false);

        return $this->multimediaRepository->update(
            $multimedia,
            $data
        );
    }

    public function delete(Multimedia $multimedia): bool
    {
        return $this->multimediaRepository->delete($multimedia);
    }

    private function normalizeTarget(array $data): array
    {
        $producto = $data['id_producto'] ?? null;
        $contenido = $data['id_contenido'] ?? null;

        $tieneProducto = $producto !== null && $producto !== '';
        $tieneContenido = $contenido !== null && $contenido !== '';

        if ($tieneProducto === $tieneContenido) {
            throw ValidationException::withMessages([
                'destino' => 'Debes seleccionar exactamente un producto o un contenido, no ambos.',
            ]);
        }

        $data['id_producto'] = $tieneProducto ? $producto : null;
        $data['id_contenido'] = $tieneContenido ? $contenido : null;

        return $data;
    }
}
