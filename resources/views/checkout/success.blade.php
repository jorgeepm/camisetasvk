<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <div class="text-center mb-8">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                        <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">¡Gracias por tu compra!</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Tu pedido ha sido recibido correctamente.</p>
                    <p class="text-sm text-gray-500 mt-1 uppercase tracking-widest font-bold">Nº de Pedido: #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>

                <hr class="border-gray-200 dark:border-gray-700 mb-8">

                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 italic">Resumen de Fabricación</h3>
                
                <div class="flow-root">
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($order->items as $item)
                        <li class="py-4 flex">
                            <div class="flex-shrink-0 h-20 w-20 border border-gray-200 rounded-md overflow-hidden bg-gray-50">
                                <img src="{{ asset('storage/' . $item->product->image_path) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="h-full w-full object-contain">
                            </div>

                            <div class="ml-4 flex-1 flex flex-col">
                                <div>
                                    <div class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                                        <h3 class="font-bold uppercase">{{ $item->product->name }}</h3>
                                        <p class="ml-4">{{ number_format($item->price, 2) }} €</p>
                                    </div>
                                    
                                    {{-- BLOQUE DE PERSONALIZACIÓN AÑADIDO --}}
                                    <div class="mt-1 bg-indigo-50 dark:bg-indigo-900/20 p-2 rounded-md border border-indigo-100 dark:border-indigo-800/30">
                                        <p class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase">Detalles del diseño:</p>
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            <span>Talla: <b>{{ $item->size ?? 'N/A' }}</b></span>
                                            @if($item->custom_name)
                                                <span class="mx-2">|</span> <span>Nombre: <b class="uppercase">{{ $item->custom_name }}</b></span>
                                            @endif
                                            @if($item->custom_number)
                                                <span class="mx-2">|</span> <span>Número: <b>{{ $item->custom_number }}</b></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-1 flex items-end justify-between text-sm mt-2">
                                    <p class="text-gray-500 dark:text-gray-400 font-medium tracking-wide">CANTIDAD: {{ $item->quantity }}</p>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 mt-6 pt-6">
                    <div class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                        <p class="text-lg">Total Pagado</p>
                        <p class="text-3xl font-black text-[#0004ff] dark:text-indigo-600">{{ number_format($order->total, 2) }} €</p>
                    </div>
                </div>

                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('orders.index') }}" class="inline-block bg-gray-800 dark:bg-gray-700 border border-transparent rounded-xl py-3 px-8 text-base font-bold text-white hover:bg-gray-900 transition shadow-lg">
                        Ver Mis Pedidos 📦
                    </a>
                    <a href="{{ route('home') }}" class="inline-block bg-[#0004ff] dark:bg-indigo-600 border border-transparent rounded-xl py-3 px-8 text-base font-bold text-white hover:bg-[#0258f7] dark:hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
                        Seguir Comprando 🛒
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>