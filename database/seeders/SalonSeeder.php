<?php

namespace Database\Seeders;

use App\Models\Salon;
use Illuminate\Database\Seeder;

class SalonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Salon::create([
            'nombre' => 'Gran Salón Real',
            'direccion' => 'Av. de las Américas 123, Centro Histórico',
            'imagen' => null, // Opcional, se puede añadir una URL si se desea pero asset('storage/...') espera archivos reales
            'estado' => true,
        ]);

        Salon::create([
            'nombre' => 'Jardín de los Sueños',
            'direccion' => 'Calle Los Pinos 456, Valle Alto',
            'imagen' => null,
            'estado' => true,
        ]);

        Salon::create([
            'nombre' => 'Centro de Convenciones Terraza',
            'direccion' => 'Av. Principal 789, Zona Norte',
            'imagen' => null,
            'estado' => true,
        ]);
    }
}
