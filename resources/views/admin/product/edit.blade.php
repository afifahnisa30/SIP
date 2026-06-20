@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('product.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-2 transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Produk
        </a>
    </div>

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <h2 class="text-2xl font-black text-gray-800 mb-2">Edit Produk</h2>
        <p class="text-sm text-gray-500 mb-8">Perbarui informasi produk percetakan.</p>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 text-red-600 border border-red-200 rounded-2xl text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                <input type="text" name="nama" value="{{ old('nama', $product->nama) }}" required
                    class="w-full py-3 px-5 text-gray-700 bg-slate-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition text-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" required
                        class="w-full py-3 px-5 text-gray-700 bg-slate-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition text-sm">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->nama }}" {{ old('kategori', $product->kategori) == $cat->nama ? 'selected' : '' }}>
                                {{ $cat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Harga Dasar (Rp)</label>
                    <input type="number" name="harga_dasar" value="{{ old('harga_dasar', $product->harga_dasar) }}" required
                        class="w-full py-3 px-5 text-gray-700 bg-slate-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Harga Reseller (Rp) <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="number" name="harga_reseller" value="{{ old('harga_reseller', $product->harga_reseller) }}" placeholder="Contoh: 12000"
                        class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <span class="text-xs text-gray-400 mt-1 block">*Kosongkan jika tidak ada harga khusus reseller</span>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Lebar Bahan Standar Mesin (Meter)</label>
                <input type="text" name="ukuran_standar" value="{{ old('ukuran_standar', $product->ukuran_standar) }}"
                    class="w-full py-3 px-5 text-gray-700 bg-slate-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi / Keterangan Produk</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full py-3 px-5 text-gray-700 bg-slate-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition text-sm">{{ old('deskripsi', $product->deskripsi) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Foto Produk</label>
                @if($product->image)
                    <div class="mb-3">
                        <img src="{{ asset($product->image) }}" class="w-24 h-24 object-cover rounded-2xl border border-gray-100">
                        <p class="text-xs text-gray-400 mt-1">Foto saat ini. Upload baru untuk mengganti.</p>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold py-3.5 rounded-full shadow-lg hover:opacity-90 transition text-sm tracking-wide">
                    <i class="fas fa-save mr-2"></i> UPDATE PRODUK
                </button>
            </div>

        </form>
    </div>
</div>

@endsection