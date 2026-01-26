<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Panel de Administración: Productos') }}
            </h2>
            {{-- Botón Nuevo Producto --}}
            <a href="{{ route('products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow-lg transition duration-150 ease-in-out flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Producto
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/50 dark:text-green-300 dark:border-green-600 p-4 mb-4 rounded relative shadow-sm" role="alert">
                    <span class="block sm:inline font-bold">{{ session('success') }}</span>
                </div>
            @endif

            {{-- 🔍 BARRA DE FILTROS ADMIN --}}
            <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                    
                    {{-- Buscador --}}
                    <div class="w-full md:w-1/3">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Buscar por nombre</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ej: Real Madrid..." 
                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                    </div>

                    {{-- Selector Categoría --}}
                    <div class="w-full md:w-1/4">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Filtrar Categoría</label>
                        <select name="category_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                            <option value="">Todas las categorías</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Botones --}}
                    <div class="flex gap-2">
                        <button type="submit" class="bg-gray-800 dark:bg-indigo-600 hover:bg-gray-700 text-white px-5 py-2 rounded-md text-sm font-bold transition shadow-md">
                            Filtrar
                        </button>
                        
                        @if(request('search') || request('category_id'))
                            <a href="{{ route('products.index') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-md text-sm font-bold transition">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- TABLA DE RESULTADOS --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Imagen</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Precio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Categoría</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($products as $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                    {{-- IMAGEN --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-12 w-12 rounded bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-600">
                                            @if($product->image_blob)
                                                <img src="{{ $product->image_blob }}" alt="img" class="h-full w-full object-contain">
                                            @elseif($product->image_path)
                                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="img" class="h-full w-full object-contain">
                                            @else
                                                <span class="text-[10px] text-gray-400">Sin foto</span>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    {{-- NOMBRE --}}
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $product->name }}</td>
                                    
                                    {{-- PRECIO --}}
                                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($product->price, 2) }} €</td>
                                    
                                    {{-- STOCK --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock < 5 ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                            {{ $product->stock }} u.
                                        </span>
                                    </td>
                                    
                                    {{-- CATEGORÍA --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $product->category->name ?? 'Sin categoría' }}
                                    </td>
                                    
                                    {{-- ACCIONES --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center items-center gap-3">
                                            <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-bold">
                                                ✏️ Editar
                                            </a>
                                            
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro que quieres borrar este producto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-bold cursor-pointer">
                                                    🗑️ Borrar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                        No se encontraron camisetas con esos filtros.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Paginación --}}
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>