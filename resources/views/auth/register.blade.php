<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-blue-600 tracking-wide">Daftar Akun</h1>
        <p class="text-gray-400 text-sm mt-1">Lengkapi data di bawah untuk mulai memesan</p>
    </div>

    <x-validation-errors class="mb-4 text-center text-xs text-red-600 list-none" />

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input id="name" class="block w-full text-center placeholder-emerald-700/50 bg-[#d1ebd9]/50 border-none focus:bg-[#d1ebd9] focus:ring-2 focus:ring-blue-400 text-emerald-900 font-medium py-3 px-6 rounded-full transition duration-200 text-sm shadow-none" 
                type="text" 
                name="name" 
                :value="old('name')" 
                placeholder="Nama Pengguna" 
                required autofocus autocomplete="name" />
        </div>

        <div>
            <x-input id="phone_number" class="block w-full text-center placeholder-emerald-700/50 bg-[#d1ebd9]/50 border-none focus:bg-[#d1ebd9] focus:ring-2 focus:ring-blue-400 text-emerald-900 font-medium py-3 px-6 rounded-full transition duration-200 text-sm shadow-none" 
                type="text" 
                name="phone_number" 
                :value="old('phone_number')" 
                placeholder="Nomor Telepon / WhatsApp" 
                required />
        </div>

        <div>
            <x-input id="email" class="block w-full text-center placeholder-emerald-700/50 bg-[#d1ebd9]/50 border-none focus:bg-[#d1ebd9] focus:ring-2 focus:ring-blue-400 text-emerald-900 font-medium py-3 px-6 rounded-full transition duration-200 text-sm shadow-none" 
                type="email" 
                name="email" 
                :value="old('email')" 
                placeholder="Alamat Email" />
        </div>

        <div>
            <x-input id="password" class="block w-full text-center placeholder-emerald-700/50 bg-[#d1ebd9]/50 border-none focus:bg-[#d1ebd9] focus:ring-2 focus:ring-blue-400 text-emerald-900 font-medium py-3 px-6 rounded-full transition duration-200 text-sm shadow-none" 
                type="password" 
                name="password" 
                placeholder="Kata Sandi Baru" 
                required autocomplete="new-password" />
        </div>

        <div>
            <x-input id="password_confirmation" class="block w-full text-center placeholder-emerald-700/50 bg-[#d1ebd9]/50 border-none focus:bg-[#d1ebd9] focus:ring-2 focus:ring-blue-400 text-emerald-900 font-medium py-3 px-6 rounded-full transition duration-200 text-sm shadow-none" 
                type="password" 
                name="password_confirmation" 
                placeholder="Konfirmasi Kata Sandi" 
                required autocomplete="new-password" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-gradient-to-r from-cyan-400 via-blue-500 to-blue-600 text-white font-bold py-3 px-4 rounded-full shadow-lg shadow-blue-500/20 hover:opacity-90 active:scale-[0.98] transition duration-200 tracking-wider text-sm">
                DAFTAR SEKARANG
            </button>
        </div>

        <div class="text-center text-xs text-gray-500 pt-1">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-blue-500 font-semibold underline hover:text-blue-600">
                Masuk di sini
            </a>
        </div>
    </form>
</x-guest-layout>