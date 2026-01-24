<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Finalizar Compra') }} 💳
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- FORMULARIO DE PAGO --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Datos de Envío y Pago</h3>
                    
                    <form action="{{ route('checkout.store') }}" method="POST" id="payment-form">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Dirección de Entrega</label>
                            <input type="text" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Calle Falsa 123, Madrid">
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Ciudad</label>
                                <input type="text" required class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Madrid">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Código Postal</label>
                                <input type="text" required class="w-full border-gray-300 rounded-md shadow-sm" placeholder="28080">
                            </div>
                        </div>

                        <hr class="my-6 border-gray-200">

                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Número de Tarjeta (Simulado)</label>
                            <div class="relative">
                                <input type="text" placeholder="4242 4242 4242 4242" class="w-full pl-10 border-gray-300 rounded-md shadow-sm">
                                <span class="absolute left-3 top-2 text-gray-400">💳</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">🔒 Pago seguro SSL (Simulación Académica)</p>
                        </div>

                        <button type="submit" class="w-full bg-[#0004ff] dark:bg-indigo-700 text-white font-bold py-3 px-4 rounded hover:bg-[#0258f7] dark:hover:bg-indigo-500 transition duration-150 ease-in-out mt-4">
                            Pagar {{ number_format($total, 2) }} € Ahora
                        </button>
                    </form>
                </div>

                {{-- RESUMEN DEL PEDIDO --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-lg h-fit">
                    <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Resumen del Pedido</h3>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach($cart as $item)
                        <li class="py-4 flex justify-between">
                            <div class="flex items-center">
                                
                                {{-- 🖼️ IMAGEN HÍBRIDA (Checkout) --}}
                                @if(isset($item['image_blob']) && $item['image_blob'])
                                    {{-- 1. Nueva (Blob) --}}
                                    <img src="{{ $item['image_blob'] }}" alt="img" class="h-10 w-10 rounded object-cover mr-3 border border-gray-300 dark:border-gray-500">
                                
                                @elseif(isset($item['image_path']) && $item['image_path'])
                                    {{-- 2. Antigua (Storage) --}}
                                    <img src="{{ asset('storage/' . $item['image_path']) }}" alt="img" class="h-10 w-10 rounded object-cover mr-3 border border-gray-300 dark:border-gray-500">
                                
                                @else
                                    {{-- 3. Placeholder --}}
                                    <div class="h-10 w-10 rounded bg-gray-200 mr-3 flex items-center justify-center text-xs text-gray-500 border border-gray-300">Sin foto</div>
                                @endif

                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $item['name'] }}</p>
                                    <p class="text-xs text-gray-500">Cant: {{ $item['quantity'] }} | Talla: {{ $item['size'] ?? 'S' }}</p>
                                </div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ number_format($item['price'] * $item['quantity'], 2) }} €
                            </span>
                        </li>
                        @endforeach
                    </ul>
                    <div class="border-t border-gray-200 dark:border-gray-600 mt-4 pt-4 flex justify-between">
                        <span class="text-base font-bold text-gray-900 dark:text-white">Total a Pagar</span>
                        <span class="text-xl font-bold text-[#0004ff] dark:text-indigo-500">{{ number_format($total, 2) }} €</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>