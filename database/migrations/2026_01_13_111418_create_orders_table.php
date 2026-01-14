<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Relación con el Usuario que compra (1:N)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->decimal('total', 10, 2); // Total a pagar
            $table->string('status')->default('pending'); // Estado: pendiente, pagado, enviado...
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
