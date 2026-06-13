@extends('layouts.admin')

@section('content')

<div class="mb-6">
    <a href="{{ route('orders.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-2 transition">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl text-sm flex items-center gap-2">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- DETAIL PESANAN --}}
    <div class="xl:col-span-2 space-y-6">

        {{-- Info Pesanan --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-widest">Detail Pesanan</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-400">ID Pesanan</span>
                    <span class="font-semibold text-gray-800">#{{ $order->id }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-400">Produk</span>
                    <span class="font-semibold text-gray-800">{{ $order->product->nama }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-400">Kategori</span>
                    <span class="text-gray-700">{{ $order->product->kategori }}</span>
                </div>
                @if($order->panjang && $order->lebar)
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-400">Ukuran</span>
                    <span class="text-gray-700">{{ $order->panjang }} x {{ $order->lebar }} meter</span>
                </div>
                @endif
                @if($order->quantity)
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-400">Quantity</span>
                    <span class="text-gray-700">{{ $order->quantity }} pcs</span>
                </div>
                @endif
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-400">Catatan</span>
                    <span class="text-gray-700 text-right max-w-xs">{{ $order->catatan ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-400">Tanggal Pesan</span>
                    <span class="text-gray-700">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-400">Total Harga</span>
                    <span class="text-lg font-bold text-blue-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- File Desain --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-widest">File Desain</h3>
            @if($order->file_desain)
                @php $ext = pathinfo($order->file_desain, PATHINFO_EXTENSION); @endphp
                @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                    <img src="{{ asset($order->file_desain) }}" class="rounded-2xl border border-gray-100 max-h-64 object-contain">
                @endif
                <a href="{{ asset($order->file_desain) }}" target="_blank"
                    class="mt-3 inline-flex items-center gap-2 px-4 py-2.5 bg-blue-50 text-blue-600 text-sm font-semibold rounded-xl hover:bg-blue-100 transition">
                    <i class="fas fa-download"></i> Download File Desain
                </a>
            @else
                <p class="text-gray-400 text-sm">Tidak ada file desain</p>
            @endif
        </div>
    </div>

    {{-- SIDEBAR KANAN --}}
    <div class="space-y-6">

        {{-- Info Pelanggan --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-widest">Info Pelanggan</h3>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-semibold text-gray-800 text-sm">{{ $order->user->name }}</div>
                    <div class="text-xs text-gray-400">{{ $order->user->email }}</div>
                </div>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-widest">Update Status</h3>

            @if(!$order->diambil)
            <form action="{{ route('orders.update', $order->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <select name="status"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Diproses" {{ $order->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai Cetak" {{ $order->status == 'Selesai Cetak' ? 'selected' : '' }}>Selesai Cetak</option>
                </select>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-bold py-2.5 rounded-xl hover:opacity-90 transition">
                    <i class="fas fa-save mr-1"></i> Simpan Status
                </button>
            </form>

            @if($order->status == 'Selesai Cetak')
            <form action="{{ route('orders.update', $order->id) }}" method="POST" class="mt-4 space-y-3">
                @csrf
                @method('PUT')
                <input type="hidden" name="diambil" value="1">
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Metode Pembayaran</label>
                    <select name="metode_bayar"
                        class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer">Transfer</option>
                    </select>
                </div>
                <button type="submit"
                    onclick="return confirm('Tandai pesanan ini sudah diambil pelanggan?')"
                    class="w-full bg-emerald-500 text-white text-sm font-bold py-2.5 rounded-xl hover:opacity-90 transition">
                    <i class="fas fa-check-circle mr-1"></i> Tandai Sudah Diambil
                </button>
            </form>
            @endif

            @else
            <div class="space-y-2">
                <div class="flex items-center gap-2 p-3 bg-emerald-50 text-emerald-600 rounded-xl text-sm font-medium">
                    <i class="fas fa-check-circle"></i> Pesanan sudah diambil
                </div>
                <div class="flex items-center gap-2 p-3 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium">
                    <i class="fas fa-wallet"></i> Dibayar via {{ $order->metode_bayar }}
                </div>
            </div>
            @endif
        </div>

    </div>
</div>

@endsection