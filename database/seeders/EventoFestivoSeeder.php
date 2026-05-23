<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\EventoFestivo;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventoFestivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
        ]);

        $categorias = Categoria::all();

        if ($categorias->isEmpty()) {
            $this->call(CategoriaSeeder::class);
            $categorias = Categoria::all();
        }

        foreach ($categorias as $categoria) {
            EventoFestivo::factory()->count(3)->create([
                'user_id' => $user->id,
                'categoria_id' => $categoria->id,
            ]);
        }
    }
}
