<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. MOSTRAR LISTADO (READ)
    public function index()
    {
        // Traemos productos con su categoría (Relación 1:N) y paginamos
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // 2. MOSTRAR FORMULARIO DE CREAR
    public function create()
    {
        // Necesitamos las categorías para el desplegable del formulario
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // 3. GUARDAR PRODUCTO NUEVO (CREATE)
    public function store(Request $request)
    {
        // Validación de datos (Requisito del PDF)
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0', // Evitamos precios negativos
            'stock' => 'required|integer|min:0', // Evitamos stock negativo
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Validación de imagen
        ]);

        // Subida de imagen a storage/app/public/products
        // Esto cumple el requisito de que el valor apunte a storage/app/public
        $imagePath = $request->file('image')->store('products', 'public');

        // Crear el producto en la BD
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image_path' => $imagePath,
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
        // Validación (Nota: la imagen aquí es 'nullable' porque al editar es opcional)
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Preparamos los datos básicos (excluyendo la imagen por ahora)
        $data = $request->except('image');

        // Lógica de Imagen: Si suben una nueva, borramos la vieja
        if ($request->hasFile('image')) {
            // Borrar imagen antigua del disco si existe
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            // Guardar la nueva y actualizar la ruta en el array de datos
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        // Actualizar en BD
        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Producto actualizado.');
    }

    // 6. BORRAR PRODUCTO (DELETE)
    public function destroy(Product $product)
    {
        // Borramos la imagen del disco para no dejar basura
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }
        
        $product->delete(); // Borramos el registro de la BD
        
        return redirect()->route('products.index')->with('success', 'Producto eliminado.');
    }
}