<?php

namespace App\Services;

use App\Models\Permiso;
use App\Models\Usuario;
use App\Models\UsuarioPermiso;
use App\Repositories\PermisoRepository;
use Illuminate\Validation\ValidationException;

class PermisoService
{
    public function __construct(
        private PermisoRepository $repository
    ) {}

    public function listar()
    {
        return $this->repository->all();
    }

    public function obtener(int $id): Permiso
    {
        return $this->repository->find($id);
    }

    public function crear(array $data): Permiso
    {
        if (
            isset($data['nombre']) &&
            Permiso::query()->where('nombre', $data['nombre'])->exists()
        ) {
            throw ValidationException::withMessages([
                'nombre' => 'Ya existe un permiso con ese nombre. Utiliza un nombre único, por ejemplo productos.crear.',
            ]);
        }

        return $this->repository->create($data);
    }

    public function actualizar(Permiso $permiso, array $data): Permiso
    {
        if (
            isset($data['nombre']) &&
            Permiso::query()
                ->where('nombre', $data['nombre'])
                ->where('id_permiso', '!=', $permiso->id_permiso)
                ->exists()
        ) {
            throw ValidationException::withMessages([
                'nombre' => 'Ya existe otro permiso con ese nombre. Utiliza un nombre único, por ejemplo productos.crear.',
            ]);
        }

        return $this->repository->update($permiso, $data);
    }

    /**
     * Evita eliminar permisos que todavía están asignados.
     */
    public function eliminar(Permiso $permiso): void
    {
        if ($permiso->roles()->exists()) {
            throw new \RuntimeException(
                'No se puede eliminar un permiso asociado a roles.'
            );
        }

        if ($permiso->usuariosPermisos()->exists()) {
            throw new \RuntimeException(
                'No se puede eliminar un permiso asociado a usuarios.'
            );
        }

        $this->repository->delete($permiso);
    }

    /**
     * Crea o actualiza una excepción individual.
     * El modelo conserva correctamente created_at y updated_at.
     */
    public function asignarAUsuario(
        Usuario $usuario,
        Permiso $permiso,
        bool $permitido = true
    ): void {
        UsuarioPermiso::query()->updateOrCreate(
            [
                'id_usuario' => $usuario->getKey(),
                'id_permiso' => $permiso->id_permiso,
            ],
            [
                'permitido' => $permitido,
            ]
        );
    }

    /**
     * Eliminar la excepción hace que vuelva a aplicarse el permiso del rol.
     */
    public function quitarDeUsuario(
        Usuario $usuario,
        Permiso $permiso
    ): void {
        UsuarioPermiso::query()
            ->where('id_usuario', $usuario->getKey())
            ->where('id_permiso', $permiso->id_permiso)
            ->delete();
    }

    public function usuarioTienePermiso(
        Usuario $usuario,
        string $nombrePermiso
    ): bool {
        return $usuario->tienePermiso($nombrePermiso);
    }
}
