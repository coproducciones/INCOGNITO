<?php

namespace App\Repositories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Collection;

class ProductoRepository
{
    /**
     * Modelo Producto.
     */
    protected Producto $model;

    /**
     * Constructor.
     */
    public function __construct(Producto $model)
    {
        $this->model = $model;
    }

    /**
     * Obtener todos los productos
     * junto con su categoría.
     */
    public function all(): Collection
    {
        return $this->model
            ->with('categoria')
            ->orderBy('nombre')
            ->get();
    }

    /**
     * Buscar un producto por ID.
     */
    public function find(int $id): ?Producto
    {
        return $this->model
            ->with('categoria')
            ->find($id);
    }

    /**
     * Buscar un producto por ID
     * o lanzar una excepción si no existe.
     */
    public function findOrFail(int $id): Producto
    {
        return $this->model
            ->with('categoria')
            ->findOrFail($id);
    }

    /**
     * Crear un producto.
     */
    public function create(array $data): Producto
    {
        return $this->model->create($data);
    }

    /**
     * Actualizar un producto.
     */
    public function update(Producto $producto, array $data): Producto
    {
        $producto->update($data);

        return $producto->fresh('categoria');
    }

    /**
     * Eliminar un producto.
     */
    public function delete(Producto $producto): bool
    {
        return $producto->delete();
    }

    /**
     * Obtener productos de una categoría.
     */
    public function getByCategoria(int $categoriaId): Collection
    {
        return $this->model
            ->with('categoria')
            ->where('categoria_id', $categoriaId)
            ->orderBy('nombre')
            ->get();
    }

    /**
     * Buscar productos por nombre.
     */
    public function search(string $termino): Collection
    {
        return $this->model
            ->with('categoria')
            ->where('nombre', 'like', '%' . $termino . '%')
            ->orderBy('nombre')
            ->get();
    }

    /**
     * Obtener solamente productos activos.
     */
    public function getActivos(): Collection
    {
        return $this->model
            ->with('categoria')
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();
    }

    /**
     * Obtener solamente productos inactivos.
     */
    public function getInactivos(): Collection
    {
        return $this->model
            ->with('categoria')
            ->where('activo', false)
            ->orderBy('nombre')
            ->get();
    }
}
