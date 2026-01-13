<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // 1. PROCESAR EL PEDIDO (POST)
    public function store()
    {
        // A. Verificamos usuario
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para comprar.');
        }

        // B. Recuperamos carrito
        $cart = session()->get('cart', []);
        
        if(count($cart) < 1) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
        }

        // C. Calculamos total
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // --- INICIO DE TRANSACCIÓN ---
        DB::beginTransaction();

        try {
            // D. Creamos el Pedido (AQUÍ nace la variable $order)
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'completed',
                'created_at' => now(),
            ]);

            // E. Guardamos los items
            foreach($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);

                // Restar stock
                $product = Product::find($id);
                if($product) {
                    $product->decrement('stock', $details['quantity']);
                }
            }

            // F. Confirmamos todo
            DB::commit();
            session()->forget('cart');

            // G. REDIRIGIMOS AL TICKET (Ahora $order sí existe)
            return redirect()->route('checkout.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // 2. MOSTRAR EL TICKET (GET)
    public function success(Order $order)
    {
        // Seguridad: Solo el dueño del pedido puede verlo
        if (Auth::id() !== $order->user_id) {
            abort(403, 'No tienes permiso para ver este pedido.');
        }

        $order->load('items.product');

        return view('checkout.success', compact('order'));
    }
}