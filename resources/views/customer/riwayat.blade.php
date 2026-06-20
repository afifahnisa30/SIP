<x-app-layout>
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black tracking-tight"><i class="fas fa-receipt"></i> Riwayat Pesanan</h1>
                <p class="mt-2 text-blue-100 text-sm">Daftar pesanan yang sudah selesai dan diambil.</p>
            </div>
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white text-sm font-semibold px-5 py-2.5 rounded-2xl transition">
                <i class="fas fa-arrow-left"></i> Kembali ke Katalog
            </a>
        </div>
    </div>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @forelse($orders as $order)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm mb-4 overflow-hidden">

                {{-- Header Card --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-sm"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">{{ $order->product->nama }}</p>
                            <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600">
                        <i class="fas fa-box mr-1"></i> Sudah Diambil
                    </span>
                </div>

                {{-- Detail --}}
                <div class="px-6 py-4 grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                    <div>
                        <p class="text-gray-400 mb-1">Kategori</p>
                        <p class="font-semibold text-gray-700">{{ $order->product->kategori }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-1">Ukuran / Qty</p>
                        <p class="font-semibold text-gray-700">
                            @if($order->panjang && $order->lebar)
                                {{ $order->panjang }} x {{ $order->lebar }} m
                            @elseif($order->quantity)
                                {{ $order->quantity }} pcs
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-1">Total Harga</p>
                        <p class="font-bold text-blue-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-1">Metode Bayar</p>
                        <p class="font-semibold text-gray-700">{{ $order->metode_bayar ?? '-' }}</p>
                    </div>
                </div>

                {{-- Tombol Detail --}}
                <div class="px-6 pb-4 flex justify-end">
                    <a href="{{ route('orders.my.show', $order->id) }}"
                        class="flex items-center gap-2 text-xs font-semibold text-blue-600 hover:text-blue-800 transition">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>

            </div>
            @empty
            <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
                <i class="fas fa-history fa-3x text-gray-300 mb-3"></i>
                <p class="text-gray-500 font-semibold">Belum ada riwayat pesanan</p>
                <p class="text-sm text-gray-400 mt-1">Pesanan yang sudah diambil akan muncul di sini</p>
                <a href="{{ route('dashboard') }}"
                    class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-bold px-6 py-2.5 rounded-full hover:opacity-90 transition">
                    <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                </a>
            </div>
            @endforelse

            @if($orders->hasPages())
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
            @endif

        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</x-app-layout>