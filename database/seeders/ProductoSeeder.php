<?php

namespace Database\Seeders;

use App\Models\producto;
use App\Models\categoria;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Ejecutar el seeder.
     */
    public function run(): void
    {
        /*
         * =========================================================
         * BUSCAR CATEGORÍAS
         * =========================================================
         *
         * Los productos necesitan una categoría existente.
         * Por eso buscamos cada categoría por su nombre.
         */

        $audiovisual = Categoria::where('nombre', 'Audiovisual')->first();
        $musical     = Categoria::where('nombre', 'Musical')->first();
        $manufactura = Categoria::where('nombre', 'Manufactura')->first();
        $arte        = Categoria::where('nombre', 'Arte')->first();
        $diseno      = Categoria::where('nombre', 'Diseño')->first();

        /*
         * =========================================================
         * VERIFICAR CATEGORÍAS
         * =========================================================
         */

        if (
            !$audiovisual ||
            !$musical ||
            !$manufactura ||
            !$arte ||
            !$diseno
        ) {
            $this->command->error(
                'No se encontraron todas las categorías necesarias.'
            );

            $this->command->info(
                'Ejecuta primero: php artisan db:seed --class=CategoriaSeeder'
            );

            return;
        }

        /*
         * =========================================================
         * PRODUCTOS
         * =========================================================
         */

        $productos = [

            // -----------------------------------------------------
            // AUDIOVISUAL
            // -----------------------------------------------------

            [
                'categoria_id' => $audiovisual->id,
                'nombre' => 'Producción de Video',
                'descripcion' => 'Producción y edición de contenido audiovisual profesional.',
                'precio' => 850000,
                'stock' => 10,
                'activo' => true,
            ],

            [
                'categoria_id' => $audiovisual->id,
                'nombre' => 'Fotografía Profesional',
                'descripcion' => 'Servicio de fotografía para proyectos comerciales y creativos.',
                'precio' => 500000,
                'stock' => 15,
                'activo' => true,
            ],

            // -----------------------------------------------------
            // MUSICAL
            // -----------------------------------------------------

            [
                'categoria_id' => $musical->id,
                'nombre' => 'Producción Musical',
                'descripcion' => 'Producción, grabación y edición de proyectos musicales.',
                'precio' => 700000,
                'stock' => 8,
                'activo' => true,
            ],

            [
                'categoria_id' => $musical->id,
                'nombre' => 'Grabación de Voz',
                'descripcion' => 'Grabación profesional de voces para proyectos musicales y audiovisuales.',
                'precio' => 300000,
                'stock' => 12,
                'activo' => true,
            ],

            // -----------------------------------------------------
            // MANUFACTURA
            // -----------------------------------------------------

            [
                'categoria_id' => $manufactura->id,
                'nombre' => 'Fabricación Personalizada',
                'descripcion' => 'Diseño y fabricación personalizada de productos.',
                'precio' => 950000,
                'stock' => 5,
                'activo' => true,
            ],

            [
                'categoria_id' => $manufactura->id,
                'nombre' => 'Prototipado',
                'descripcion' => 'Desarrollo de prototipos para proyectos creativos y comerciales.',
                'precio' => 650000,
                'stock' => 7,
                'activo' => true,
            ],

            // -----------------------------------------------------
            // ARTE
            // -----------------------------------------------------

            [
                'categoria_id' => $arte->id,
                'nombre' => 'Ilustración Personalizada',
                'descripcion' => 'Creación de ilustraciones digitales personalizadas.',
                'precio' => 400000,
                'stock' => 20,
                'activo' => true,
            ],

            [
                'categoria_id' => $arte->id,
                'nombre' => 'Obra Artística',
                'descripcion' => 'Creación de piezas artísticas originales.',
                'precio' => 1200000,
                'stock' => 3,
                'activo' => true,
            ],

            // -----------------------------------------------------
            // DISEÑO
            // -----------------------------------------------------

            [
                'categoria_id' => $diseno->id,
                'nombre' => 'Identidad Visual',
                'descripcion' => 'Diseño de identidad visual y elementos gráficos para marcas.',
                'precio' => 900000,
                'stock' => 10,
                'activo' => true,
            ],

            [
                'categoria_id' => $diseno->id,
                'nombre' => 'Diseño de Marca',
                'descripcion' => 'Creación de conceptos gráficos y sistemas visuales para marcas.',
                'precio' => 750000,
                'stock' => 10,
                'activo' => true,
            ],
        ];

        /*
         * =========================================================
         * INSERTAR PRODUCTOS
         * =========================================================
         */

        foreach ($productos as $producto) {
            Producto::updateOrCreate(
                [
                    'nombre' => $producto['nombre'],
                ],
                $producto
            );
        }

        /*
         * =========================================================
         * MENSAJE DE CONFIRMACIÓN
         * =========================================================
         */

        $this->command->info(
            'Productos creados/actualizados correctamente.'
        );
    }
}