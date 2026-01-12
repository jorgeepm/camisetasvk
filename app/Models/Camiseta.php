<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camiseta extends Model
{
    use HasFactory;

    // Estos son tus filtros (Scopes)
    public function scopeLiga($query, $liga)
    {
        if ($liga) {
            return $query->where('liga', $liga);
        }
    }

    public function scopeEquipo($query, $equipo)
    {
        if ($equipo) {
            return $query->where('nombre', 'LIKE', "%$equipo%");
        }
    }
}