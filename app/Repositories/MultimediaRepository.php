<?php

namespace App\Repositories;

use App\Models\Multimedia;
use Illuminate\Database\Eloquent\Collection;

class MultimediaRepository
{
    /*
    |--------------------------------------------------------------------------
    | Obtener todas las multimedia
    |--------------------------------------------------------------------------
    */

    public function getAll(): Collection
    {
        return Multimedia::with([
            'producto',
            'contenido',
        ])
            ->orderByDesc('destacado')
            ->orderBy('id_multimedia')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Crear multimedia
    |--------------------------------------------------------------------------
    */

    public function create(array $data): Multimedia
    {
        return Multimedia::create($data)
            ->load([
                'producto',
                'contenido',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Actualizar multimedia
    |--------------------------------------------------------------------------
    */

    public function update(
        Multimedia $multimedia,
        array $data
    ): Multimedia {
        $multimedia->update($data);

        return $multimedia
            ->refresh()
            ->load([
                'producto',
                'contenido',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar multimedia
    |--------------------------------------------------------------------------
    */

    public function delete(Multimedia $multimedia): bool
    {
        return (bool) $multimedia->delete();
    }
}
