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

    // --- MÉTODOS DE ADMINISTRADOR ---
    public function indexAdmin()
    {
        // Recuperamos categorías con el conteo de productos que tienen
        $categories = \App\Models\Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'required|string'
        ]);

        // Crear guardando ambos datos
        \App\Models\Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return back()->with('success', 'Categoría creada correctamente.');
    }

    public function destroy(\App\Models\Category $category)
    {
        if($category->products()->count() > 0){
            return back()->with('error', 'No puedes borrar una categoría que tiene productos asociados.');
        }

        $category->delete();
        return back()->with('success', 'Categoría eliminada.');
    }
}