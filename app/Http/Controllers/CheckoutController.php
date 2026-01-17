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
        // 1. Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para realizar el pedido.');
        }

        $cart = session()->get('cart', []);
        
        if(count($cart) < 1) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
        }

        // --- BLOQUE DE SEGURIDAD AÑADIDO ---s
        // Verificamos cada item del carrito antes de tocar la base de datos
        foreach($cart as $item) {
            // Validar largo del nombre (Máx 15)
            if (isset($item['custom_name']) && strlen($item['custom_name']) > 15) {
                return redirect()->route('cart.index')->with('error', 'Seguridad: Se detectó un nombre demasiado largo en el carrito.');
            }
            // Validar rango del número (1-99)
            if (isset($item['custom_number']) && ($item['custom_number'] < 1 || $item['custom_number'] > 99)) {
                return redirect()->route('cart.index')->with('error', 'Seguridad: Se detectó un dorsal inválido.');
            }
            // Validar que el nombre solo tenga letras (opcional pero recomendado)
            if (isset($item['custom_name']) && !preg_match('/^[a-zA-Z\s]*$/', $item['custom_name'])) {
                return redirect()->route('cart.index')->with('error', 'Seguridad: El nombre solo puede contener letras.');
            }
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
                'status' => 'paid',
                'created_at' => now(),
            ]);

            foreach($cart as $id => $details) {
                // Obtenemos el ID numérico real del producto
                $realProductId = $details['id'] ?? $id;

                // Guardar línea de pedido con personalización blindada
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $realProductId,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                    'size' => $details['size'] ?? null,
                    'custom_name' => $details['custom_name'] ?? null,
                    'custom_number' => $details['custom_number'] ?? null,
                ]);

                // Actualizar stock
                $product = Product::find($realProductId);
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

    public function index()
    {
        // Recuperamos el carrito de la sesión
        $cart = session()->get('cart', []);
        
        // Si el carrito está vacío, lo mandamos fuera
        if(count($cart) < 1) {
            return redirect()->route('home');
        }

        // Calculamos el total para mostrarlo
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'total'));
    }
}