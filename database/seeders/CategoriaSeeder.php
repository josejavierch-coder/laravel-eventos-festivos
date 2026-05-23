<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Cumpleaños',
                'tipo' => 'ambos',
                'descripcion' => 'Fiestas temáticas, tortas y diversión para todas las edades.',
            ],
            [
                'nombre' => 'Matrimonios',
                'tipo' => 'ambos',
                'descripcion' => 'Bodas de ensueño, catering exclusivo y momentos mágicos.',
            ],
            [
                'nombre' => 'Bautizos',
                'tipo' => 'ambos',
                'descripcion' => 'Ceremonias íntimas, recuerdos especiales y ambiente familiar.',
            ],
            [
                'nombre' => 'Solo Fiestas',
                'tipo' => 'ambos',
                'descripcion' => 'Eventos corporativos, aniversarios y noches de baile.',
            ],
            [
                'nombre' => 'Baby Showers',
                'tipo' => 'ambos',
                'descripcion' => 'Celebrando la llegada del nuevo integrante de la familia.',
            ],
            [
                'nombre' => 'Misachicos',
                'tipo' => 'ambos',
                'descripcion' => 'Tradiciones religiosas y celebraciones comunitarias.',
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create([
                'nombre' => $categoria['nombre'],
                'slug' => Str::slug($categoria['nombre']),
                'tipo' => $categoria['tipo'],
                'descripcion' => $categoria['descripcion'],
                'estado' => true,
            ]);
        }
    }
}
