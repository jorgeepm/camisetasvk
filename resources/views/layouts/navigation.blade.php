<nav x-data="{ open: false }" class="bg-transparent backdrop-blur-md dark:border-gray-700 relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- LOGO --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                {{-- MENÚ ESCRITORIO --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Destacados') }}
                    </x-nav-link>

                    {{-- DROPDOWN CAMISETAS --}}
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black dark:text-gray-100 bg-transparent hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>Camisetas</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                    
                            <x-slot name="content">
                                <x-dropdown-link :href="route('catalog.all')">
                                    {{ __('Ver todas') }}
                                </x-dropdown-link>
                                <div class="border-t border-gray-100 dark:border-gray-600"></div>
                                
                                {{-- 🔧 CORRECCIÓN AQUÍ: Enlaces con filtro --}}
                                @if(isset($globalCategories))
                                    @foreach($globalCategories as $category)
                                        <x-dropdown-link :href="route('catalog.all', ['categoryId' => $category->id])">
                                            {{ $category->name }}
                                        </x-dropdown-link>
                                    @endforeach
                                @endif
                            </x-slot>
                        </x-dropdown>
                    </div>

                    {{-- MENÚ ADMIN --}}
                    @if(Auth::user() && Auth::user()->role === 'admin')
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-indigo-600 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        <div class="text-white font-bold">Administración</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('products.index')">
                                        {{ __('Gestionar Productos') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link :href="route('admin.categories.index')">
                                        {{ __('Gestionar Categorías') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link :href="route('admin.orders.index')">
                                        {{ __('Ver Ventas (Admin)') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif

                    @if(Auth::user() && Auth::user()->role !== 'admin') 
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                            {{ __('Mis Pedidos') }}
                        </x-nav-link>
                    @endif

                </div>
            </div>

            {{-- CARRITO Y LOGIN (Derecha) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if(!Auth::check() || Auth::user()->role !== 'admin')
                    <div class="mr-4">
                        <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                            {{ __('Carrito') }} 
                            @if(session('cart'))
                                <span class="ml-2 bg-[#0004ff] text-white text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-indigo-200 dark:text-indigo-900">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </x-nav-link>
                    </div>
                @endif

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white dark:text-white bg-[#0004ff] dark:bg-indigo-600 hover:text-white dark:hover:text-gray-200 focus:outline-none transition ease-in-out duration-150 transform hover:-translate-y-0.5">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            
                            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="inline-block text-sm text-black dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-300 font-bold transform hover:-translate-y-0.5">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="inline-block text-sm text-white bg-black dark:bg-indigo-700 hover:bg-[#0004ff] dark:hover:bg-indigo-500 px-3 py-2 rounded-md font-bold transform hover:-translate-y-0.5">Registrarse</a>
                    </div>
                @endauth
            </div>

            {{-- BOTÓN HAMBURGUESA (Móvil) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENÚ MÓVIL --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Destacados') }}
            </x-responsive-nav-link>

            <div class="border-t border-gray-200 dark:border-gray-600 mt-2 pt-2 pb-2">
                <div class="px-4 text-xs text-gray-400 uppercase font-bold mb-1">Catálogo</div>
                <x-responsive-nav-link :href="route('catalog.all')">
                    {{ __('Ver todas') }}
                </x-responsive-nav-link>
                
                {{-- 🔧 CORRECCIÓN AQUÍ TAMBIÉN: Enlaces móviles con filtro --}}
                @if(isset($globalCategories))
                    @foreach($globalCategories as $category)
                        <x-responsive-nav-link :href="route('catalog.all', ['categoryId' => $category->id])">
                            {{ $category->name }}
                        </x-responsive-nav-link>
                    @endforeach
                @endif
            </div>

            @if(Auth::user() && Auth::user()->role === 'admin')
                <div class="border-t border-gray-200 dark:border-gray-600 mt-2 pt-2 pb-2">
                    <div class="px-4 text-xs text-gray-400 uppercase font-bold mb-1 text-indigo-600">Zona Admin</div>
                    <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                        {{ __('Gestionar Productos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        {{ __('Gestionar Categorías') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                        {{ __('Ver Ventas') }}
                    </x-responsive-nav-link>
                </div>
            @endif

            @if(Auth::user() && Auth::user()->role !== 'admin')
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                    {{ __('Mis Pedidos') }}
                </x-responsive-nav-link>
            @endif

            @if(!Auth::check() || Auth::user()->role !== 'admin')
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                    {{ __('Carrito') }}
                    @if(session('cart'))
                        <span class="ml-2">({{ count(session('cart')) }})</span>
                    @endif
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1 bg-gray-50 dark:bg-gray-900">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Iniciar Sesión') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Registrarse') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>