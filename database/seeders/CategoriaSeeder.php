<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Ejecutar el seeder.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Audiovisual',
                'descripcion' => 'Servicios relacionados con producción audiovisual.',
            ],
            [
                'nombre' => 'Musical',
                'descripcion' => 'Servicios relacionados con música y producción musical.',
            ],
            [
                'nombre' => 'Manufactura',
                'descripcion' => 'Servicios relacionados con fabricación y producción.',
            ],
            [
                'nombre' => 'Arte',
                'descripcion' => 'Servicios relacionados con arte y expresión creativa.',
            ],
            [
                'nombre' => 'Diseño',
                'descripcion' => 'Servicios relacionados con diseño gráfico y creativo.',
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::updateOrCreate(
                ['nombre' => $categoria['nombre']],
                ['descripcion' => $categoria['descripcion']]
            );
        }
    }
}