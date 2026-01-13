<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <div class="text-center mb-8">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                        <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">¡Gracias por tu compra!</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Tu pedido ha sido recibido correctamente.</p>
                    <p class="text-sm text-gray-500 mt-1">Nº de Pedido: #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>

                <hr class="border-gray-200 dark:border-gray-700 mb-8">

                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Resumen del Pedido</h3>
                
                <div class="flow-root">
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($order->items as $item)
                        <li class="py-4 flex">
                            <div class="flex-shrink-0 h-16 w-16 border border-gray-200 rounded-md overflow-hidden">
                                <img src="{{ asset('storage/' . $item->product->image_path) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="h-full w-full object-cover object-center">
                            </div>

                            <div class="ml-4 flex-1 flex flex-col">
                                <div>
                                    <div class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                                        <h3>{{ $item->product->name }}</h3>
                                        <p class="ml-4">{{ $item->price }} €</p>
                                    </div>
                                </div>
                                <div class="flex-1 flex items-end justify-between text-sm">
                                    <p class="text-gray-500 dark:text-gray-400">Cantidad: {{ $item->quantity }}</p>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 mt-6 pt-6">
                    <div class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                        <p>Total Pagado</p>
                        <p class="text-2xl font-bold">{{ $order->total }} €</p>
                    </div>
                    <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Impuestos incluidos.</p>
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('categories.index') }}" class="inline-block bg-indigo-600 border border-transparent rounded-md py-3 px-8 text-base font-medium text-white hover:bg-indigo-700">
                        Seguir Comprando ⚽
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>