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
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // (Opcional) Aquí podrías borrar la imagen antigua si quisieras limpiar
            
            // Guardamos la nueva
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        } else {
            // Si no suben foto nueva, quitamos 'image' de $data para no borrar la que ya tenía
            unset($data['image']);
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Producto actualizado.');
    }
}