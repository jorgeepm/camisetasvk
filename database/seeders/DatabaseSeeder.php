<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear tu usuario Administrador
        User::factory()->create([
            'name' => 'Jorge Admin',
            'email' => 'admin@camisetasvk.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Crear Categorías
        $catRock = Category::create([
            'name' => 'Rock & Metal',
            'description' => 'Camisetas de tus bandas favoritas'
        ]);
        
        $catSeries = Category::create([
            'name' => 'Series y Pelis',
            'description' => 'Merchandising de cine y TV'
        ]);

        $catHumor = Category::create([
            'name' => 'Frases Divertidas',
            'description' => 'Para echarse unas risas'
        ]);

        // 3. Crear Camisetas (Productos)
        Product::create([
            'category_id' => $catRock->id,
            'name' => 'Camiseta AC/DC Clásica',
            'price' => 19.99,
            'description' => '100% Algodón negro. Talla L.',
            'image_path' => 'acdc.jpg' 
        ]);

        Product::create([
            'category_id' => $catRock->id,
            'name' => 'Sudadera Metallica',
            'price' => 35.50,
            'description' => 'Con capucha y bolsillo canguro.',
            'image_path' => 'metallica.jpg'
        ]);

        Product::create([
            'category_id' => $catSeries->id,
            'name' => 'Camiseta Winter is Coming',
            'price' => 15.00,
            'description' => 'Juego de Tronos. Casa Stark.',
            'image_path' => 'got.jpg'
        ]);
    }
}