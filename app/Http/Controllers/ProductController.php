<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function buscar(Request $request)
    {
        // Usamos los filtros en inglés que pusimos en el Modelo Product
        $products = Product::query()
            ->league($request->league)
            ->team($request->team)
            ->get();

        return response()->json($products);
    }
}