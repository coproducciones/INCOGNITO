<?php

namespace App\Repositories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Collection;

class UsuarioRepository
{
    /**
     * Obtener todos los usuarios.
     */
    public function getAll(): Collection
    {
        return Usuario::orderBy('nombre')->get();
    }

    /**
     * Buscar un usuario por ID.
     */
    public function findById(int $id): Usuario
    {
        return Usuario::findOrFail($id);
    }

    /**
     * Crear un usuario.
     */
    public function create(array $data): Usuario
    {
        return Usuario::create($data);
    }

    /**
     * Actualizar un usuario.
     */
    public function update(Usuario $usuario, array $data): bool
    {
        return $usuario->update($data);
    }

    /**
     * Eliminar un usuario.
     *
     * Como Usuario utiliza SoftDeletes,
     * esto realiza una eliminación lógica.
     */
    public function delete(Usuario $usuario): bool
    {
        return $usuario->delete();
    }
}