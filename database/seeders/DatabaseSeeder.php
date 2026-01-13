<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CREACIÓN DE USUARIOS ADMINISTRADORES (EL EQUIPO)
        $teamMembers = [
            ['name' => 'Jorge Admin', 'email' => 'jorge@camisetasvk.com'],
            ['name' => 'Lautaro Admin', 'email' => 'lautaro@camisetasvk.com'],
            ['name' => 'Marcos Admin', 'email' => 'marcos@camisetasvk.com'],
            ['name' => 'Mayo Admin', 'email' => 'mayo@camisetasvk.com'],
        ];

        foreach ($teamMembers as $member) {
            User::create([
                'name' => $member['name'],
                'email' => $member['email'],
                'password' => Hash::make('password'), // Todos entran con "password"
                'role' => 'admin', // <--- ¡VITAL! Sin esto no podréis entrar al panel
            ]);
        }
        
        // Creamos un cliente normal para pruebas
        User::create([
             'name' => 'Cliente Ejemplo',
             'email' => 'cliente@cliente.com',
             'password' => Hash::make('password'),
             'role' => 'user', 
        ]);

        // 2. LAS 3 CATEGORÍAS PRINCIPALES
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

        // 3. PRODUCTOS DE PRUEBA (¡AHORA CON STOCK!)
        
        // --- Temporada Actual ---
        Product::create([
            'category_id' => $catActual->id,
            'name' => 'Real Madrid 2026 Local',
            'description' => 'Camiseta blanca clásica con detalles dorados. Tecnología Heat.Rdy.',
            'price' => 95.00,
            'stock' => 50, // <--- AÑADIDO
            'image_path' => 'madrid-2026.jpg'
        ]);
        
        Product::create([
            'category_id' => $catActual->id,
            'name' => 'Rayo Vallecano 2026 Centenario',
            'description' => 'Edición especial con la franja en rayo real. Escudo bordado.',
            'price' => 80.00,
            'stock' => 50, // <--- AÑADIDO
            'image_path' => 'rayo-2026.jpg'
        ]);

        // --- Outlet ---
        Product::create([
            'category_id' => $catOutlet->id,
            'name' => 'Manchester City 2024 Treble',
            'description' => 'La camiseta con la que ganaron todo. Últimas tallas.',
            'price' => 45.00,
            'stock' => 50, // <--- AÑADIDO
            'image_path' => 'city-2024.jpg'
        ]);

        // --- Retro ---
        Product::create([
            'category_id' => $catRetro->id,
            'name' => 'Brasil 2002 Ronaldo',
            'description' => 'La camiseta del pentacampeonato. El Fenómeno.',
            'price' => 130.00,
            'stock' => 50, // <--- AÑADIDO (Pocas unidades porque es exclusiva)
            'image_path' => 'brasil-2002.jpg'
        ]);

        Product::create([
            'category_id' => $catRetro->id,
            'name' => 'AC Milan 2007 Kaka',
            'description' => 'La época dorada de San Siro. Publicidad de Bwin.',
            'price' => 115.00,
            'stock' => 50, // <--- AÑADIDO
            'image_path' => 'milan-2007.jpg'
        ]);
    }
}