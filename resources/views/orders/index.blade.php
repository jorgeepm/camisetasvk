<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis Pedidos') }} 📦
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#e3edfc] dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 border border-gray-800 dark:border-gray-200">
                
                @if($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-400 dark:divide-gray-700">
                            <thead class="bg-transparent dark:bg-transparent">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nº Pedido</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Productos</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="bg-transparent dark:bg-transparent divide-y divide-gray-400 dark:divide-gray-700">
                                @foreach($orders as $order)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    {{-- FECHA --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    
                                    {{-- ID PEDIDO --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                        #{{ $order->id }}
                                    </td>
                                    
                                    {{-- PRODUCTOS CON FOTO --}}
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        <div class="space-y-4">
                                            @foreach($order->items as $item)
                                                <div class="flex items-start space-x-3">
                                                    
                                                    {{-- 🖼️ IMAGEN (Híbrida) --}}
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if($item->product && $item->product->image_blob)
                                                            <img class="h-10 w-10 rounded object-cover border border-gray-200 dark:border-gray-600" src="{{ $item->product->image_blob }}" alt="">
                                                        @elseif($item->product && $item->product->image_path)
                                                            <img class="h-10 w-10 rounded object-cover border border-gray-200 dark:border-gray-600" src="{{ asset('storage/' . $item->product->image_path) }}" alt="">
                                                        @else
                                                            <div class="h-10 w-10 rounded bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-xs text-gray-500">Sin Foto</div>
                                                        @endif
                                                    </div>

                                                    <div>
                                                        <div class="font-bold text-gray-800 dark:text-gray-200">
                                                            {{ $item->product->name ?? 'Producto eliminado' }}
                                                        </div>
                                                        <div class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-wider flex flex-wrap gap-2">
                                                            <span>Talla: <b class="text-indigo-500 dark:text-indigo-400">{{ $item->size ?? 'S/T' }}</b></span>

                                                            @if($item->custom_name)
                                                                <span class="border-l border-gray-300 dark:border-gray-600 pl-2">
                                                                    Nombre: <b class="text-indigo-500 dark:text-indigo-400">{{ $item->custom_name }}</b>
                                                                </span>
                                                            @endif

                                                            @if($item->custom_number)
                                                                <span class="border-l border-gray-300 dark:border-gray-600 pl-2">
                                                                    Nº: <b class="text-indigo-500 dark:text-indigo-400">{{ $item->custom_number }}</b>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>

                                    {{-- TOTAL --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600 dark:text-indigo-400">
                                        {{ number_format($order->total, 2) }} €
                                    </td>
                                    
                                    {{-- ESTADO --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        @php
                                            $statusData = match($order->status) {
                                                'paid' => ['text' => 'Pagado', 'class' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900 dark:text-green-200 dark:border-green-800'],
                                                'pending' => ['text' => 'Pendiente', 'class' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900 dark:text-yellow-200 dark:border-yellow-800'],
                                                'shipped' => ['text' => 'Enviado', 'class' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900 dark:text-blue-200 dark:border-blue-800'],
                                                'completed' => ['text' => 'Completado', 'class' => 'bg-indigo-100 text-indigo-800 border-indigo-200 dark:bg-indigo-900 dark:text-indigo-200 dark:border-indigo-800'],
                                                'cancelled' => ['text' => 'Cancelado', 'class' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900 dark:text-red-200 dark:border-red-800'],
                                                default => ['text' => $order->status, 'class' => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600'],
                                            };
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $statusData['class'] }} uppercase tracking-wide">
                                            {{ $statusData['text'] }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="mb-4">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-lg">Aún no has realizado ninguna compra.</p>
                        <a href="{{ route('catalog.all') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Ir al Catálogo
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>