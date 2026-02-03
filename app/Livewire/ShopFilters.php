<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Product;
use App\Models\Category;

class ShopFilters extends Component
{
    use WithPagination;

    // Variables públicas con #[Url] para sincronizar con la barra de direcciones
    #[Url]
    public $search = '';

    #[Url]
    public $categoryId = '';

    #[Url]
    public $minPrice = 0;

    #[Url]
    public $maxPrice = 500;

    #[Url]
    public $sortOrder = 'desc'; // Por defecto de mayor a menor
    
    // Esta variable fuerza el refresco visual de los inputs al limpiar
    public $filterKey = 1;

    // Resetear página cuando cambian los filtros
    public function updatingSearch() { $this->resetPage(); }
    public function updatingCategoryId() { $this->resetPage(); }
    public function updatingMinPrice() { $this->resetPage(); }
    public function updatingMaxPrice() { $this->resetPage(); }
    public function updatingSortOrder() { $this->resetPage(); }

    // Función de limpieza completa
    public function clearFilters()
    {
        $this->reset(['search', 'categoryId', 'minPrice', 'maxPrice', 'sortOrder']);
        $this->resetPage();
        
        // Cambiamos la clave para que el navegador limpie los inputs físicamente
        $this->filterKey++;
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryId, function($query) {
                $query->where('category_id', $this->categoryId);
            })
            ->whereBetween('price', [(float)$this->minPrice, (float)$this->maxPrice])
            ->orderBy('price', $this->sortOrder) // Aplica el orden seleccionado
            ->paginate(12);

        return view('livewire.shop-filters', [
            'products' => $products,
            'categories' => Category::all()
        ])->layout('layouts.app');
    }
}