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
    public function __construct(
        UsuarioRepository $usuarioRepository
    ) {
        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * =========================================================
     * CONSULTAS
     * =========================================================
     */

    /**
     * Obtener todos los usuarios.
     */
    public function getAll(): Collection
    {
        return $this->usuarioRepository->getAll();
    }

    /**
     * Buscar un usuario por ID.
     */
    public function findById(int $id): Usuario
    {
        return $this->usuarioRepository->findById($id);
    }

    /**
     * =========================================================
     * CREAR
     * =========================================================
     */

    /**
     * Crear un usuario.
     */
    public function create(array $data): Usuario
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make(
                $data['password']
            );
        }

        return $this->usuarioRepository->create($data);
    }

    /**
     * =========================================================
     * ACTUALIZAR
     * =========================================================
     */

    /**
     * Actualizar un usuario desde el CRUD administrativo.
     */
    public function update(
        Usuario $usuario,
        array $data
    ): Usuario {
        if (
            array_key_exists('password', $data) &&
            !empty($data['password'])
        ) {
            $data['password'] = Hash::make(
                $data['password']
            );
        } else {
            unset($data['password']);
        }

        $this->usuarioRepository->update(
            $usuario,
            $data
        );

        return $usuario->fresh();
    }

    /**
     * Actualizar solamente los datos permitidos del perfil.
     *
     * Este método NO modifica:
     * - id
     * - id_rol
     * - id_estado
     * - permisos
     */
    public function updateProfile(
        Usuario $usuario,
        array $data
    ): Usuario {
        $profileData = [
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'telefono' => $data['telefono'] ?? null,
        ];

        if (
            array_key_exists('password', $data) &&
            !empty($data['password'])
        ) {
            $profileData['password'] = Hash::make(
                $data['password']
            );
        }

        $this->usuarioRepository->update(
            $usuario,
            $profileData
        );

        return $usuario->fresh();
    }

    /**
     * =========================================================
     * ELIMINAR
     * =========================================================
     */

    /**
     * Eliminar un usuario.
     */
    public function delete(
        Usuario $usuario
    ): bool {
        return $this->usuarioRepository->delete(
            $usuario
        );
    }
}
