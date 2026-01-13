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
        $product = Product::find($id);
        
        // Verificación de stock en tiempo real
        if (!isset($this->cart[$id]) || $this->cart[$id]['quantity'] + 1 > $product->stock) {
            session()->flash('error', 'Stock insuficiente para ' . $product->name);
            return;
        }

        $this->cart[$id]['quantity']++;
        $this->updateSession();
    }

    // Decrementar cantidad (-)
    public function decrement($id)
    {
        if (!isset($this->cart[$id])) return;

        if ($this->cart[$id]['quantity'] > 1) {
            $this->cart[$id]['quantity']--;
        } else {
            unset($this->cart[$id]); // Eliminar si baja de 1
        }
        $this->updateSession();
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
        $this->calculateTotal();
    }
}