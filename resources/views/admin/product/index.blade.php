@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Manajemen Produk</h2>
        <p class="text-xs text-gray-400 mt-1">Kelola semua produk percetakan CV Salam Indah</p>
    </div>
    <a href="{{ route('product.create') }}"
        class="flex items-center gap-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-2xl shadow hover:opacity-90 transition">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
</div>

{{-- ALERT --}}
@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl text-sm flex items-center gap-2">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

{{-- FILTER & SEARCH --}}
<form method="GET" action="{{ route('product.index') }}" class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="relative flex-1">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 text-sm"></i>
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama produk..."
            class="w-full pl-10 pr-4 py-2.5 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>

    <select name="kategori"
        class="min-w-[180px] py-2.5 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->nama }}" {{ request('kategori') == $cat->nama ? 'selected' : '' }}>
                {{ $cat->nama }}
            </option>
        @endforeach
    </select>

    <button type="submit"
        class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-semibold rounded-2xl hover:opacity-90 transition">
        <i class="fas fa-filter mr-1"></i> Filter
    </button>

    @if(request('search') || request('kategori'))
    <a href="{{ route('product.index') }}"
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
                    <th class="px-6 py-4 text-left">Foto</th>
                    <th class="px-6 py-4 text-left">Nama Produk</th>
                    <th class="px-6 py-4 text-left">Kategori</th>
                    <th class="px-6 py-4 text-left">Harga Dasar</th>
                    <th class="px-6 py-4 text-left">Ukuran Standar</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="text-gray-700 hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-gray-400">
                        {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-6 py-4">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" class="w-12 h-12 object-cover rounded-xl border border-gray-100">
                        @else
                            <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-gray-300">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $product->nama }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-medium">
                            {{ $product->kategori }}
                        </span>
                    </td>
                    <td class="px-6 py-4">Rp {{ number_format($product->harga_dasar, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $product->ukuran_standar ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('product.edit', $product->id) }}"
                                class="w-8 h-8 flex items-center justify-center bg-amber-50 text-amber-500 rounded-xl hover:bg-amber-100 transition"
                                title="Edit">
                                <i class="fas fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-400 rounded-xl hover:bg-red-100 transition"
                                    title="Hapus">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-xs">
                        <i class="fas fa-box-open text-2xl mb-2 block"></i>
                        Belum ada produk. Tambahkan produk pertama!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($products->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection