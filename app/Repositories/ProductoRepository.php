<?php

namespace App\Repositories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Collection;

class ProductoRepository
{
    public function __construct(private Producto $model)
    {
    }

    /** Lista productos con categoría, proveedor y usuario proveedor. */
    public function all(): Collection
    {
        return $this->model->with(['categoria', 'proveedor.usuario'])
            ->orderBy('nombre')
            ->get();
    }

    /** Busca un producto sin lanzar error si no existe. */
    public function find(int $id): ?Producto
    {
        return $this->model->with(['categoria', 'proveedor.usuario'])->find($id);
    }

    /** Busca un producto o lanza ModelNotFoundException. */
    public function findOrFail(int $id): Producto
    {
        return $this->model->with(['categoria', 'proveedor.usuario'])->findOrFail($id);
    }

    public function create(array $data): Producto
    {
        $producto = $this->model->create($data);

        return $producto->load(['categoria', 'proveedor.usuario']);
    }

    public function update(Producto $producto, array $data): Producto
    {
        $producto->update($data);

        return $producto->fresh(['categoria', 'proveedor.usuario']);
    }

    public function delete(Producto $producto): bool
    {
        return (bool) $producto->delete();
    }

    public function getByCategoria(int $categoriaId): Collection
    {
        return $this->model->with(['categoria', 'proveedor.usuario'])
            ->where('categoria_id', $categoriaId)
            ->orderBy('nombre')
            ->get();
    }

    public function search(string $termino): Collection
    {
        return $this->model->with(['categoria', 'proveedor.usuario'])
            ->where('nombre', 'like', '%' . $termino . '%')
            ->orderBy('nombre')
            ->get();
    }

    public function getActivos(): Collection
    {
        return $this->model->with(['categoria', 'proveedor.usuario'])
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();
    }

    public function getInactivos(): Collection
    {
        return $this->model->with(['categoria', 'proveedor.usuario'])
            ->where('activo', false)
            ->orderBy('nombre')
            ->get();
    }
}
