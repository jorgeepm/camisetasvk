<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Esto permite rellenar todos los campos (user_id, total, etc.)
    protected $guarded = [];

    // Relación: Un pedido pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un pedido tiene muchos items (camisetas)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}