<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600 tracking-wide">Selamat Datang</h1>
        <p class="text-gray-400 text-sm mt-1">Silahkan masuk ke akun Anda untuk melanjutkan</p>
    </div>

    <x-validation-errors class="mb-4 text-center text-xs text-red-600 list-none" />

    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600 text-center bg-green-50 py-2 rounded-full">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input id="name" class="block w-full text-center placeholder-emerald-700/50 bg-[#d1ebd9]/50 border-none focus:bg-[#d1ebd9] focus:ring-2 focus:ring-blue-400 text-emerald-900 font-medium py-3 px-6 rounded-full transition duration-200 text-sm shadow-none" 
                type="text" 
                name="name" 
                :value="old('name')" 
                placeholder="Nama Pengguna" 
                required autofocus />
        </div>

        <div>
            <x-input id="password" class="block w-full text-center placeholder-emerald-700/50 bg-[#d1ebd9]/50 border-none focus:bg-[#d1ebd9] focus:ring-2 focus:ring-blue-400 text-emerald-900 font-medium py-3 px-6 rounded-full transition duration-200 text-sm shadow-none"
                type="password"
                name="password"
                placeholder="Kata Sandi"
                required autocomplete="current-password" />
        </div>

        <div class="flex items-center justify-between px-2 text-xs">
            <label for="remember_me" class="inline-flex items-center text-gray-500 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-gray-400 hover:text-blue-600 transition" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-gradient-to-r from-cyan-400 via-blue-500 to-blue-600 text-white font-bold py-3 px-4 rounded-full shadow-lg shadow-blue-500/20 hover:opacity-90 active:scale-[0.98] transition duration-200 tracking-wider text-sm">
                MASUK
            </button>
        </div>

        <div class="text-center text-xs text-gray-500 pt-2">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-blue-500 font-semibold underline hover:text-blue-600">
                Daftar sekarang
            </a>
        </div>
    </form>
</x-guest-layout>