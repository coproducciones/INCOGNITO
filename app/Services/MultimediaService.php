<?php

namespace App\Services;

use App\Models\Multimedia;
use App\Repositories\MultimediaRepository;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class MultimediaService
{
    public function __construct(
        protected MultimediaRepository $multimediaRepository
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener todos
    |--------------------------------------------------------------------------
    */

    public function getAll(): Collection
    {
        return $this->multimediaRepository->getAll();
    }

    /*
    |--------------------------------------------------------------------------
    | Crear
    |--------------------------------------------------------------------------
    */

    public function create(array $data): Multimedia
    {
        $data = $this->normalizeTarget($data);

        $data['destacado'] = (bool) (
            $data['destacado'] ?? false
        );

        return $this->multimediaRepository->create($data);
    }

    /*
    |--------------------------------------------------------------------------
    | Actualizar
    |--------------------------------------------------------------------------
    */

    public function update(
        Multimedia $multimedia,
        array $data
    ): Multimedia {

        $data = $this->normalizeTarget($data);

        $data['destacado'] = (bool) (
            $data['destacado'] ?? false
        );

        return $this->multimediaRepository->update(
            $multimedia,
            $data
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar
    |--------------------------------------------------------------------------
    */

    public function delete(Multimedia $multimedia): bool
    {
        return $this->multimediaRepository->delete(
            $multimedia
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Normalizar asociación
    |--------------------------------------------------------------------------
    */

    private function normalizeTarget(array $data): array
    {
        $targets = [
            'id_producto',
            'id_contenido',
        ];

        $filled = array_filter(
            $targets,
            function (string $field) use ($data): bool {

                return array_key_exists($field, $data)
                    && $data[$field] !== null
                    && $data[$field] !== '';
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Debe existir exactamente una asociación
        |--------------------------------------------------------------------------
        */

        if (count($filled) !== 1) {

            throw new InvalidArgumentException(
                'La media debe estar asociada exactamente a un producto o a un contenido.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | El campo no seleccionado se establece como NULL
        |--------------------------------------------------------------------------
        */

        foreach ($targets as $field) {

            if (!in_array($field, $filled, true)) {
                $data[$field] = null;
            }
        }

        return $data;
    }
}
