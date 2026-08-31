<?php

namespace App\Services;

use App\Models\Producto;
use App\Repositories\ProductoRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProductoService
{
    /**
     * Repository de productos.
     */
    protected ProductoRepository $repository;

    /**
     * Constructor.
     */
    public function __construct(ProductoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Obtener todos los productos.
     */
    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Buscar un producto.
     */
    public function find(int $id): ?Producto
    {
        return $this->repository->find($id);
    }

    /**
     * Buscar un producto o lanzar excepción.
     */
    public function findOrFail(int $id): Producto
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Crear un producto.
     */
    public function create(array $data): Producto
    {
        return DB::transaction(function () use ($data) {

            return $this->repository->create([
                'categoria_id' => $data['categoria_id'],
                'nombre'       => $data['nombre'],
                'descripcion'  => $data['descripcion'] ?? null,
                'precio'       => $data['precio'],
                'stock'        => $data['stock'] ?? 0,
                'activo'       => $data['activo'] ?? true,
            ]);
        });
    }

    /**
     * Actualizar un producto.
     */
    public function update(Producto $producto, array $data): Producto
    {
        return DB::transaction(function () use ($producto, $data) {

            return $this->repository->update($producto, [
                'categoria_id' => $data['categoria_id'],
                'nombre'       => $data['nombre'],
                'descripcion'  => $data['descripcion'] ?? null,
                'precio'       => $data['precio'],
                'stock'        => $data['stock'] ?? 0,
                'activo'       => $data['activo'] ?? false,
            ]);
        });
    }

    /**
     * Eliminar un producto.
     */
    public function delete(Producto $producto): bool
    {
        return DB::transaction(function () use ($producto) {

            return $this->repository->delete($producto);
        });
    }

    /**
     * Obtener productos de una categoría.
     */
    public function getByCategoria(int $categoriaId): Collection
    {
        return $this->repository->getByCategoria($categoriaId);
    }

    /**
     * Buscar productos por nombre.
     */
    public function search(string $termino): Collection
    {
        return $this->repository->search($termino);
    }

    /**
     * Obtener productos activos.
     */
    public function getActivos(): Collection
    {
        return $this->repository->getActivos();
    }

    /**
     * Obtener productos inactivos.
     */
    public function getInactivos(): Collection
    {
        return $this->repository->getInactivos();
    }
}
