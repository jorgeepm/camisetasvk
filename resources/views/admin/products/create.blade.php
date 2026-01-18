<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nuevo Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Mostrar errores de validación si los hay --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm dark:bg-red-900/50 dark:text-red-200 dark:border-red-600">
                    <p class="font-bold">¡Ups! Algo salió mal:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 border border-gray-200 dark:border-gray-700">
                
                {{-- FORMULARIO --}}
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- NOMBRE --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nombre:</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition" required>
                    </div>

                    {{-- CATEGORÍA --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Categoría:</label>
                        <select name="category_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- GRID PRECIO Y STOCK --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Precio (€):</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price') }}" 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Stock:</label>
                            <input type="number" name="stock" value="{{ old('stock') }}" 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition" required>
                        </div>
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Descripción:</label>
                        <textarea name="description" rows="4" 
                                  class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition" required>{{ old('description') }}</textarea>
                    </div>

                    {{-- IMAGEN (Input para subir) --}}
                    <div class="mb-8">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Imagen:</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition relative">
                            <div class="space-y-1 text-center">
                                
                                {{-- Previsualización JS --}}
                                <img id="imagePreview" src="#" style="display:none; max-height: 200px;" class="mx-auto rounded border dark:border-gray-500 mb-4 shadow-lg">
                                
                                <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                    <label for="imageInput" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Subir un archivo</span>
                                        <input id="imageInput" name="image" type="file" class="sr-only" accept="image/*" required>
                                    </label>
                                    <p class="pl-1">o arrastrar y soltar</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF hasta 2MB</p>
                            </div>
                        </div>
                    </div>

                    {{-- BOTONES --}}
                    <div class="flex justify-end items-center gap-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                        <a href="{{ route('products.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 font-medium transition">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow-lg transition transform hover:-translate-y-0.5">
                            Guardar Producto
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Script de Previsualización (Client Side) --}}
    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            if (e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('imagePreview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
</x-app-layout>