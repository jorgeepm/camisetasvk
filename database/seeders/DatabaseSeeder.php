<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $teamMembers = [
            ['name' => 'Jorge Admin', 'email' => 'jorge@camisetasvk.com'],
            ['name' => 'Lautaro Admin', 'email' => 'lautaro@camisetasvk.com'],
            ['name' => 'Marcos Admin', 'email' => 'marcos@camisetasvk.com'],
            ['name' => 'Mayo Admin', 'email' => 'mayo@camisetasvk.com'],
        ];

        foreach ($teamMembers as $member) {
            User::factory()->create([
                'name' => $member['name'],
                'email' => $member['email'],
                'password' => bcrypt('password'), // Misma contraseña para todos: "password"
                'role' => 'admin', // <--- ¡IMPORTANTE! Asignamos el rol aquí
            ]);
        }

        // 2. Las 3 Categorías Principales
        $catActual = Category::create([
            'name' => 'Temporada Actual 25/26',
            'description' => 'Las nuevas equipaciones oficiales. Estrena los colores de este año.',
        ]);

        $catOutlet = Category::create([
            'name' => 'Outlet / Temporadas Pasadas',
            'description' => 'Oportunidades únicas de años anteriores a precios reducidos.',
        ]);

        $catRetro = Category::create([
            'name' => 'Retro & Leyendas',
            'description' => 'Historia del fútbol. Camisetas icónicas que nunca mueren.',
        ]);

        // 3. Productos de Prueba (Datos iniciales)
        
        // --- Temporada Actual 25/26 ---
        Product::create([
            'category_id' => $catActual->id,
            'name' => 'Real Madrid 2026 Local',
            'description' => 'Camiseta blanca clásica con detalles dorados. Tecnología Heat.Rdy.',
            'price' => 95.00,
            'image_path' => 'madrid-2026.jpg'
        ]);
        
        Product::create([
            'category_id' => $catActual->id,
            'name' => 'Rayo Vallecano 2026 Centenario',
            'description' => 'Edición especial con la franja en rayo real. Escudo bordado.',
            'price' => 80.00,
            'image_path' => 'rayo-2026.jpg'
        ]);

        // --- Outlet ---
        Product::create([
            'category_id' => $catOutlet->id,
            'name' => 'Manchester City 2024 Treble',
            'description' => 'La camiseta con la que ganaron todo. Últimas tallas.',
            'price' => 45.00,
            'image_path' => 'city-2024.jpg'
        ]);

        // --- Retro ---
        Product::create([
            'category_id' => $catRetro->id,
            'name' => 'Brasil 2002 Ronaldo',
            'description' => 'La camiseta del pentacampeonato. El Fenómeno.',
            'price' => 130.00,
            'image_path' => 'brasil-2002.jpg'
        ]);

        Product::create([
            'category_id' => $catRetro->id,
            'name' => 'AC Milan 2007 Kaka',
            'description' => 'La época dorada de San Siro. Publicidad de Bwin.',
            'price' => 115.00,
            'image_path' => 'milan-2007.jpg'
        ]);
    }
}