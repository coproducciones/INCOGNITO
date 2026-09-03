<?php

namespace App\Services;

use App\Models\Usuario;
use App\Repositories\UsuarioRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UsuarioService
{
    /**
     * Repository de usuarios.
     */
    protected UsuarioRepository $usuarioRepository;

    /**
     * Constructor.
     */
    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * Obtener todos los usuarios.
     */
    public function getAll(): Collection
    {
        return $this->usuarioRepository->getAll();
    }

    /**
     * Buscar un usuario.
     */
    public function findById(int $id): Usuario
    {
        return $this->usuarioRepository->findById($id);
    }

    /**
     * Crear un usuario.
     */
    public function create(array $data): Usuario
    {
        /*
         * La contraseña nunca se guarda
         * directamente en la base de datos.
         */
        $data['password'] = Hash::make($data['password']);

        return $this->usuarioRepository->create($data);
    }

    /**
     * Actualizar un usuario.
     */
    public function update(Usuario $usuario, array $data): Usuario
    {
        /*
         * Si se escribió una nueva contraseña,
         * la encriptamos.
         */
        if (!empty($data['password'])) {

            $data['password'] = Hash::make($data['password']);

        } else {

            /*
             * Si no se escribió contraseña,
             * eliminamos el campo para conservar
             * la contraseña actual.
             */
            unset($data['password']);
        }

        $this->usuarioRepository->update($usuario, $data);

        return $usuario->fresh();
    }

    /**
     * Eliminar un usuario.
     */
    public function delete(Usuario $usuario): bool
    {
        return $this->usuarioRepository->delete($usuario);
    }
}