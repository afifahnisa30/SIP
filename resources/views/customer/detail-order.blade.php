<x-app-layout>
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black tracking-tight"><i class="fas fa-file-alt"></i> Detail Pesanan</h1>
                <p class="mt-1 text-blue-100 text-sm">Order #{{ $order->id }}</p>
            </div>
            <a href="{{ route('orders.riwayat.customer') }}"
                class="flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white text-sm font-semibold px-5 py-2.5 rounded-2xl transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- STATUS PROGRESS --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-5">Status Pesanan</h3>
                <div class="flex items-center gap-2">
                    @php
                        $steps = ['Pending', 'Diproses', 'Selesai Cetak'];
                        $currentStep = array_search($order->status, $steps);
                        if($order->diambil) $currentStep = 3;
                    @endphp
                    @foreach($steps as $i => $step)
                        <div class="flex items-center {{ $i < count($steps) - 1 ? 'flex-1' : '' }}">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
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
                    <div class="flex-1 h-0.5 mx-2 mb-4 {{ $order->diambil ? 'bg-blue-500' : 'bg-gray-100' }}"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                            {{ $order->diambil ? 'bg-emerald-500 text-white' : 'bg-gray-100 text-gray-400' }}">
                            {{ $order->diambil ? '✓' : '4' }}
                        </div>
                        <span class="text-[10px] mt-1 {{ $order->diambil ? 'text-emerald-500 font-bold' : 'text-gray-400' }}">
                            Diambil
                        </span>
                    </div>
                </div>

                @if($order->status == 'Selesai Cetak' && !$order->diambil)
                <div class="mt-4 p-3 bg-emerald-50 border border-emerald-200 rounded-2xl text-sm text-emerald-700 flex items-center gap-2">
                    <i class="fas fa-bell"></i>
                    <span>Pesanan kamu sudah selesai dicetak dan siap diambil!</span>
                </div>
                @endif
            </div>

            {{-- INFO PRODUK --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Info Produk</h3>
                <div class="flex items-center gap-4 mb-4">
                    @if($order->product->image)
                    <img src="{{ asset($order->product->image) }}" class="w-16 h-16 object-cover rounded-2xl border border-gray-100">
                    @else
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-gray-300">
                        <i class="fas fa-image text-xl"></i>
                    </div>
                    @endif
                    <div>
                        <p class="font-bold text-gray-800">{{ $order->product->nama }}</p>
                        <span class="px-2 py-1 bg-blue-50 text-blue-600 text-xs font-medium rounded-full">{{ $order->product->kategori }}</span>
                    </div>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-400">Order ID</span>
                        <span class="font-semibold text-gray-800">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-400">Tanggal Pesan</span>
                        <span class="font-semibold text-gray-800">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($order->panjang && $order->lebar)
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-400">Ukuran</span>
                        <span class="font-semibold text-gray-800">{{ $order->panjang }} x {{ $order->lebar }} meter</span>
                    </div>
                    @endif
                    @if($order->quantity)
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-400">Quantity</span>
                        <span class="font-semibold text-gray-800">{{ $order->quantity }} pcs</span>
                    </div>
                    @endif
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-400">Catatan</span>
                        <span class="font-semibold text-gray-800 text-right max-w-xs">{{ $order->catatan ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-400">Total Harga</span>
                        <span class="text-lg font-black text-blue-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- FILE DESAIN --}}
            @if($order->file_desain)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">File Desain</h3>
                @php $ext = pathinfo($order->file_desain, PATHINFO_EXTENSION); @endphp
                @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                    <img src="{{ asset($order->file_desain) }}" class="rounded-2xl border border-gray-100 max-h-48 object-contain mb-3">
                @endif
                <a href="{{ asset($order->file_desain) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-50 text-blue-600 text-sm font-semibold rounded-xl hover:bg-blue-100 transition">
                    <i class="fas fa-download"></i> Download File Desain
                </a>
            </div>
            @endif

        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</x-app-layout>