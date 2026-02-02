<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); 
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->text('description');
            $table->integer('stock');
            
            // 👇👇👇 AÑADE ESTAS DOS LÍNEAS AQUÍ 👇👇👇
            $table->string('image')->nullable();        // Para guardar la ruta "products/foto.png"
            $table->longText('image_blob')->nullable(); // Para guardar el código binario gigante
            // 👆👆👆 ------------------------------ 👆👆👆

            $table->timestamps();
            $table->string('league')->nullable(); 
            $table->string('team')->nullable();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
