<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col md:flex-row gap-8">
        
        <aside class="w-full md:w-1/4">
            <div class="bg-[#1e293b] p-6 rounded-2xl shadow-lg border border-gray-700 sticky top-24">
                <h2 class="text-white font-bold text-xl mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filtros
                </h2>

                <div class="mb-6">
                    <label class="text-gray-400 text-xs uppercase font-bold mb-2 block">Ordenar por</label>
                    <select wire:model.live="sortOrder" wire:key="sort-{{ $filterKey }}"
                        class="w-full bg-[#0f172a] border-gray-700 text-white rounded-lg focus:ring-indigo-500">
                        <option value="desc">Precio: Mayor a Menor</option>
                        <option value="asc">Precio: Menor a Mayor</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="text-gray-400 text-xs uppercase font-bold mb-2 block">Nombre</label>
                    <input type="text" 
                        wire:model.live="search" 
                        wire:key="search-{{ $filterKey }}"
                        class="w-full bg-[#0f172a] border-gray-700 text-white rounded-lg focus:ring-indigo-500" 
                        placeholder="Buscar...">
                </div>

                <div class="mb-6">
                    <label class="text-gray-400 text-xs uppercase font-bold mb-2 block">Categoría</label>
                    <select wire:model.live="categoryId" wire:key="cat-{{ $filterKey }}" 
                        class="w-full bg-[#0f172a] border-gray-700 text-white rounded-lg focus:ring-indigo-500">
                        <option value="">Todas</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="text-gray-400 text-xs uppercase font-bold mb-3 block">Precio (€)</label>
                    <div class="flex items-center gap-2">
                        <input type="number" 
                            wire:model.live="minPrice" 
                            wire:key="min-{{ $filterKey }}"
                            placeholder="Mín"
                            class="w-1/2 bg-[#0f172a] border-gray-700 text-white rounded-lg text-sm focus:ring-indigo-500">
                        <span class="text-gray-500">-</span>
                        <input type="number" 
                            wire:model.live="maxPrice" 
                            wire:key="max-{{ $filterKey }}"
                            placeholder="Máx"
                            class="w-1/2 bg-[#0f172a] border-gray-700 text-white rounded-lg text-sm focus:ring-indigo-500">
                    </div>
                </div>

                <button type="button" wire:click="clearFilters" 
                    class="w-full py-2 mt-4 text-xs text-gray-400 hover:text-white transition-colors border border-gray-700 rounded-lg hover:bg-gray-800 flex justify-center items-center gap-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Limpiar filtros
                </button>
            </div>
        </aside>

        <main class="w-full md:w-3/4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="bg-[#1e293b] rounded-2xl overflow-hidden border border-gray-700 shadow-xl flex flex-col group transition-all hover:border-indigo-500">
                        <div class="p-6 bg-white flex justify-center relative overflow-hidden">
                            <img src="{{ asset('storage/' . $product->image_path) }}" 
                                class="h-48 object-contain transition-transform group-hover:scale-110 duration-300">
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between text-white">
                            <div>
                                <h3 class="font-bold text-lg leading-tight h-14 overflow-hidden">{{ $product->name }}</h3>
                                <p class="text-indigo-400 text-xs font-bold uppercase mt-2">{{ $product->category->name ?? 'Fútbol' }}</p>
                            </div>
                            <div class="flex justify-between items-center mt-6">
                                <span class="text-2xl font-black">{{ number_format($product->price, 2) }}€</span>
                                <a href="{{ url('/shirts/' . $product->id) }}" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition-colors text-center">
                                    Personalizar
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center text-gray-500 border-2 border-dashed border-gray-700 rounded-2xl">
                        No se encontraron resultados.
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        </main>
    </div>
</div>