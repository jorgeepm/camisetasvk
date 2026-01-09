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
        return view('categories.show', [
            'category' => $category,
            'products' => $category->products 
        ]);
    }
}