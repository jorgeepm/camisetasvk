<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 1. MOSTRAR LISTADO CON FILTROS (READ)
    public function index(Request $request)
    {
        // Iniciamos la consulta base
        $query = Product::with('category');

        // A. Filtro por Buscador (Nombre)
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // B. Filtro por Categoría
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // Ejecutamos la consulta con paginación (mantiene los filtros en los enlaces de página)
        $products = $query->paginate(10)->withQueryString();

        // Necesitamos las categorías para el desplegable de filtros
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    // 2. MOSTRAR FORMULARIO DE CREAR
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // 3. GUARDAR PRODUCTO NUEVO (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imageBlob = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->getRealPath();
            $data = file_get_contents($path);
            $base64 = base64_encode($data);
            $mime = $request->file('image')->getMimeType();
            $imageBlob = "data:$mime;base64,$base64";
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image_blob' => $imageBlob,
        ]);

        return redirect()->route('products.index')->with('success', 'Producto creado con éxito.');
    }

    // 4. MOSTRAR FORMULARIO DE EDITAR
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // 5. ACTUALIZAR PRODUCTO (UPDATE)
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except(['image', '_token', '_method']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->getRealPath();
            $fileData = file_get_contents($path);
            $base64 = base64_encode($fileData);
            $mime = $request->file('image')->getMimeType();
            $data['image_blob'] = "data:$mime;base64,$base64";
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Producto actualizado.');
    }

    // 6. BORRAR PRODUCTO (DELETE)
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado.');
    }

    // 7. MOSTRAR DETALLE PÚBLICO
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}