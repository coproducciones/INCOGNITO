<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'categoria_id' => Categoria::factory(),
            'nombre' => fake()->words(3, true),
            'descripcion' => fake()->sentence(),
            'precio' => fake()->randomFloat(2, 10000, 500000),
            'stock' => fake()->numberBetween(0, 100),
            'activo' => fake()->boolean(90),
        ];
    }
}