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

    /**
     * Obtiene solamente las reseñas del usuario autenticado.
     */
    public function forUsuario(int $usuarioId): Collection
    {
        return Reseña::with([
            'usuario',
            'producto',
            'cliente',
        ])
            ->where('id_usuario', $usuarioId)
            ->orderByDesc('fecha')
            ->get();
    }

    /**
     * Busca una reseña solamente si pertenece al usuario indicado.
     */
    public function findForUsuario(
        int $reseñaId,
        int $usuarioId
    ): Reseña {
        return Reseña::with([
            'usuario',
            'producto',
            'cliente',
        ])
            ->where('id_usuario', $usuarioId)
            ->findOrFail($reseñaId);
    }

    /**
     * Comprueba si el usuario ya reseñó un producto.
     */
    public function existsForUsuarioProducto(
        int $usuarioId,
        int $productoId
    ): bool {
        return Reseña::query()
            ->where('id_usuario', $usuarioId)
            ->where('id_producto', $productoId)
            ->exists();
    }

}

