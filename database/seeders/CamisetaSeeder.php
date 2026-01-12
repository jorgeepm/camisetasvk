<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CamisetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Camiseta 1
    \App\Models\Camiseta::create([
        'nombre' => 'Camiseta Local Real Madrid',
        'equipo' => 'Real Madrid',
        'liga' => 'Española',
        'precio' => 89.99,
    ]);

    // Camiseta 2
    \App\Models\Camiseta::create([
        'nombre' => 'Camiseta Visitante Manchester City',
        'equipo' => 'Manchester City',
        'liga' => 'Inglesa',
        'precio' => 75.50,
    ]);

    // Camiseta 3
    \App\Models\Camiseta::create([
        'nombre' => 'Camiseta Suplente Argentina',
        'equipo' => 'Selección Argentina',
        'liga' => 'Selecciones',
        'precio' => 95.00,
    ]);

    // Camiseta 4
    \App\Models\Camiseta::create([
        'nombre' => 'Camiseta Local FC Barcelona',
        'equipo' => 'FC Barcelona',
        'liga' => 'Española',
        'precio' => 85.00,
    ]);
    }
}
