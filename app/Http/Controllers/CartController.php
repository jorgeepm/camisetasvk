<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // 1. VER EL CARRITO
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    // 2. AÑADIR PRODUCTO SIMPLE (Desde catálogo)
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // --- VALIDACIÓN DE STOCK REAL (CORREGIDA) ---
        // Contamos cuántas unidades de ESTE producto (ID) hay ya en el carrito,
        // sumando todas las variantes (tallas, nombres, etc.)
        $quantityInCart = 0;
        foreach ($cart as $item) {
            if ($item['id'] == $id) {
                $quantityInCart += $item['quantity'];
            }
        }

        // Si lo que ya tengo + 1 supera el stock real, error.
        if (($quantityInCart + 1) > $product->stock) {
            return redirect()->back()->with('error', 'No hay stock suficiente. Ya tienes ' . $quantityInCart . ' en el carrito y solo quedan ' . $product->stock . '.');
        }
        // ---------------------------------------------

        $cartKey = $id; // Clave simple para productos sin personalizar

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
        } else {
            $cart[$cartKey] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                // ARREGLO IMAGEN: Guardamos una sola clave 'image' válida
                "image" => $product->image_blob ? $product->image_blob : asset('storage/' . $product->image_path),
                "size" => "Estándar",
                "custom_name" => null,
                "custom_number" => null
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Producto añadido al carrito.');
    }

    // 3. AÑADIR PRODUCTO PERSONALIZADO (Desde detalles)
    public function addToCartCustomized(Request $request, $id)
    {
        $request->validate([
            'size' => 'required|string',
            'custom_name' => 'nullable|string|max:15',
            'custom_number' => 'nullable|integer|min:0|max:99'
        ]);

        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // --- VALIDACIÓN DE STOCK REAL (CORREGIDA) ---
        $quantityInCart = 0;
        foreach ($cart as $item) {
            if ($item['id'] == $id) {
                $quantityInCart += $item['quantity'];
            }
        }

        if (($quantityInCart + 1) > $product->stock) {
            return redirect()->back()->with('error', 'Stock insuficiente. Ya tienes el máximo disponible en tu carrito.');
        }
        // ---------------------------------------------

        // Clave única para diferenciar tallas y personalizaciones
        $size = $request->size;
        $cName = $request->custom_name;
        $cNum = $request->custom_number;
        $cartKey = $id . '_' . $size . '_' . preg_replace('/\s+/', '', $cName) . '_' . $cNum;

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
        } else {
            $cart[$cartKey] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                // ARREGLO IMAGEN
                "image" => $product->image_blob ? $product->image_blob : asset('storage/' . $product->image_path),
                "size" => $size,
                "custom_name" => $cName,
                "custom_number" => $cNum
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Camiseta personalizada añadida.');
    }

    // 4. AUMENTAR CANTIDAD (+)
    public function increaseQuantity($key)
    {
        $cart = session()->get('cart');

        if(isset($cart[$key])) {
            $productId = $cart[$key]['id'];
            $product = Product::findOrFail($productId);

            // Validar Stock Global antes de sumar
            $quantityInCart = 0;
            foreach ($cart as $item) {
                if ($item['id'] == $productId) {
                    $quantityInCart += $item['quantity'];
                }
            }

            if (($quantityInCart + 1) > $product->stock) {
                return redirect()->back()->with('error', 'No puedes añadir más, has alcanzado el límite de stock.');
            }

            $cart[$key]['quantity']++;
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // 5. DISMINUIR CANTIDAD (-)
    public function decreaseQuantity($key)
    {
        $cart = session()->get('cart');

        if(isset($cart[$key])) {
            if($cart[$key]['quantity'] > 1) {
                $cart[$key]['quantity']--;
                session()->put('cart', $cart);
            } else {
                unset($cart[$key]);
                session()->put('cart', $cart);
            }
        }

        return redirect()->back();
    }

    // 6. ELIMINAR
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Producto eliminado.');
        }
    }
}