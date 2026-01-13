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
        'image_path'
    ];

    // Relación: Un producto PERTENECE A una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}