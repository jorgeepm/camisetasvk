<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Estos son los campos que permitimos rellenar masivamente (seguridad)
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'image_blob'
    ];

    // Relación: Un producto PERTENECE A una categoría
    // 1. Relación: Un producto PERTENECE A una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 2. Relación: Un producto aparece en muchos items de pedido
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // 3. Scopes de Lautaro (Filtros)
    public function scopeLeague($query, $league)
    {
        if ($league) {
            return $query->where('league', $league);
        }
    }

    public function scopeTeam($query, $team)
    {
        if ($team) {
            return $query->where('team', 'LIKE', '%' . $team . '%');
        }
    }
}