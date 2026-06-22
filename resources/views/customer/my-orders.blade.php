<x-app-layout>
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black tracking-tight"><i class="fas fa-box"></i> Pesanan Saya</h1>
                <p class="mt-2 text-blue-100 text-sm">Pantau status pesanan cetakmu di sini.</p>
            </div>
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white text-sm font-semibold px-5 py-2.5 rounded-2xl transition">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500 text-white rounded-2xl text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            {{-- FILTER TABS --}}
            <div class="flex gap-2 mb-6 flex-wrap">
                <a href="{{ route('orders.my') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-2xl text-sm font-semibold transition
                    {{ !request('status') ? 'bg-blue-600 text-white shadow' : 'bg-white text-gray-500 hover:bg-gray-50 border border-gray-200' }}">
                    <i class="fas fa-list text-xs"></i> Semua
                </a>
                <a href="{{ route('orders.my', ['status' => 'Pending']) }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-2xl text-sm font-semibold transition
                    {{ request('status') == 'Pending' ? 'bg-amber-500 text-white shadow' : 'bg-white text-gray-500 hover:bg-gray-50 border border-gray-200' }}">
                    <i class="fas fa-clock text-xs"></i> Pending
                </a>
                <a href="{{ route('orders.my', ['status' => 'Diproses']) }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-2xl text-sm font-semibold transition
                    {{ request('status') == 'Diproses' ? 'bg-blue-500 text-white shadow' : 'bg-white text-gray-500 hover:bg-gray-50 border border-gray-200' }}">
                    <i class="fas fa-spinner text-xs"></i> Diproses
                </a>
                <a href="{{ route('orders.my', ['status' => 'Selesai Cetak']) }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-2xl text-sm font-semibold transition
                    {{ request('status') == 'Selesai Cetak' ? 'bg-emerald-500 text-white shadow' : 'bg-white text-gray-500 hover:bg-gray-50 border border-gray-200' }}">
                    <i class="fas fa-check-circle text-xs"></i> Selesai Cetak
                </a>
            </div>

            @forelse($orders as $order)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm mb-4 overflow-hidden">
                
                {{-- Header Card --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-print text-sm"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">{{ $order->product->nama }}</p>
                            <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @php
                        $statusColor = match($order->status) {
                            'Pending'       => 'bg-amber-100 text-amber-600',
                            'Diproses'      => 'bg-blue-100 text-blue-600',
                            'Selesai Cetak' => 'bg-emerald-100 text-emerald-600',
                            default         => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColor }}">
                        {{ $order->diambil ? 'Sudah Diambil' : $order->status }}
                    </span>
                </div>

                {{-- Tombol Detail --}}
                <div class="px-6 pb-3 flex justify-end">
                    <a href="{{ route('orders.my.show', $order->id) }}"
                        class="flex items-center gap-2 text-xs font-semibold text-blue-600 hover:text-blue-800 transition">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
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
                        <p class="text-gray-400 mb-1">Catatan</p>
                        <p class="font-semibold text-gray-700">{{ $order->catatan ?? '-' }}</p>
                    </div>
                </div>

                {{-- Progress Bar Status --}}
                <div class="px-6 pb-5">
                    <div class="flex items-center gap-2">
                        @php
                            $steps = ['Pending', 'Diproses', 'Selesai Cetak'];
                            $currentStep = array_search($order->status, $steps);
                            if($order->diambil) $currentStep = 3;
                        @endphp
                        @foreach($steps as $i => $step)
                            <div class="flex items-center {{ $i < count($steps) - 1 ? 'flex-1' : '' }}">
                                <div class="flex flex-col items-center">
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold
                                        {{ $i <= $currentStep ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-400' }}">
                                        {{ $i <= $currentStep ? '✓' : $i + 1 }}
                                    </div>
                                    <span class="text-[10px] mt-1 {{ $i <= $currentStep ? 'text-blue-500 font-bold' : 'text-gray-400' }}">
                                        {{ $step }}
                                    </span>
                                </div>
                                @if($i < count($steps) - 1)
                                <div class="flex-1 h-0.5 mx-2 mb-4 {{ $i < $currentStep ? 'bg-blue-500' : 'bg-gray-100' }}"></div>
                                @endif
                            </div>
                        @endforeach

                        {{-- Step Diambil --}}
                        <div class="flex-1 h-0.5 mx-2 mb-4 {{ $order->diambil ? 'bg-blue-500' : 'bg-gray-100' }}"></div>
                        <div class="flex flex-col items-center">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold
                                {{ $order->diambil ? 'bg-emerald-500 text-white' : 'bg-gray-100 text-gray-400' }}">
                                {{ $order->diambil ? '✓' : '4' }}
                            </div>
                            <span class="text-[10px] mt-1 {{ $order->diambil ? 'text-emerald-500 font-bold' : 'text-gray-400' }}">
                                Diambil
                            </span>
                        </div>
                    </div>
                </div>

            </div>
            @empty
            <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
                <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                <p class="text-gray-500 font-semibold">
                    {{ request('status') ? 'Tidak ada pesanan dengan status ini' : 'Belum ada pesanan' }}
                </p>
                <p class="text-sm text-gray-400 mt-1">Yuk mulai pesan produk percetakan!</p>
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