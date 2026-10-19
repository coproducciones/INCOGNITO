<?php

namespace App\Services;

use App\Models\Permiso;
use App\Models\Rol;
use App\Repositories\RolRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RolService
{
    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __construct(
        private readonly RolRepository $repository
    ) {}


    /*
    |--------------------------------------------------------------------------
    | LISTAR ROLES
    |--------------------------------------------------------------------------
    */

    public function listar()
    {
        return $this->repository->all();
    }


    /*
    |--------------------------------------------------------------------------
    | OBTENER UN ROL
    |--------------------------------------------------------------------------
    */

    public function obtener(int $id): Rol
    {
        return $this->repository->find($id);
    }


    /*
    |--------------------------------------------------------------------------
    | CREAR ROL
    |--------------------------------------------------------------------------
    */

    public function crear(array $data): Rol
    {
        $existe = $this->repository->findByName(
            $data['nombre']
        );

        if ($existe) {

            throw ValidationException::withMessages([
                'nombre' =>
                    'Ya existe un rol con ese nombre.',
            ]);
        }

        return $this->repository->create($data);
    }


    /*
    |--------------------------------------------------------------------------
    | CREAR ROL CON PERMISOS
    |--------------------------------------------------------------------------
    */

    public function crearConPermisos(
        array $data,
        array $permisos
    ): Rol {

        return DB::transaction(
            function () use (
                $data,
                $permisos
            ) {

                /*
                 * Creamos el rol.
                 */

                $rol = $this->crear($data);


                /*
                 * Asignamos sus permisos.
                 */

                $this->sincronizarPermisos(
                    $rol,
                    $permisos
                );


                return $rol->refresh();
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR ROL
    |--------------------------------------------------------------------------
    */

    public function actualizar(
        Rol $rol,
        array $data
    ): Rol {

        if (
            $this->esRolAdministrativoProtegido($rol) &&
            isset($data['nombre']) &&
            mb_strtolower(trim($data['nombre'])) !== mb_strtolower(trim($rol->nombre))
        ) {
            throw ValidationException::withMessages([
                'nombre' => 'No se puede cambiar el nombre del rol administrativo protegido.',
            ]);
        }

        /*
         * Comprobamos que el nombre no pertenezca
         * a otro rol.
         */

        if (isset($data['nombre'])) {

            $otroRol = $this->repository->findByName(
                $data['nombre']
            );

            if (
                $otroRol &&
                $otroRol->id_rol !== $rol->id_rol
            ) {

                throw ValidationException::withMessages([
                    'nombre' =>
                        'Ya existe otro rol con ese nombre.',
                ]);
            }
        }


        /*
         * Actualizamos el rol.
         */

        $this->repository->update(
            $rol,
            $data
        );


        return $rol->refresh();
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR ROL CON PERMISOS
    |--------------------------------------------------------------------------
    |
    | Actualiza:
    |
    | - Nombre del rol.
    | - Permisos asignados.
    |
    */

    public function actualizarConPermisos(
        Rol $rol,
        array $data,
        array $permisos
    ): Rol {

        return DB::transaction(
            function () use (
                $rol,
                $data,
                $permisos
            ) {

                /*
                 * Actualizamos la información del rol.
                 */

                $rol = $this->actualizar(
                    $rol,
                    $data
                );


                /*
                 * Actualizamos sus permisos.
                 */

                $this->sincronizarPermisos(
                    $rol,
                    $permisos
                );


                return $rol->refresh();
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR ROL
    |--------------------------------------------------------------------------
    */

    public function eliminar(
        Rol $rol
    ): void {

        if ($this->esRolAdministrativoProtegido($rol)) {
            throw new \RuntimeException(
                'No se puede eliminar el rol administrativo protegido.'
            );
        }

        /*
         * No permitimos eliminar un rol que tenga
         * usuarios asociados.
         */

        if ($rol->usuarios()->exists()) {

            throw new \RuntimeException(
                'No se puede eliminar el rol porque tiene usuarios asociados.'
            );
        }


        /*
         * Eliminamos sus permisos.
         */

        $rol->permisos()->detach();


        /*
         * Eliminamos el rol.
         */

        $this->repository->delete($rol);
    }


    /*
    |--------------------------------------------------------------------------
    | SINCRONIZAR PERMISOS
    |--------------------------------------------------------------------------
    */

    public function sincronizarPermisos(
        Rol $rol,
        array $permisos
    ): void {

        if ($this->esRolAdministrativoProtegido($rol)) {
            throw ValidationException::withMessages([
                'permisos' => 'No se pueden modificar los permisos del rol administrativo protegido desde esta pantalla.',
            ]);
        }

        /*
         * Convertimos los IDs a enteros.
         */

        $permisos = collect($permisos)
            ->map(
                fn ($permiso) => (int) $permiso
            )
            ->filter(
                fn ($permiso) => $permiso > 0
            )
            ->unique()
            ->values()
            ->all();


        /*
         * Verificamos que los permisos existan.
         */

        if (!empty($permisos)) {

            $cantidad = Permiso::query()
                ->whereIn(
                    'id_permiso',
                    $permisos
                )
                ->count();


            if ($cantidad !== count($permisos)) {

                throw ValidationException::withMessages([
                    'permisos' =>
                        'Uno o más permisos seleccionados no existen.',
                ]);
            }
        }


        /*
         * Actualizamos la tabla rol_permiso.
         *
         * Los marcados se mantienen.
         * Los nuevos se agregan.
         * Los desmarcados se eliminan.
         */

        $rol->permisos()->sync($permisos);
    }


    /**
     * Protege el rol administrativo existente contra cambios accidentales.
     */
    private function esRolAdministrativoProtegido(Rol $rol): bool
    {
        $nombre = mb_strtolower(trim((string) $rol->nombre));

        return in_array($nombre, ['admin', 'administrador'], true);
    }
}
