@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Riwayat Transaksi</h2>
        <p class="text-xs text-gray-400 mt-1">Pesanan yang sudah selesai dan diambil pelanggan</p>
    </div>
    {{-- Total Pendapatan --}}
    <div class="bg-emerald-50 border border-emerald-200 px-5 py-3 rounded-2xl text-right">
        <p class="text-xs text-emerald-500 font-medium uppercase tracking-widest">Total Pendapatan</p>
        <p class="text-lg font-black text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl text-sm flex items-center gap-2">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

{{-- FILTER --}}
<form method="GET" action="{{ route('orders.riwayat') }}" class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="relative flex-1">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 text-sm"></i>
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama pelanggan..."
            class="w-full pl-10 pr-4 py-2.5 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>

    <input type="date" name="dari" value="{{ request('dari') }}"
        class="py-2.5 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">

    <input type="date" name="sampai" value="{{ request('sampai') }}"
        class="py-2.5 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">

    <button type="submit"
        class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-semibold rounded-2xl hover:opacity-90 transition">
        <i class="fas fa-filter mr-1"></i> Filter
    </button>

    @if(request('search') || request('dari') || request('sampai'))
    <a href="{{ route('orders.riwayat') }}"
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
                    <th class="px-6 py-4 text-left">Detail</th>
                    <th class="px-6 py-4 text-left">Total</th>
                    <th class="px-6 py-4 text-left">Tgl Pesan</th>
                    <th class="px-6 py-4 text-left">Tgl Diambil</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                <tr class="text-gray-700 hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-gray-400">
                        {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ $order->user->name }}</div>
                        <div class="text-xs text-gray-400">{{ $order->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 font-medium">{{ $order->product->nama }}</td>
                    <td class="px-6 py-4 text-xs text-gray-500">
                        @if($order->panjang && $order->lebar)
                            {{ $order->panjang }} x {{ $order->lebar }} m
                        @elseif($order->quantity)
                            {{ $order->quantity }} pcs
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 font-semibold text-emerald-600 whitespace-nowrap">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-400 whitespace-nowrap">
                        {{ $order->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-400 whitespace-nowrap">
                        {{ $order->updated_at->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-xs">
                        <i class="fas fa-inbox text-2xl mb-2 block"></i>
                        Belum ada riwayat transaksi
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