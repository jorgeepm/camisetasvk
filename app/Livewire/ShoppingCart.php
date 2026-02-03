<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ShoppingCart extends Component
{
    public $cart = [];
    public $total = 0;

    protected $listeners = ['cartUpdated' => 'mount'];

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
    public function increment($key)
    {
        // 1. Extraemos el ID real del producto (base de datos)
        $productId = $this->cart[$key]['id'] ?? null;
        $product = Product::find($productId);

        if (!$product) {
            session()->flash('error', 'Producto no encontrado.');
            return;
        }

        // Sumamos cuántas unidades de este ID hay en TOTAL en el carrito (sumando todas las tallas)
        $quantityInCart = 0;
        foreach ($this->cart as $item) {
            if ($item['id'] == $productId) {
                $quantityInCart += $item['quantity'];
            }
        }

        // Si lo que ya hay en el carrito + 1 supera el stock real
        if ($quantityInCart + 1 > $product->stock) {
            session()->flash('error', 'Stock insuficiente. Solo quedan ' . $product->stock . ' unidades.');
            return; // Detenemos la función aquí
        }

        // 3. Actualizamos cantidad y sesión
        $this->cart[$key]['quantity']++;
        $this->updateSession();
    }

    // Decrementar cantidad (-)
    public function decrement($key)
    {
        if (isset($this->cart[$key])) {
            if ($this->cart[$key]['quantity'] > 1) {
                $this->cart[$key]['quantity']--;
            } else {
                unset($this->cart[$key]);
            }
            $this->updateSession();
        }
    }

    // Eliminar producto
    public function remove($key)
    {
        if (isset($this->cart[$key])) {
            unset($this->cart[$key]);
            $this->updateSession();
            session()->flash('success', 'Producto eliminado.');
        }
    }

    // Guardar estado en sesión
    private function updateSession()
    {
        session()->put('cart', $this->cart);
        // Recalculamos el total
        $this->calculateTotal();
        // Emitimos evento por si hay contadores en el menú
        $this->dispatch('cartUpdated');
    }
    
    public function clearCart()
    {
        // 1. Borrar de la sesión
        session()->forget('cart');
        
        // 2. Actualizar la variable pública para que la vista se limpie
        $this->cart = [];
        $this->total = 0;
        
        // 3. Emitir evento
        $this->dispatch('cartUpdated');
    }
}