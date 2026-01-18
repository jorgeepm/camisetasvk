<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar: ') }} <span class="text-indigo-600 dark:text-indigo-400">{{ $product->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Errores --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm dark:bg-red-900/50 dark:text-red-200 dark:border-red-600">
                    <p class="font-bold">Por favor corrige los siguientes errores:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 border border-gray-200 dark:border-gray-700">
                
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- NOMBRE --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nombre:</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition" required>
                    </div>

                    {{-- CATEGORÍA --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Categoría:</label>
                        <select name="category_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- GRID PRECIO Y STOCK --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Precio (€):</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Stock:</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition" required>
                        </div>
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Descripción:</label>
                        <textarea name="description" rows="4" 
                                  class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition" required>{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- IMAGEN ACTUAL Y NUEVA --}}
                    <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center gap-6">
                            
                            {{-- 🖼️ ZONA DE IMAGEN ARREGLADA (Híbrida) --}}
                            <div class="text-center">
                                <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold mb-2">Imagen Actual:</label>
                                
                                @if($product->image_blob)
                                    {{-- 1. Nueva (Blob en BD) --}}
                                    <img src="{{ $product->image_blob }}" class="h-24 w-auto rounded border shadow-md" alt="Actual">
                                @elseif($product->image_path)
                                    {{-- 2. Antigua (Storage) --}}
                                    <img src="{{ asset('storage/' . $product->image_path) }}" class="h-24 w-auto rounded border shadow-md" alt="Actual">
                                @else
                                    {{-- 3. Sin imagen --}}
                                    <div class="h-24 w-24 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center text-xs text-gray-500 border border-gray-300 dark:border-gray-500">
                                        Sin Imagen
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Cambiar Imagen (Opcional):</label>
                                <input type="file" name="image" class="block w-full text-sm text-gray-500 dark:text-gray-400
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300
                                " accept="image/*">
                            </div>
                        </div>
                    </div>

                    {{-- BOTONES --}}
                    <div class="flex justify-end items-center gap-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                        <a href="{{ route('products.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 font-medium transition">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow-lg transition transform hover:-translate-y-0.5">
                            Actualizar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>