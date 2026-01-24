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
            // Esta línea conecta el producto con la categoría
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); 
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->text('description');
            $table->integer('stock');
            $table->timestamps();
            $table->string('league')->nullable(); // Para la Liga
            $table->string('team')->nullable();   // Para el Equipo
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
