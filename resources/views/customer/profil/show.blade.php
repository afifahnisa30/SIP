<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen pb-24">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 text-red-600 border border-red-200 rounded-2xl text-sm flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- KIRI - Card Profil --}}
                <div class="lg:col-span-1 space-y-4">

                    {{-- Card Info --}}
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                        {{-- Banner --}}
                        <div class="h-24 bg-gradient-to-r from-cyan-500 to-blue-600"></div>

                        {{-- Avatar & Info --}}
                        <div class="px-6 pb-6 -mt-10">
                            <div class="w-20 h-20 rounded-2xl bg-white border-4 border-white shadow-md flex items-center justify-center text-2xl font-black text-blue-600 mb-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <h2 class="text-lg font-black text-gray-800">{{ $user->name }}</h2>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $user->email ?? '-' }}</p>
                            <div class="flex gap-2 mt-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600">
                                    {{ ucfirst($user->role) }}
                                </span>
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $user->tipe == 'Reseller' ? 'bg-purple-50 text-purple-600' : 'bg-gray-50 text-gray-500' }}">
                                    {{ $user->tipe }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Card Stats --}}
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-3">
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Informasi Akun</h3>
                        <div class="flex items-center gap-3 text-sm">
                            <div class="w-8 h-8 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center shrink-0">
                                <i class="fas fa-phone text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">No. Telepon</p>
                                <p class="font-semibold text-gray-700">{{ $user->phone_number }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <div class="w-8 h-8 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center shrink-0">
                                <i class="fas fa-calendar text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Bergabung Sejak</p>
                                <p class="font-semibold text-gray-700">{{ $user->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- KANAN - Form Edit --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Form Update Profil --}}
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                        <h3 class="text-sm font-bold text-gray-800 mb-5 flex items-center gap-2">
                            <i class="fas fa-user-edit text-cyan-500"></i> Edit Profil
                        </h3>

                        @if($errors->has('name') || $errors->has('email') || $errors->has('phone_number'))
                            <div class="mb-4 p-3 bg-red-50 text-red-600 border border-red-200 rounded-2xl text-xs">
                                @foreach($errors->only(['name', 'email', 'phone_number']) as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form action="{{ route('customer.profil.update') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">No. Telepon</label>
                                <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 mb-1">Role</label>
                                    <input type="text" value="{{ ucfirst($user->role) }}" disabled
                                        class="w-full py-2.5 px-4 text-sm text-gray-400 bg-gray-50 border border-gray-200 rounded-xl cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 mb-1">Tipe</label>
                                    <input type="text" value="{{ $user->tipe }}" disabled
                                        class="w-full py-2.5 px-4 text-sm text-gray-400 bg-gray-50 border border-gray-200 rounded-xl cursor-not-allowed">
                                </div>
                            </div>
                            <div class="pt-2">
                                <button type="submit"
                                    class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-bold px-6 py-2.5 rounded-xl hover:opacity-90 transition">
                                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Form Update Password --}}
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                        <h3 class="text-sm font-bold text-gray-800 mb-5 flex items-center gap-2">
                            <i class="fas fa-lock text-cyan-500"></i> Ubah Password
                        </h3>

                        @if($errors->has('current_password') || $errors->has('password'))
                            <div class="mb-4 p-3 bg-red-50 text-red-600 border border-red-200 rounded-2xl text-xs">
                                @foreach($errors->only(['current_password', 'password']) as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form action="{{ route('customer.profil.password') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Password Lama</label>
                                <input type="password" name="current_password"
                                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Password Baru</label>
                                <input type="password" name="password"
                                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </div>
                            <div class="pt-2">
                                <button type="submit"
                                    class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-bold px-6 py-2.5 rounded-xl hover:opacity-90 transition">
                                    <i class="fas fa-key mr-1"></i> Ubah Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</x-app-layout>