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

    // 2. Añadir producto al carrito
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
                "image_path" => $product->image_path
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

    public function decreaseQuantity($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            // Si hay más de 1, restamos
            if($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Cantidad actualizada.');
            } else {
                // Si solo queda 1 y le damos a restar, lo borramos del todo
                unset($cart[$id]);
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Producto eliminado.');
            }
        }
        return redirect()->back();
    }
}