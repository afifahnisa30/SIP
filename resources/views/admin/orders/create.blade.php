@extends('layouts.admin')

@section('content')

<div class="mb-6">
    <a href="{{ route('orders.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-2 transition">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
    </a>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-black text-gray-800 mb-1">Tambah Pesanan Offline</h2>
        <p class="text-xs text-gray-400 mb-6">Input pesanan untuk pelanggan yang datang langsung</p>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 text-red-600 border border-red-200 rounded-2xl text-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('orders.storeAdmin') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Info Pelanggan --}}
            <div class="bg-slate-50 p-4 rounded-2xl space-y-4">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Info Pelanggan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" placeholder="Nama lengkap"
                            class="w-full py-2.5 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">No. Telepon</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp') }}" placeholder="Contoh: 08123456789"
                            class="w-full py-2.5 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                </div>
            </div>

            {{-- Detail Pesanan --}}
            <div class="bg-slate-50 p-4 rounded-2xl space-y-4">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Detail Pesanan</h3>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Produk</label>
                    <select name="product_id" id="productSelect" onchange="updateProduct(this)"
                        class="w-full py-2.5 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}"
                            data-kategori="{{ $product->kategori }}"
                            data-harga="{{ $product->harga_dasar }}"
                            data-ukuran="{{ $product->ukuran_standar }}"
                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->nama }} — Rp {{ number_format($product->harga_dasar, 0, ',', '.') }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Input Meteran --}}
                <div id="groupMeteran" class="grid grid-cols-2 gap-4 hidden">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Panjang (Meter)</label>
                        <input type="number" step="0.1" name="panjang" id="inputPanjang" value="{{ old('panjang') }}" placeholder="Contoh: 2.5"
                            class="w-full py-2.5 px-4 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Lebar (Meter)</label>
                        <input type="number" step="0.1" name="lebar" id="inputLebar" value="{{ old('lebar') }}" placeholder="Contoh: 1.5"
                            class="w-full py-2.5 px-4 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                {{-- Input Quantity --}}
                <div id="groupQuantity" class="hidden">
                    <label class="block text-xs font-bold text-gray-600 mb-1">Jumlah (Pcs/Lembar)</label>
                    <input type="number" name="quantity" id="inputQty" value="{{ old('quantity', 1) }}" min="1"
                        class="w-full py-2.5 px-4 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                {{-- Estimasi Harga --}}
                <div id="estimasiBox" class="hidden bg-white p-4 rounded-xl border border-gray-200 text-xs text-gray-600 space-y-1">
                    <div class="flex justify-between">
                        <span>Harga Dasar</span>
                        <span id="txtHargaDasar">Rp 0</span>
                    </div>
                    <hr class="border-gray-100">
                    <div class="flex justify-between text-sm font-black text-gray-800">
                        <span>Estimasi Total</span>
                        <span id="txtTotal" class="text-blue-600">Rp 0</span>
                    </div>
                </div>
            </div>

            {{-- File & Catatan --}}
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">File Desain <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="file" name="file_desain" accept=".pdf,.jpg,.png,.jpeg,.tiff"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Catatan</label>
                    <textarea name="catatan" rows="2" placeholder="Catatan tambahan..."
                        class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">{{ old('catatan') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Metode Pembayaran</label>
                    <select name="metode_bayar"
                        class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="Tunai" {{ old('metode_bayar') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="Transfer" {{ old('metode_bayar') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold py-3 rounded-xl hover:opacity-90 transition text-sm">
                <i class="fas fa-save mr-1"></i> Simpan Pesanan
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function updateProduct(select) {
        const option = select.options[select.selectedIndex];
        const kategori = option.dataset.kategori;
        const harga = parseInt(option.dataset.harga) || 0;
        const ukuran = option.dataset.ukuran || '';

        const groupMeteran = document.getElementById('groupMeteran');
        const groupQuantity = document.getElementById('groupQuantity');
        const estimasiBox = document.getElementById('estimasiBox');

        document.getElementById('txtHargaDasar').innerText = 'Rp ' + harga.toLocaleString('id-ID');
        estimasiBox.classList.remove('hidden');

        if (kategori === 'Spanduk' || kategori === 'Stiker') {
            groupMeteran.classList.remove('hidden');
            groupQuantity.classList.add('hidden');
            document.getElementById('inputPanjang').oninput = () => hitungHarga(harga, ukuran, kategori);
            document.getElementById('inputLebar').oninput = () => hitungHarga(harga, ukuran, kategori);
        } else {
            groupMeteran.classList.add('hidden');
            groupQuantity.classList.remove('hidden');
            document.getElementById('inputQty').oninput = () => hitungHarga(harga, ukuran, kategori);
        }

        hitungHarga(harga, ukuran, kategori);
    }

    function hitungHarga(harga, ukuran, kategori) {
        let total = 0;

        if (kategori === 'Spanduk' || kategori === 'Stiker') {
            const p = parseFloat(document.getElementById('inputPanjang').value) || 0;
            const l = parseFloat(document.getElementById('inputLebar').value) || 0;
            const bahanStandar = ukuran ? ukuran.split(',').map(Number).sort((a,b) => a-b) : [1, 1.5, 2, 3];
            let lFinal = l;
            if (p > 0 && l > 0) {
                const found = bahanStandar.find(s => s >= l);
                if (found) lFinal = found;
            }
            total = p * lFinal * harga;
        } else {
            const qty = parseInt(document.getElementById('inputQty').value) || 1;
            total = qty * harga;
        }

        const totalBulat = Math.ceil(total / 5000) * 5000;
        document.getElementById('txtTotal').innerText = 'Rp ' + totalBulat.toLocaleString('id-ID');
    }
</script>
@endpush