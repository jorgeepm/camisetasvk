<x-guest-layout>
    {{-- ENCABEZADO (Igual que en Login pero con texto de registro) --}}
    <div class="text-center mb-8 mt-4">
        <h2 class="text-4xl font-black text-[#1b1b18] dark:text-white leading-none uppercase tracking-tighter">
            ÚNETE AL <br> <span class="text-[#0004ff] dark:text-indigo-500">EQUIPO</span>
        </h2>
        <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm font-medium tracking-wide">
            Crea tu cuenta oficial en Camisetas FC
        </p>
    </div>

    {{-- FORMULARIO LIMPIO --}}
    <form method="POST" action="{{ route('register') }}" class="space-y-5 px-1">
        @csrf

        {{-- NOMBRE --}}
        <div>
            <label class="block text-xs font-black uppercase tracking-widest text-[#1b1b18] dark:text-gray-300 mb-2 ml-1">
                Nombre Completo
            </label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                   class="w-full px-5 py-4 bg-gray-50 dark:bg-[#0a0a0a] border-2 border-transparent focus:border-[#0004ff] dark:focus:border-indigo-500 rounded-2xl shadow-inner focus:ring-0 transition-all text-[#1b1b18] dark:text-white placeholder-gray-400 font-medium"
                   placeholder="Ej: Cristiano Ronaldo">
            <x-input-error :messages="$errors->get('name')" class="mt-2 font-bold" />
        </div>

        {{-- EMAIL --}}
        <div>
            <label class="block text-xs font-black uppercase tracking-widest text-[#1b1b18] dark:text-gray-300 mb-2 ml-1">
                Email
            </label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                   class="w-full px-5 py-4 bg-gray-50 dark:bg-[#0a0a0a] border-2 border-transparent focus:border-[#0004ff] dark:focus:border-indigo-500 rounded-2xl shadow-inner focus:ring-0 transition-all text-[#1b1b18] dark:text-white placeholder-gray-400 font-medium"
                   placeholder="tu@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 font-bold" />
        </div>

        {{-- CONTRASEÑA --}}
        <div>
            <label class="block text-xs font-black uppercase tracking-widest text-[#1b1b18] dark:text-gray-300 mb-2 ml-1">
                Contraseña
            </label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full px-5 py-4 bg-gray-50 dark:bg-[#0a0a0a] border-2 border-transparent focus:border-[#0004ff] dark:focus:border-indigo-500 rounded-2xl shadow-inner focus:ring-0 transition-all text-[#1b1b18] dark:text-white placeholder-gray-400 font-medium"
                   placeholder="Mínimo 8 caracteres">
            <x-input-error :messages="$errors->get('password')" class="mt-2 font-bold" />
        </div>

        {{-- CONFIRMAR --}}
        <div>
            <label class="block text-xs font-black uppercase tracking-widest text-[#1b1b18] dark:text-gray-300 mb-2 ml-1">
                Repetir Contraseña
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full px-5 py-4 bg-gray-50 dark:bg-[#0a0a0a] border-2 border-transparent focus:border-[#0004ff] dark:focus:border-indigo-500 rounded-2xl shadow-inner focus:ring-0 transition-all text-[#1b1b18] dark:text-white placeholder-gray-400 font-medium"
                   placeholder="Vuelve a escribirla">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 font-bold" />
        </div>

        {{-- BOTÓN REGISTRAR --}}
        <div class="pt-6 pb-2">
            <button class="w-full bg-[#1b1b18] dark:bg-white dark:text-black text-white py-4 rounded-2xl font-black text-xl tracking-widest hover:bg-[#0004ff] dark:hover:bg-indigo-600 dark:hover:text-white hover:-translate-y-1 transition-all shadow-lg hover:shadow-indigo-500/30">
                CREAR CUENTA ➜
            </button>
        </div>
    </form>

    {{-- FOOTER --}}
    <div class="mt-6 mb-2 text-center">
        <p class="text-xs font-bold text-gray-500 dark:text-gray-500 uppercase tracking-wider">
            ¿Ya tienes cuenta? 
            <a href="{{ route('login') }}" class="text-[#0004ff] dark:text-indigo-400 hover:underline ml-1 font-black">
                Inicia sesión
            </a>
        </p>
    </div>
</x-guest-layout>