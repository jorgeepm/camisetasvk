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
    // 3. GUARDAR NUEVO PRODUCTO (STORE)
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Input 'image' requerido
        ]);

        // 1. Convertir imagen a Base64 para guardar en BD (BLOB)
        $imageBlob = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->getRealPath();
            $data = file_get_contents($path);
            $base64 = base64_encode($data);
            $mime = $request->file('image')->getMimeType();
            $imageBlob = "data:$mime;base64,$base64";
        }

        // 2. Crear producto
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image_blob' => $imageBlob, // <--- GUARDAMOS EL BLOB (Base64)
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
        // Validación (Imagen opcional 'nullable')
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // 1. Recogemos los datos (quitamos 'image' para no confundir a la BD, y token/method por limpieza)
        $data = $request->except(['image', '_token', '_method']);

        // 2. Lógica de Imagen: Si suben una nueva...
        if ($request->hasFile('image')) {
            // Convertimos a Base64
            $path = $request->file('image')->getRealPath();
            $data = file_get_contents($path);
            $base64 = base64_encode($data);
            $mime = $request->file('image')->getMimeType();

            // Guardamos en el array de datos
            $data['image_blob'] = "data:$mime;base64,$base64";
        }

        // 3. Actualizar en BD (Laravel ignorará lo que no esté en $fillable, pero así vamos seguros)
        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Producto actualizado.');
    }

    // 6. BORRAR PRODUCTO (DELETE)
    public function destroy(Product $product)
    {
        // No necesitamos borrar archivo de disco, ya que está en BD

        $product->delete(); // Borramos el registro de la BD

        return redirect()->route('products.index')->with('success', 'Producto eliminado.');
    }

    // ==========================================
    // NUEVO: MOSTRAR PRODUCTO PARA EL CLIENTE (PERSONALIZADOR)
    // ==========================================
    public function show(Product $product)
    {
        // Retorna la vista pública donde el usuario elige nombre y número
        return view('products.show', compact('product'));
    }
}