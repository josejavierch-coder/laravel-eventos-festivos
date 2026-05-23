<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventoFestivo>
 */
class EventoFestivoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titulo = $this->faker->sentence(4);
        return [
            'user_id' => User::factory(),
            'categoria_id' => Categoria::factory(),
            'titulo' => $titulo,
            'slug' => Str::slug($titulo),
            'descripcion' => $this->faker->paragraphs(3, true),
            'tipo' => $this->faker->randomElement(['imagen', 'pdf', 'enlace', 'archivo']),
            'archivo' => null,
            'enlace_externo' => $this->faker->optional()->url(),
            'imagen_portada' => 'https://picsum.photos/seed/' . rand(1, 1000) . '/800/600',
            'estado' => true,
            'vistas' => $this->faker->numberBetween(0, 1000),
            'publicado_en' => now(),
        ];
    }
}
