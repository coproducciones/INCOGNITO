<?php

namespace App\Repositories;

use App\Models\Reseña;
use Illuminate\Database\Eloquent\Collection;

class ReseñaRepository
{
    /**
     * Obtiene todas las reseñas junto con sus relaciones.
     */
    public function all(): Collection
    {
        return Reseña::with([
            'usuario',
            'producto',
            'cliente',
        ])
            ->orderByDesc('fecha')
            ->get();
    }

    /**
     * Busca una reseña por su clave primaria.
     *
     * Si no existe, Laravel lanza ModelNotFoundException.
     */
    public function findOrFail(int $id): Reseña
    {
        return Reseña::with([
            'usuario',
            'producto',
            'cliente',
        ])->findOrFail($id);
    }

    /**
     * Crea una nueva reseña.
     */
    public function create(array $data): Reseña
    {
        return Reseña::create($data);
    }

    /**
     * Actualiza una reseña existente.
     */
    public function update(
        Reseña $reseña,
        array $data
    ): Reseña {

        $reseña->update($data);

        return $reseña
            ->refresh()
            ->load([
                'usuario',
                'producto',
                'cliente',
            ]);
    }

    /**
     * Elimina una reseña.
     */
    public function delete(Reseña $reseña): bool
    {
        return (bool) $reseña->delete();
    }

    /**
     * Obtiene las reseñas asociadas a un producto.
     */
    public function forProducto(int $id): Collection
    {
        return Reseña::with([
            'usuario',
            'cliente',
        ])
            ->where('id_producto', $id)
            ->orderByDesc('fecha')
            ->get();
    }
}

