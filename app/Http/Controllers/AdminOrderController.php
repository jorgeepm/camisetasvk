<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order; // ✅ Importamos Order, no Product
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        // Traemos los pedidos ordenados del más nuevo al más viejo
        $orders = Order::with('user')->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    // Mostrar el detalle de un pedido
    public function show(Order $order)
    {
        // Cargamos los productos asociados al pedido
        // Asegúrate de que en tu modelo Order la relación se llame 'items' (o 'products')
        $order->load('user', 'items.product'); 
        
        return view('admin.orders.show', compact('order'));
    }

    // --- MÉTODO UPDATE CORREGIDO ---
    // Antes tenías aquí "Product $product", eso era lo que rompía la web.
    public function update(Request $request, Order $order)
    {
        // 1. Validamos usando las palabras EN INGLÉS que tienes en tu HTML
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
        ]);

        // 2. Actualizamos el estado
        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Estado del pedido actualizado correctamente.');
    }
}