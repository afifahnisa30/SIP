<x-app-layout>

    {{-- HERO BANNER --}}
    <div class="relative bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-700 text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-xl">
                <span class="inline-block bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full mb-4 uppercase tracking-widest">
                    Percetakan Salam Indah
                </span>
                <h1 class="text-4xl sm:text-5xl font-black tracking-tight leading-tight mb-4">
                    Cetak Berkualitas,<br>
                    <span class="text-cyan-300">Harga Terjangkau</span>
                </h1>
                <p class="text-blue-100 text-base mb-8 max-w-md">
                    Layanan percetakan digital terpercaya untuk spanduk, brosur, stiker, kartu nama, dan kebutuhan cetak lainnya.
                </p>
                <div class="flex gap-3">
                    <a href="{{ route('katalog') }}"
                        class="bg-white text-blue-600 font-bold px-6 py-3 rounded-2xl hover:bg-blue-50 transition shadow-lg text-sm">
                        <i class="fas fa-th-large mr-2"></i> Lihat Katalog
                    </a>
                    <a href="{{ route('panduan') }}"
                        class="bg-white/20 hover:bg-white/30 text-white font-bold px-6 py-3 rounded-2xl transition text-sm">
                        <i class="fas fa-book-open mr-2"></i> Panduan
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="flex gap-4 shrink-0">
                <a href="{{ route('orders.my') }}"
                    class="bg-white/10 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/20 shadow-lg flex items-center gap-3 min-w-[150px] hover:bg-white/20 hover:scale-105 transition duration-200">
                    <div class="w-10 h-10 bg-amber-400/30 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-clock text-amber-300 text-sm"></i>
                    </div>
                    <div class="text-left">
                        <span class="block text-2xl font-black">{{ $activeOrders }}</span>
                        <span class="text-[11px] text-blue-100 font-medium leading-tight">Pesanan Aktif</span>
                    </div>
                </a>
                <a href="{{ route('orders.riwayat.customer') }}"
                    class="bg-white/10 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/20 shadow-lg flex items-center gap-3 min-w-[150px] hover:bg-white/20 hover:scale-105 transition duration-200">
                    <div class="w-10 h-10 bg-emerald-400/30 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-check-circle text-emerald-300 text-sm"></i>
                    </div>
                    <div class="text-left">
                        <span class="block text-2xl font-black">{{ $completedOrders }}</span>
                        <span class="text-[11px] text-blue-100 font-medium leading-tight">Total Selesai</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- Decorative circles --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-32 translate-x-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-24 -translate-x-24"></div>
    </div>

    <div class="bg-slate-50 min-h-screen pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500 text-white rounded-2xl shadow-md font-medium flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            {{-- KATEGORI --}}
            <div class="mb-10">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-xl font-black text-gray-800">Kategori Produk</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Pilih kategori sesuai kebutuhan cetak Anda</p>
                    </div>
                    <a href="{{ route('katalog') }}" class="text-sm text-blue-500 font-semibold hover:text-blue-700 transition">
                        Lihat Semua →
                    </a>
                </div>

                <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-6">
                    @forelse($categories as $cat)
                    <a href="{{ route('katalog', ['kategori' => $cat->nama]) }}"
                        class="flex flex-col items-center gap-3 group">
                        {{-- Lingkaran Ikon --}}
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-white border border-blue-500 shadow-sm rounded-full flex items-center justify-center group-hover:shadow-md group-hover:border-blue-200 group-hover:scale-105 transition-all duration-300">
                            {{-- Menggunakan Ikon dinamis berdasarkan nama kategori --}}
                            <i class="fas {{ 
                                    $cat->nama == 'Brosur' ? 'fa-file-alt' : 
                                    ($cat->nama == 'Kartu Nama' ? 'fa-id-card' : 
                                    ($cat->nama == 'Spanduk' ? 'fa-image' : 'fa-print')) 
                                }} text-2xl text-blue-500 group-hover:text-blue-600"></i>
                        </div>
                        {{-- Nama Kategori --}}
                        <p class="font-bold text-gray-700 text-xs sm:text-sm text-center">
                            {{ $cat->nama }}
                        </p>
                    </a>
                    @empty
                        <div class="col-span-full text-center text-gray-400 text-sm py-8">Belum ada kategori</div>
                    @endforelse
                </div>
            </div>

            {{-- PRODUK UNGGULAN --}}
            <div>
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-xl font-black text-gray-800">Produk Unggulan</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Produk percetakan terpopuler kami</p>
                    </div>
                    <a href="{{ route('katalog') }}" class="text-sm text-blue-500 font-semibold hover:text-blue-700 transition">
                        Lihat Semua →
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($products as $product)
                    <div class="bg-white rounded-3xl overflow-hidden flex flex-col group shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-gray-100">
                        <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                            <img src="{{ $product->image ? asset($product->image) : 'https://placehold.co/600x400?text=' . urlencode($product->nama) }}"
                                alt="{{ $product->nama }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-3 right-3 px-3 py-1 text-xs font-bold text-white rounded-full shadow-md bg-cyan-500">
                                {{ $product->kategori }}
                            </div>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-sm font-bold text-gray-800 mb-1 group-hover:text-blue-600 transition-colors">
                                {{ $product->nama }}
                            </h3>
                            <p class="text-xs text-slate-500 mb-3 flex items-center gap-1">
                                <i class="fas fa-info-circle text-cyan-500"></i>
                                {{ Str::limit($product->deskripsi, 40, '...') ?? 'Kualitas cetak premium' }}
                            </p>
                            <p class="text-sm font-black text-blue-600 mb-4">
                                @if(Auth::user()->tipe === 'Reseller' && $product->harga_reseller)
                                    Rp {{ number_format($product->harga_reseller, 0, ',', '.') }}
                                @else
                                    Rp {{ number_format($product->harga_dasar, 0, ',', '.') }}
                                @endif
                                <span class="text-xs font-normal text-gray-400">
                                    {{ in_array($product->kategori, ['Spanduk', 'Stiker']) ? '/ m²' : '/ pcs' }}
                                </span>
                            </p>
                            <div class="mt-auto">
                                <a href="{{ route('katalog', ['kategori' => $product->kategori]) }}"
                                    class="block w-full text-center bg-gradient-to-r from-cyan-400 to-blue-500 text-white font-bold py-2.5 rounded-full hover:opacity-90 transition text-xs">
                                    <i class="fas fa-shopping-cart mr-1"></i> Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center text-gray-400 text-sm py-8">
                        Belum ada produk
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</x-app-layout>