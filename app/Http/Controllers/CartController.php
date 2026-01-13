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

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_path
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', '¡Camiseta añadida al carrito!');
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
}