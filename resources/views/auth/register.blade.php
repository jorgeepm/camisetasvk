<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-[#FDFDFC] to-[#9cfcff] dark:from-gray-900 dark:via-gray-900 dark:to-indigo-700 p-6 font-sans antialiased">
        
        <div class="absolute top-8 left-8">
            <a href="/" class="text-sm font-bold text-black dark:text-gray-100 hover:text-[#0004ff] transition-colors flex items-center gap-2">
                ← VOLVER A INICIO
            </a>
        </div>

        <div class="mb-8">
            <a href="/">
                <x-logo class="h-24 w-auto drop-shadow-lg animate-pulse" style="animation-duration: 4s;" />
            </a>
        </div>

        <div class="w-full sm:max-w-md bg-white/70 dark:bg-[#161615]/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[20px_20px_60px_#bebebe,-20px_-20px_60px_#ffffff] dark:shadow-none border border-white/20">
            
            <div class="text-center mb-10">
                <h2 class="text-4xl font-black text-[#1b1b18] dark:text-white leading-none uppercase tracking-tighter">
                    ÚNETE AL <br> <span class="text-[#0004ff] dark:text-indigo-700">EQUIPO</span>
                </h2>
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm font-medium">Crea tu cuenta oficial en Camisetas FC</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-[#1b1b18] dark:text-gray-300 mb-2 ml-1">Nombre Completo</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                           class="w-full px-5 py-4 bg-white dark:bg-[#0a0a0a] border-none rounded-2xl shadow-inner focus:ring-2 focus:ring-[#0004ff] focus:dark:ring-indigo-700 transition-all text-[#1b1b18] dark:text-white"
                           placeholder="Tu nombre">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-[#1b1b18] dark:text-gray-300 mb-2 ml-1">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                           class="w-full px-5 py-4 bg-white dark:bg-[#0a0a0a] border-none rounded-2xl shadow-inner focus:ring-2 focus:ring-[#0004ff] focus:dark:ring-indigo-700 transition-all text-[#1b1b18] dark:text-white"
                           placeholder="tu@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-[#1b1b18] dark:text-gray-300 mb-2 ml-1">Contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="w-full px-5 py-4 bg-white dark:bg-[#0a0a0a] border-none rounded-2xl shadow-inner focus:ring-2 focus:ring-[#0004ff] focus:dark:ring-indigo-700 transition-all text-[#1b1b18] dark:text-white"
                           placeholder="Mínimo 8 caracteres">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-[#1b1b18] dark:text-gray-300 mb-2 ml-1">Confirmar Contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full px-5 py-4 bg-white dark:bg-[#0a0a0a] border-none rounded-2xl shadow-inner focus:ring-2 focus:ring-[#0004ff] focus:dark:ring-indigo-700 transition-all text-[#1b1b18] dark:text-white"
                           placeholder="Repite tu contraseña">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="pt-4">
                    <button class="w-full bg-[#1b1b18] dark:bg-white dark:text-black text-white py-5 rounded-3xl font-black text-xl tracking-widest hover:bg-[#0004ff] dark:hover:bg-indigo-700 dark:hover:text-white hover:-translate-y-1 transition-all shadow-[0_10px_30px_rgba(0,4,255,0.3)]">
                        REGISTRARSE
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-8 text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-tighter">
            ¿YA TIENES CUENTA? 
            <a href="{{ route('login') }}" class="text-[#0004ff] dark:text-white hover:underline ml-1">Inicia sesión</a>
        </p>
    </div>
</x-guest-layout>
