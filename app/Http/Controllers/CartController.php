<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 1. Mostrar la pantalla del carrito
    public function index()
    {
        // Recuperamos el carrito de la sesión
        $cart = session()->get('cart', []);

        // Calculamos el total
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    // 2. Añadir producto al carrito (Simple)
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Verificar stock disponible
        $currentQuantity = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;

        if ($currentQuantity + 1 > $product->stock) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible.');
        }

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image_path" => $product->image_path,
                "image_blob" => $product->image_blob // <--- ¡AQUI ESTABA EL FALLO! Agregado.
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Producto añadido al carrito.');
    }

    // 3. Borrar producto del carrito
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
        return redirect()->back()->with('success', 'Producto eliminado');
    }

    public function increaseQuantity($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    public function decreaseQuantity($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            if($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                // Si es 1 y pulsa menos, lo quitamos
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // ==========================================
    // AÑADIR PRODUCTO PERSONALIZADO (El que usas desde el detalle)
    // ==========================================
    public function addToCartCustomized(Request $request, $id)
    {
        // 1. Verificación de seguridad
        $request->validate([
            'custom_name'   => 'nullable|string|max:15|regex:/^[a-zA-Z\s]+$/', 
            'custom_number' => 'nullable|integer|between:1,99',             
            'size'          => 'required|string|in:S,M,L,XL',                 
        ], [
            'custom_name.max'       => 'El nombre no puede tener más de 15 letras.',
            'custom_name.regex'     => 'El nombre solo puede contener letras.',
            'custom_number.between' => 'El dorsal debe ser un número entre 1 y 99.',
        ]);

        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Creamos una clave única
        $cartKey = $id . '_' . $request->custom_name . '_' . $request->custom_number . '_' . $request->size;

        $cart[$cartKey] = [
            "id" => $product->id,
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image_path" => $product->image_path,
            "image_blob" => $product->image_blob, // <--- ¡AQUI TAMBIÉN FALTABA! Agregado.
            
            // Datos de personalización
            "size" => $request->size,
            "custom_name" => $request->custom_name,
            "custom_number" => $request->custom_number
        ];

        session()->put('cart', $cart);
        
        // Redirigimos al carrito para ver el resultado (Más profesional que recargar)
        return redirect()->route('cart.index')->with('success', 'Producto personalizado añadido al carrito.');
    }
}