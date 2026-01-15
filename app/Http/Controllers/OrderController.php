<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Importamos el modelo Order
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // 1. Obtenemos el ID del usuario conectado
        $userId = Auth::id();

        // 2. Buscamos sus pedidos (ordenados del más nuevo al más viejo)
        $orders = Order::where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->get();

        // 3. Devolvemos la vista con los datos
        return view('orders.index', compact('orders'));
    }
}