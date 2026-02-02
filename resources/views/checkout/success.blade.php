<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8 border border-gray-100 dark:border-gray-700">
                
                {{-- ✅ CABECERA DE ÉXITO --}}
                <div class="text-center mb-10">
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 dark:bg-green-900/30 mb-6 animate-bounce">
                        <svg class="h-10 w-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">¡Gracias por tu compra!</h2>
                    <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">Tu pedido ha sido procesado correctamente.</p>
                    <div class="mt-4 inline-block bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-lg">
                        <p class="text-sm text-gray-500 dark:text-gray-300 uppercase tracking-widest font-bold">
                            Nº de Pedido: <span class="text-indigo-600 dark:text-indigo-400">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </p>
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-700 mb-8">

                {{-- 👕 RESUMEN DE ARTÍCULOS --}}
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6 flex items-center">
                    <span class="bg-indigo-600 w-1 h-6 mr-3 rounded-full"></span>
                    Detalles del Pedido
                </h3>
                
                <div class="flow-root mb-8">
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($order->items as $item)
                        <li class="py-6 flex">
                            
                            {{-- 🖼️ IMAGEN DEL PRODUCTO (CORREGIDA E INTELIGENTE) --}}
                            <div class="flex-shrink-0 h-24 w-24 border border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden bg-gray-50 dark:bg-gray-700 p-2">
                                @php
                                    // 1. Buscamos la imagen en el producto
                                    $imgData = $item->product->image ?? $item->product->image_blob ?? null;
                                @endphp

                                @if($imgData)
                                    {{-- CASO A: Es un BLOB (data:...) -> Se muestra directo --}}
                                    @if(str_starts_with($imgData, 'data:'))
                                        <img src="{{ $imgData }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="h-full w-full object-contain mix-blend-multiply dark:mix-blend-normal">
                                    
                                    {{-- CASO B: Es una ruta normal -> Se añade 'storage/' --}}
                                    @else
                                        <img src="{{ asset('storage/' . $imgData) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="h-full w-full object-contain mix-blend-multiply dark:mix-blend-normal">
                                    @endif
                                @else
                                    {{-- CASO C: No hay imagen --}}
                                    <div class="h-full w-full flex items-center justify-center text-xs text-gray-400 font-medium">
                                        Sin foto
                                    </div>
                                @endif
                            </div>

                            <div class="ml-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                                        <h3 class="font-bold text-lg leading-tight">{{ $item->product->name }}</h3>
                                        <p class="ml-4 font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($item->price, 2) }} €</p>
                                    </div>
                                    
                                    {{-- 🎨 DETALLES --}}
                                    <div class="mt-3 space-y-1">
                                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <span class="font-medium mr-2">Talla:</span> 
                                            <span class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded text-gray-700 dark:text-gray-300 font-bold text-xs">{{ $item->size ?? 'Única' }}</span>
                                        </div>
                                        @if($item->custom_name || $item->custom_number)
                                            <div class="mt-2 bg-indigo-50 dark:bg-indigo-900/20 p-2 rounded-lg border border-indigo-100 dark:border-indigo-800/30 inline-block w-full sm:w-auto">
                                                <p class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wide mb-1">Personalización:</p>
                                                <div class="flex space-x-3 text-sm text-gray-700 dark:text-gray-300 font-mono">
                                                    @if($item->custom_name)
                                                        <span>Nombre: <b>{{ strtoupper($item->custom_name) }}</b></span>
                                                    @endif
                                                    @if($item->custom_name && $item->custom_number)
                                                        <span class="text-gray-300">|</span>
                                                    @endif
                                                    @if($item->custom_number)
                                                        <span>Dorsal: <b>{{ $item->custom_number }}</b></span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex items-end justify-between text-sm mt-2">
                                    <p class="text-gray-500 dark:text-gray-400">Cantidad: <span class="font-semibold text-gray-900 dark:text-white">{{ $item->quantity }}</span></p>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- 💰 TOTAL --}}
                <div class="border-t-2 border-dashed border-gray-200 dark:border-gray-700 mt-6 pt-6">
                    <div class="flex justify-between items-center">
                        <p class="text-gray-600 dark:text-gray-400 text-lg">Total Pagado</p>
                        <p class="text-3xl font-black text-gray-900 dark:text-white">{{ number_format($order->total, 2) }} €</p>
                    </div>
                </div>

                {{-- BOTONES --}}
                <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('orders.index') }}" class="flex items-center justify-center w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl py-3 px-8 text-base font-bold text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-600 transition shadow-sm">
                        📦 Ver mis Pedidos
                    </a>
                    <a href="{{ url('/') }}" class="flex items-center justify-center w-full bg-[#0004ff] dark:bg-indigo-600 border border-transparent rounded-xl py-3 px-8 text-base font-bold text-white hover:bg-[#0258f7] dark:hover:bg-indigo-500 transition shadow-lg shadow-indigo-500/30">
                        🛒 Seguir Comprando
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>