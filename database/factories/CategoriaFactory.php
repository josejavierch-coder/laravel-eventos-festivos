<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombre = $this->faker->unique()->words(2, true);
        return [
            'nombre' => ucfirst($nombre),
            'slug' => Str::slug($nombre),
            'tipo' => $this->faker->randomElement(['publicacion', 'proyecto', 'ambos']),
            'descripcion' => $this->faker->sentence(),
            'estado' => true,
        ];
    }
}
