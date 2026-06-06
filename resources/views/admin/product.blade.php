<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 px-4">
            
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-2 transition">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-2xl font-black text-gray-800 mb-2">Tambah Produk Percetakan</h2>
                <p class="text-sm text-gray-500 mb-8">Masukkan spesifikasi produk baru agar otomatis muncul di katalog pelanggan.</p>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-500 text-white rounded-2xl text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Spanduk Flexi 280gr" required
                            class="w-full py-3 px-5 text-gray-700 bg-slate-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-200 text-sm">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                            <select name="kategori" required
                                class="w-full py-3 px-5 text-gray-700 bg-slate-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-200 text-sm">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Spanduk">Spanduk / Banner</option>
                                <option value="Stiker">Stiker Label</option>
                                <option value="Kartu Nama">Kartu Nama</option>
                                <option value="Brosur">Brosur / Flyer</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Harga Dasar (Rp)</label>
                            <input type="number" name="harga_dasar" value="{{ old('harga_dasar') }}" placeholder="Contoh: 15000" required
                                class="w-full py-3 px-5 text-gray-700 bg-slate-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-200 text-sm">
                            <span class="text-xs text-gray-400 mt-1 block">*Per meter persegi untuk spanduk, atau per lembar/box untuk produk lain.</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Lebar Bahan Standar Mesin (Meter)</label>
                        <input type="text" name="ukuran_standard" value="{{ old('ukuran_standar') }}" placeholder="Contoh jika banyak: 2,3,4 (pisahkan dengan koma)"
                            class="w-full py-3 px-5 text-gray-700 bg-slate-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-200 text-sm">
                        <span class="text-xs text-gray-400 mt-1 block">*Khusus produk Spanduk, masukkan angka lebar roll bahan yang tersedia di workshop untuk rumus pembulatan otomatis. Kosongkan jika bukan spanduk.</span>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi / Keterangan Produk</label>
                        <textarea name="deskripisi" rows="4" placeholder="Tulis informasi detail mengenai bahan atau minimal order..."
                            class="w-full py-3 px-5 text-gray-700 bg-slate-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-200 text-sm">{{ old('deskripisi') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Foto Produk</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold py-3.5 rounded-full shadow-lg shadow-blue-500/20 hover:opacity-90 active:scale-[0.99] transition duration-200 tracking-wide text-sm">
                            <i class="fas fa-save mr-2"></i> SIMPAN PRODUK KE DATABASE
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</x-app-layout>