@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Kategori Produk</h2>
        <p class="text-xs text-gray-400 mt-1">Kelola kategori produk percetakan</p>
    </div>
</div>

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

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- FORM TAMBAH --}}
    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <h3 class="text-sm font-bold text-gray-700 mb-4">Tambah Kategori Baru</h3>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-600 border border-red-200 rounded-2xl text-xs">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('category.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Nama Kategori</label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Spanduk"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Deskripsi (opsional)</label>
                <textarea name="deskripsi" rows="3" placeholder="Keterangan singkat kategori..."
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">{{ old('deskripsi') }}</textarea>
            </div>
            <button type="submit"
                class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-bold py-2.5 rounded-xl hover:opacity-90 transition">
                <i class="fas fa-plus mr-1"></i> Tambah Kategori
            </button>
        </form>
    </div>

    {{-- TABEL KATEGORI --}}
    <div class="xl:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-xs text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-6 py-4 text-left">No</th>
                        <th class="px-6 py-4 text-left">Nama Kategori</th>
                        <th class="px-6 py-4 text-left">Deskripsi</th>
                        <th class="px-6 py-4 text-center">Jml Produk</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($categories as $i => $category)
                    <tr class="text-gray-700 hover:bg-slate-50 transition" x-data="{ editing: false }">
                        <td class="px-6 py-4 text-gray-400">{{ $categories->firstItem() + $i }}</td>

                        {{-- Nama --}}
                        <td class="px-6 py-4 font-medium">
                            <span x-show="!editing">{{ $category->nama }}</span>
                            <input x-show="editing" type="text" name="nama" value="{{ $category->nama }}"
                                form="form-edit-{{ $category->id }}"
                                class="w-full py-2 px-3 text-sm border border-blue-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </td>

                        {{-- Deskripsi --}}
                        <td class="px-6 py-4 text-gray-400 text-xs">
                            <span x-show="!editing">{{ $category->deskripsi ?? '-' }}</span>
                            <input x-show="editing" type="text" name="deskripsi" value="{{ $category->deskripsi }}"
                                form="form-edit-{{ $category->id }}"
                                class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl focus:outline-none">
                        </td>

                        {{-- Jumlah Produk --}}
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-medium">
                                {{ $category->products_count }} produk
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" x-show="!editing" @click="editing = true"
                                    class="w-8 h-8 flex items-center justify-center bg-amber-50 text-amber-500 rounded-xl hover:bg-amber-100 transition">
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                                <button type="submit" x-show="editing" form="form-edit-{{ $category->id }}"
                                    class="w-8 h-8 flex items-center justify-center bg-emerald-50 text-emerald-500 rounded-xl hover:bg-emerald-100 transition">
                                    <i class="fas fa-check text-xs"></i>
                                </button>
                                <div x-show="!editing">
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-400 rounded-xl hover:bg-red-100 transition">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                                <button type="button" x-show="editing" @click="editing = false"
                                    class="w-8 h-8 flex items-center justify-center bg-gray-50 text-gray-400 rounded-xl hover:bg-gray-100 transition">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Form edit di luar tr --}}
                    <form id="form-edit-{{ $category->id }}"
                        action="{{ route('category.update', $category->id) }}"
                        method="POST" style="display:none">
                        @csrf
                        @method('PUT')
                    </form>

                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 text-xs">
                            <i class="fas fa-tags text-2xl mb-2 block"></i>
                            Belum ada kategori. Tambahkan kategori pertama!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

@endsection