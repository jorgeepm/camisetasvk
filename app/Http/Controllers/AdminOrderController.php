<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order; // <--- Asegúrate de que tu compañero llamó al modelo 'Order'
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        // Traemos los pedidos ordenados del más nuevo al más viejo
        // Usamos 'with' para que la carga sea rápida y traiga datos del usuario
        $orders = Order::with('user')->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    // Mostrar el detalle de un pedido
    public function show(Order $order)
    {
        // Cargamos los productos asociados al pedido (asumiendo que la relación se llama 'items' o 'products')
        // IMPORTANTE: Si tu relación en el modelo Order se llama 'products', cambia 'items' por 'products' aquí abajo.
        $order->load('user', 'items.product'); 
        
        return view('admin.orders.show', compact('order'));
    }

    // Cambiar el estado del pedido
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Estado del pedido actualizado correctamente.');
    }
}