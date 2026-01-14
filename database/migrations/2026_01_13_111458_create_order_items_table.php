<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            
            // Relación con el Pedido (Al que pertenece)
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            
            // Relación con el Producto (Qué compró)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Datos de la compra
            $table->integer('quantity'); // Cantidad
            $table->decimal('price', 8, 2); // Precio al momento de la compra (importante)
            
            // Campos para la parte de Lautaro (Personalizador)
            $table->string('size')->nullable();          // Talla
            $table->string('custom_name')->nullable();   // Nombre en la camiseta
            $table->integer('custom_number')->nullable(); // Dorsal
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
