<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Estos son los campos que permitimos rellenar
    protected $fillable = ['name', 'description'];

    // Relación: Una categoría TIENE MUCHOS productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}