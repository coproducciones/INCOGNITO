<?php

namespace App\Services;

use App\Models\Producto;
use App\Models\Proveedor;
use App\Repositories\ProductoRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductoService
{
    public function __construct(private ProductoRepository $repository)
    {
    }

    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    public function find(int $id): ?Producto
    {
        return $this->repository->find($id);
    }

    public function findOrFail(int $id): Producto
    {
        return $this->repository->findOrFail($id);
    }

    /** Crea un producto y confirma que el proveedor siga activo. */
    public function create(array $data): Producto
    {
        return DB::transaction(function () use ($data) {
            $this->validarProveedor($data['id_proveedor'] ?? null);

            return $this->repository->create($this->datosProducto($data, true));
        });
    }

    /** Actualiza el producto dentro de una transacción. */
    public function update(Producto $producto, array $data): Producto
    {
        return DB::transaction(function () use ($producto, $data) {
            $this->validarProveedor($data['id_proveedor'] ?? null);

            return $this->repository->update($producto, $this->datosProducto($data, false));
        });
    }

    public function delete(Producto $producto): bool
    {
        return DB::transaction(fn () => $this->repository->delete($producto));
    }

    public function getByCategoria(int $categoriaId): Collection
    {
        return $this->repository->getByCategoria($categoriaId);
    }

    public function search(string $termino): Collection
    {
        return $this->repository->search(trim($termino));
    }

    public function getActivos(): Collection
    {
        return $this->repository->getActivos();
    }

    public function getInactivos(): Collection
    {
        return $this->repository->getInactivos();
    }

    /** Centraliza los campos permitidos para evitar duplicar arreglos. */
    private function datosProducto(array $data, bool $nuevo): array
    {
        return [
            'categoria_id' => $data['categoria_id'],
            'id_proveedor' => $data['id_proveedor'],
            'nombre' => trim($data['nombre']),
            'descripcion' => $data['descripcion'] ?? null,
            'precio' => $data['precio'],
            'stock' => $data['stock'] ?? 0,
            // Un checkbox desmarcado no llega en el request.
            'activo' => array_key_exists('activo', $data) ? (bool) $data['activo'] : $nuevo,
        ];
    }

    /** Impide asignar productos a proveedores eliminados o inexistentes. */
    private function validarProveedor(mixed $idProveedor): void
    {
        if (!$idProveedor || !Proveedor::query()->whereKey($idProveedor)->exists()) {
            throw ValidationException::withMessages([
                'id_proveedor' => 'Selecciona un proveedor válido y activo.',
            ]);
        }
    }
}
