<?php

namespace App\Services;

use App\Models\Disponibilidad;
use App\Repositories\DisponibilidadRepository;
use App\Repositories\ProveedorRepository;
use Illuminate\Validation\ValidationException;

class DisponibilidadService
{
    public function __construct(
        private readonly DisponibilidadRepository $repository,
        private readonly ProveedorRepository $proveedorRepository
    ) {}

    public function listarPorProveedor(int $idProveedor)
    {
        $this->proveedorRepository->find($idProveedor);
        return $this->repository->allByProveedor($idProveedor);
    }

    public function obtener(int $id): Disponibilidad
    {
        return $this->repository->find($id);
    }

    public function crear(array $data): Disponibilidad
    {
        $this->proveedorRepository->find((int) $data['id_proveedor']);

        $existente = $this->repository->findByProveedorAndFecha(
            (int) $data['id_proveedor'],
            $data['fecha']
        );

        if ($existente) {
            throw ValidationException::withMessages([
                'fecha' => 'Ya existe una disponibilidad para ese proveedor y esa fecha.',
            ]);
        }

        return $this->repository->create($data);
    }

    public function actualizar(Disponibilidad $disponibilidad, array $data): Disponibilidad
    {
        $idProveedor = (int) ($data['id_proveedor'] ?? $disponibilidad->id_proveedor);
        $fecha = $data['fecha'] ?? $disponibilidad->fecha->toDateString();

        $this->proveedorRepository->find($idProveedor);

        $existente = $this->repository->findByProveedorAndFecha($idProveedor, $fecha);
        if ($existente && $existente->id_disponibilidad !== $disponibilidad->id_disponibilidad) {
            throw ValidationException::withMessages([
                'fecha' => 'Ya existe una disponibilidad para ese proveedor y esa fecha.',
            ]);
        }

        $this->repository->update($disponibilidad, $data);
        return $disponibilidad->refresh();
    }

    public function eliminar(Disponibilidad $disponibilidad): void
    {
        $this->repository->delete($disponibilidad);
    }
}
