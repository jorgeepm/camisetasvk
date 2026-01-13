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
    public function store()
    {
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para realizar el pedido.');
        }

        $cart = session()->get('cart', []);
        
        if(count($cart) < 1) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
        }

        // Calcular total del pedido
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Iniciar transacción para asegurar integridad de datos
        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'completed',
                'created_at' => now(),
            ]);

            foreach($cart as $id => $details) {
                // Guardar línea de pedido
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);

                // Actualizar stock del producto
                $product = Product::find($id);
                if($product) {
                    $product->decrement('stock', $details['quantity']);
                }
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('checkout.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar el pedido: ' . $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        // Comprobar que el pedido pertenece al usuario
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        $order->load('items.product');

        return view('checkout.success', compact('order'));
    }
}