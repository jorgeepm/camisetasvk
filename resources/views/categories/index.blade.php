<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Categorías de Camisetas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                @foreach ($categories as $category)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                            {{ $category->name }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                            {{ $category->description }}
                        </p>
                        
                        <a href="{{ route('categories.show', $category) }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-500">
                            Ver Camisetas
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>