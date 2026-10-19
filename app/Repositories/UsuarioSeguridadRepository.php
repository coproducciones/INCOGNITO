<?php

namespace App\Repositories;

use App\Models\UsuarioSeguridad;

class UsuarioSeguridadRepository
{
    public function all()
    {
        return UsuarioSeguridad::with(['rol', 'estado'])
            ->orderBy('nombre')
            ->orderBy('apellido')
            ->get();
    }

    public function find(int $id): UsuarioSeguridad
    {
        return UsuarioSeguridad::with(['rol', 'estado'])->findOrFail($id);
    }

    public function update(UsuarioSeguridad $usuario, array $data): UsuarioSeguridad
    {
        $usuario->update($data);
        return $usuario->refresh()->load(['rol', 'estado']);
    }
}
