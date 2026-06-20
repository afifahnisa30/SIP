@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Piutang</h2>
        <p class="text-xs text-gray-400 mt-1">Daftar pesanan yang belum dibayar</p>
    </div>
    {{-- <div class="bg-[#DC2626] px-5 py-3 rounded-2xl text-white text-right">
        <p class="text-xs text-red-200 font-medium uppercase tracking-widest">Total Piutang</p>
        <p class="text-lg font-black">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</p>
    </div> --}}
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl text-sm flex items-center gap-2">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

{{-- SEARCH --}}
<form method="GET" action="{{ route('orders.piutang') }}" class="flex gap-3 mb-6">
    <div class="relative flex-1 max-w-sm">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 text-sm"></i>
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama pelanggan..."
            class="w-full pl-10 pr-4 py-2.5 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>
    <button type="submit"
        class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-semibold rounded-2xl hover:opacity-90 transition">
        <i class="fas fa-search mr-1"></i> Cari
    </button>
    @if(request('search'))
    <a href="{{ route('orders.piutang') }}"
        class="px-5 py-2.5 bg-slate-100 text-slate-500 text-sm font-semibold rounded-2xl hover:bg-slate-200 transition">
        <i class="fas fa-times mr-1"></i> Reset
    </a>
    @endif
</form>

{{-- TABEL --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-xs text-gray-400 uppercase tracking-widest border-b border-gray-100">
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Pelanggan</th>
                    <th class="px-6 py-4 text-left">Produk</th>
                    <th class="px-6 py-4 text-left">Tgl Ambil</th>
                    <th class="px-6 py-4 text-left">Total</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                <tr class="text-gray-700 hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-gray-400">
                        {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">
                            {{ $order->user ? $order->user->name : $order->nama_pelanggan }}
                        </div>
                        <div class="text-xs text-gray-400">
                            {{ $order->user ? $order->user->phone_number : $order->no_telp }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-700">{{ $order->product->nama }}</td>
                    <td class="px-6 py-4 text-xs text-gray-400">{{ $order->updated_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 font-semibold text-red-500">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('orders.show', $order->id) }}"
                                class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-500 rounded-xl hover:bg-blue-100 transition"
                                title="Detail">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                            <form action="{{ route('orders.update', $order->id) }}" method="POST"
                                onsubmit="return confirm('Tandai pesanan ini sudah lunas?')">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status_bayar" value="Lunas">
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center bg-emerald-50 text-emerald-500 rounded-xl hover:bg-emerald-100 transition"
                                    title="Tandai Lunas">
                                    <i class="fas fa-check text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-xs">
                        <i class="fas fa-check-circle text-2xl mb-2 block text-emerald-400"></i>
                        Tidak ada piutang! Semua pesanan sudah lunas 🎉
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@endsection