<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', ['categories' => $categories]);
    }

    public function show(Category $category)
    {
        // 1. Buscamos los productos de esta categoría
        $products = $category->products()->paginate(12);

        // 2. ENVIAMOS A LA VISTA NUEVA 'catalog' (antes ponía 'welcome')
        return view('catalog', compact('category', 'products'));
    }
}