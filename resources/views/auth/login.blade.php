<x-guest-layout>
    {{-- ENCABEZADO DEL LOGIN --}}
    <div class="text-center mb-8">
        <h2 class="text-4xl font-black text-[#1b1b18] dark:text-white leading-none uppercase tracking-tighter">
            HOLA DE <br> <span class="text-[#0004ff] dark:text-indigo-500">NUEVO</span>
        </h2>
        <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm font-medium tracking-wide">
            Entra en tu zona VIP de Camisetas FC
        </p>
    </div>

    {{-- ESTATUS DE SESIÓN (Errores o mensajes) --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- EMAIL --}}
        <div>
            <label class="block text-xs font-black uppercase tracking-widest text-[#1b1b18] dark:text-gray-300 mb-2 ml-1">
                Email
            </label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                   class="w-full px-5 py-4 bg-gray-50 dark:bg-[#0a0a0a] border-2 border-transparent focus:border-[#0004ff] dark:focus:border-indigo-500 rounded-2xl shadow-inner focus:ring-0 transition-all text-[#1b1b18] dark:text-white placeholder-gray-400 font-medium"
                   placeholder="tu@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 font-bold" />
        </div>

        {{-- CONTRASEÑA --}}
        <div>
            <div class="flex justify-between ml-1 mb-2">
                <label class="block text-xs font-black uppercase tracking-widest text-[#1b1b18] dark:text-gray-300">
                    Contraseña
                </label>
            </div>
            <input id="password" type="password" name="password" required 
                   class="w-full px-5 py-4 bg-gray-50 dark:bg-[#0a0a0a] border-2 border-transparent focus:border-[#0004ff] dark:focus:border-indigo-500 rounded-2xl shadow-inner focus:ring-0 transition-all text-[#1b1b18] dark:text-white placeholder-gray-400 font-medium"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2 font-bold" />
        </div>

        {{-- RECORDAR Y OLVIDÉ CLAVE --}}
        <div class="flex items-center justify-between px-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <div class="relative">
                    <input id="remember_me" type="checkbox" class="sr-only peer" name="remember">
                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-[#0004ff]"></div>
                </div>
                <span class="ms-2 text-xs font-bold text-gray-500 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 uppercase tracking-tighter transition-colors">
                    Recuérdame
                </span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-xs font-black text-gray-400 hover:text-[#0004ff] dark:hover:text-indigo-400 transition-colors uppercase tracking-tight" href="{{ route('password.request') }}">
                    ¿Olvidaste la clave?
                </a>
            @endif
        </div>

        {{-- BOTÓN LOG IN --}}
        <div class="pt-2">
            <button class="w-full bg-[#1b1b18] dark:bg-white dark:text-black text-white py-4 rounded-2xl font-black text-xl tracking-widest hover:bg-[#0004ff] dark:hover:bg-indigo-600 dark:hover:text-white hover:-translate-y-1 transition-all shadow-[0_10px_20px_rgba(0,0,0,0.1)] hover:shadow-[0_10px_30px_rgba(0,4,255,0.4)]">
                ENTRAR ➜
            </button>
        </div>
    </form>

    {{-- FOOTER --}}
    <div class="mt-8 text-center">
        <p class="text-xs font-bold text-gray-500 dark:text-gray-500 uppercase tracking-wider">
            ¿Aún no estás en el equipo? 
            <a href="{{ route('register') }}" class="text-[#0004ff] dark:text-indigo-400 hover:underline ml-1 font-black">
                Crea tu cuenta
            </a>
        </p>
    </div>
</x-guest-layout>