<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ShoppingCart extends Component
{
    public $cart = [];
    public $total = 0;

    // Se ejecuta al cargar el componente
    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $this->calculateTotal();
    }

    public function render()
    {
        return view('livewire.shopping-cart');
    }

    // Calcular el total del carrito
    public function calculateTotal()
    {
        $this->total = 0;
        foreach($this->cart as $item) {
            $this->total += $item['price'] * $item['quantity'];
        }
    }

    // Incrementar cantidad (+)
    public function increment($id)
    {
        // 1. Extraemos el ID real del producto guardado en los detalles
        $productId = $this->cart[$id]['id'] ?? null;
        $product = Product::find($productId);

        if (!$product) {
            session()->flash('error', 'Producto no encontrado.');
            return;
        }

        // 2. Verificación de stock en tiempo real
        if ($this->cart[$id]['quantity'] + 1 > $product->stock) {
            session()->flash('error', 'Stock insuficiente para ' . $product->name);
            return;
        }

        // 3. Actualizamos cantidad y sesión
        $this->cart[$id]['quantity']++;
        $this->updateSession();
    }
    // Decrementar cantidad (-)
    public function decrement($id)
    {
        if (isset($this->cart[$id])) {
            if ($this->cart[$id]['quantity'] > 1) {
                $this->cart[$id]['quantity']--;
            } else {
                unset($this->cart[$id]);
            }
            $this->updateSession();
        }
    }

    // Eliminar producto 🗑️
    public function remove($id)
    {
        unset($this->cart[$id]);
        $this->updateSession();
    }

    // Guardar estado en sesión
    private function updateSession()
    {
        session()->put('cart', $this->cart);
        // Recalculamos el total si es necesario para la vista
        $this->total = collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }
}