<?php

namespace App\Services;

use App\Models\Proveedor;
use App\Repositories\ProveedorRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProveedorService
{
    public function __construct(
        private readonly ProveedorRepository $repository
    ) {}

    public function listar()
    {
        return $this->repository->all();
    }

    public function obtener(int $id): Proveedor
    {
        return $this->repository->find($id);
    }

    public function crear(array $data): Proveedor
    {
        if ($this->repository->findByUser((int) $data['id_usuario'])) {
            throw ValidationException::withMessages([
                'id_usuario' => 'El usuario seleccionado ya está asociado a un proveedor.',
            ]);
        }

        return DB::transaction(function () use ($data): Proveedor {
            $categorias = $data['categorias'];
            unset($data['categorias']);

            $proveedor = $this->repository->create($data);
            $proveedor->categorias()->sync($categorias);

            return $proveedor->load('categorias');
        });
    }

    public function actualizar(Proveedor $proveedor, array $data): Proveedor
    {
        if (isset($data['id_usuario'])) {
            $otro = $this->repository->findByUser((int) $data['id_usuario']);
            if ($otro && $otro->id_proveedor !== $proveedor->id_proveedor) {
                throw ValidationException::withMessages([
                    'id_usuario' => 'El usuario seleccionado ya está asociado a otro proveedor.',
                ]);
            }
        }

        return DB::transaction(function () use ($proveedor, $data): Proveedor {
            $categorias = $data['categorias'] ?? null;
            unset($data['categorias']);

            $this->repository->update($proveedor, $data);

            if ($categorias !== null) {
                $proveedor->categorias()->sync($categorias);
            }

            return $proveedor->refresh()->load('categorias');
        });
    }

    public function eliminar(Proveedor $proveedor): void
    {
        $this->repository->delete($proveedor);
    }
}
