<x-app-layout>
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-500 via-red-600 to-rose-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black tracking-tight">Tagihan Saya</h1>
                <p class="mt-2 text-red-100 text-sm">Daftar pesanan yang belum dibayar.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-white/10 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/20 shadow-lg flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-invoice-dollar text-white"></i>
                    </div>
                    <div>
                        <p class="text-xl font-black">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
                        <p class="text-xs text-red-100 font-medium">Total Tagihan</p>
                    </div>
                </div>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white text-sm font-semibold px-5 py-2.5 rounded-2xl transition">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="py-12 bg-slate-50 min-h-screen pb-24">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500 text-white rounded-2xl text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @forelse($orders as $order)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm mb-4 overflow-hidden">

                {{-- Header Card --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-file-invoice text-sm"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">{{ $order->product->nama }}</p>
                            <p class="text-xs text-gray-400">Diambil: {{ $order->updated_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600">
                        <i class="fas fa-clock mr-1"></i> Belum Lunas
                    </span>
                </div>

                {{-- Detail --}}
                <div class="px-6 py-4 grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
                    <div>
                        <p class="text-gray-400 mb-1">Produk</p>
                        <p class="font-semibold text-gray-700">{{ $order->product->nama }}</p>
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
                        <p class="text-gray-400 mb-1">Total Tagihan</p>
                        <p class="font-black text-red-500 text-sm">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-6 pb-4 flex items-center justify-between">
                    <p class="text-xs text-gray-400">
                        <i class="fas fa-info-circle mr-1"></i>
                        Hubungi kami untuk konfirmasi pembayaran
                    </p>
                    <div class="flex gap-2">
                        <a href="{{ route('orders.my.show', $order->id) }}"
                            class="flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-800 transition">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <span class="text-gray-300">|</span>
                        <a href="https://wa.me/6282189346164?text=Halo%20Percetakan%20Salam%20Indah%2C%20saya%20ingin%20konfirmasi%20pembayaran%20untuk%20pesanan%20%23{{ $order->id }}"
                            target="_blank"
                            class="flex items-center gap-1 text-xs font-semibold text-green-600 hover:text-green-800 transition">
                            <i class="fab fa-whatsapp"></i> Konfirmasi Bayar
                        </button>
                        </a>
                    </div>
                </div>

            </div>
            @empty
            <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
                <i class="fas fa-check-circle fa-3x text-emerald-400 mb-3"></i>
                <p class="text-gray-500 font-semibold">Tidak ada tagihan!</p>
                <p class="text-sm text-gray-400 mt-1">Semua pesanan sudah lunas 🎉</p>
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