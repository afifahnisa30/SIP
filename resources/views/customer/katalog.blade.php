<x-app-layout>
    <div class="bg-slate-50 min-h-screen pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <div class="mb-6">
                <h2 class="text-2xl font-black text-gray-800">Katalog Produk</h2>
                <p class="text-sm text-gray-400 mt-0.5">Semua produk percetakan CV Salam Indah</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-6">

                {{-- SIDEBAR KATEGORI --}}
                <div class="lg:w-64 shrink-0">
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5 sticky top-4">
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Kategori</h3>
                        <div class="space-y-1">
                            <a href="{{ route('katalog') }}"
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition
                                {{ !request('kategori') ? 'bg-blue-600 text-white font-semibold' : 'text-gray-600 hover:bg-slate-50' }}">
                                <i class="fas fa-th text-xs"></i>
                                <span>Semua Produk</span>
                            </a>
                            @foreach($categories as $cat)
                            <a href="{{ route('katalog', ['kategori' => $cat->nama]) }}"
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition
                                {{ request('kategori') == $cat->nama ? 'bg-blue-600 text-white font-semibold' : 'text-gray-600 hover:bg-slate-50' }}">
                                <i class="fas fa-print text-xs"></i>
                                <span>{{ $cat->nama }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- KONTEN UTAMA --}}
                <div class="flex-1">
                    {{-- Search --}}
                    <form method="GET" action="{{ route('katalog') }}" class="mb-6">
                        @if(request('kategori'))
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                        @endif
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari produk percetakan..."
                                class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-2xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm transition">
                        </div>
                    </form>

                    {{-- Grid Produk --}}
                    <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                        @forelse($products as $product)
                        <div class="bg-white rounded-3xl overflow-hidden flex flex-col group shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100"
                            data-title="{{ strtolower($product->nama . ' ' . $product->kategori) }}">
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="{{ $product->image ? asset($product->image) : 'https://placehold.co/600x400?text=' . urlencode($product->nama) }}"
                                    alt="{{ $product->nama }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-3 right-3 px-3 py-1 text-xs font-bold text-white rounded-full bg-cyan-500">
                                    {{ $product->kategori }}
                                </div>
                            </div>
                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="font-bold text-gray-800 mb-1 group-hover:text-blue-600 transition-colors">
                                    {{ $product->nama }}
                                </h3>
                                <p class="text-xs text-slate-500 mb-3 flex items-center gap-1">
                                    <i class="fas fa-info-circle text-cyan-500"></i>
                                    {{ Str::limit($product->deskripsi, 45, '...') ?? 'Kualitas cetak premium' }}
                                </p>
                                <p class="text-sm font-black text-blue-600 mb-4">
                                    @if(Auth::user()->tipe === 'Reseller' && $product->harga_reseller)
                                        Rp {{ number_format($product->harga_reseller, 0, ',', '.') }}
                                    @else
                                        Rp {{ number_format($product->harga_dasar, 0, ',', '.') }}
                                    @endif
                                    <span class="text-xs font-normal text-gray-400">
                                        {{ in_array($product->kategori, ['Spanduk', 'Stiker']) ? '/ m²' : '/ pcs' }}
                                    </span>
                                </p>
                                <div class="mt-auto">
                                    <button type="button"
                                        onclick="openOrderModal({{ json_encode($product) }})"
                                        class="block w-full text-center bg-gradient-to-r from-cyan-400 to-blue-500 text-white font-bold py-2.5 rounded-full hover:opacity-90 transition text-xs">
                                        <i class="fas fa-shopping-cart mr-1"></i> Pesan Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-gray-100">
                            <i class="fas fa-box-open fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-500 font-semibold">Tidak ada produk ditemukan</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Pemesanan --}}
    <div id="orderModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden border border-gray-100">
            
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white flex justify-between items-center">
                <div>
                    <h3 id="modalProductName" class="text-lg font-black">Form Pemesanan</h3>
                    <p id="modalProductCategory" class="text-xs text-blue-200 mt-0.5">Kategori: -</p>
                </div>
                <button type="button" onclick="closeOrderModal()" class="text-white/80 hover:text-white text-xl p-2">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{route('orders.store')}}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <input type="hidden" id="productId" name="product_id">
                <input type="hidden" id="productHargaDasar">
                <input type="hidden" id="productUkuranStandar">

                <div id="groupMeteran" class="grid grid-cols-2 gap-4 hidden">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Panjang Cetak (Meter)</label>
                        <input type="number" step="0.1" id="inputPanjang" name="panjang" placeholder="Contoh: 2.5"
                            class="w-full py-2.5 px-4 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Lebar Cetak (Meter)</label>
                        <input type="number" step="0.1" id="inputLebar" name="lebar" placeholder="Contoh: 1.2"
                            class="w-full py-2.5 px-4 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                <div id="groupQuantity" class="hidden">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Jumlah Pesanan (Pcs/Box/Lembar)</label>
                    <input type="number" id="inputQty" name="quantity" min="1" value="1"
                        class="w-full py-2.5 px-4 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Upload File Desain Anda</label>
                    <input type="file" name="file_desain" required
                        class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Catatan Finishing / Cetak</label>
                    <textarea name="catatan" rows="2" placeholder="Contoh: Ring mata ayam tiap sudut, potong pas pola..."
                        class="w-full py-2 px-4 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
                </div>

                <div class="bg-slate-50 p-4 rounded-2xl border border-gray-100 space-y-1.5 text-xs text-gray-600">
                    <div class="flex justify-between">
                        <span>Harga Dasar:</span>
                        <span id="txtHargaDasar" class="font-bold text-gray-800">Rp 0</span>
                    </div>
                    <div id="rowPerhitungan" class="flex justify-between hidden">
                        <span>Ukuran Pembulatan Mesin:</span>
                        <span id="txtDetailHitung" class="font-bold text-cyan-600">0m x 0m = 0 m²</span>
                    </div>
                    <hr class="border-gray-200 my-1">
                    <div class="flex justify-between text-sm font-black text-gray-800">
                        <span>ESTIMASI TOTAL:</span>
                        <span id="txtTotalHarga" class="text-blue-600 text-base">Rp 0</span>
                    </div>
                </div>

                <div class="pt-2 flex gap-3">
                    <button type="button" onclick="closeOrderModal()" class="w-1/3 border border-gray-200 font-bold py-2.5 rounded-full text-xs text-gray-500 hover:bg-gray-50">
                        BATAL
                    </button>
                    <button type="submit" class="w-2/3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold py-2.5 rounded-full shadow-lg hover:opacity-90 active:scale-[0.99] transition text-xs tracking-wide">
                        KONFIRMASI PESANAN
                    </button>
                </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <script>
        const modal = document.getElementById('orderModal');
        const groupMeteran = document.getElementById('groupMeteran');
        const groupQuantity = document.getElementById('groupQuantity');
        const rowPerhitungan = document.getElementById('rowPerhitungan');

        function openOrderModal(product) {
            modal.classList.remove('hidden');
            document.getElementById('modalProductName').innerText = "Pesan: " + product.nama;
            document.getElementById('modalProductCategory').innerText = "Kategori: " + product.kategori;
            document.getElementById('productId').value = product.id;

            const isReseller = {{ Auth::user()->tipe === 'Reseller' ? 'true' : 'false' }};
            const harga = (isReseller && product.harga_reseller) ? product.harga_reseller : product.harga_dasar;

            document.getElementById('productHargaDasar').value = harga;
            document.getElementById('productUkuranStandar').value = product.ukuran_standar || "";
            document.getElementById('txtHargaDasar').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(harga);
            document.getElementById('inputPanjang').value = "";
            document.getElementById('inputLebar').value = "";
            document.getElementById('inputQty').value = 1;

            if (product.kategori === 'Spanduk' || product.kategori === 'Stiker') {
                groupMeteran.classList.remove('hidden');
                rowPerhitungan.classList.remove('hidden');
                groupQuantity.classList.add('hidden');
                document.getElementById('inputPanjang').addEventListener('input', hitungHarga);
                document.getElementById('inputLebar').addEventListener('input', hitungHarga);
            } else {
                groupMeteran.classList.add('hidden');
                rowPerhitungan.classList.add('hidden');
                groupQuantity.classList.remove('hidden');
                document.getElementById('inputQty').addEventListener('input', hitungHarga);
            }
            hitungHarga();
        }

        function closeOrderModal() {
            modal.classList.add('hidden');
        }

        function hitungHarga() {
            const categoryText = document.getElementById('modalProductCategory').innerText;
            const hargaDasar = parseInt(document.getElementById('productHargaDasar').value) || 0;
            let totalHarga = 0;

            if (categoryText.includes('Spanduk') || categoryText.includes('Stiker')) {
                let p = parseFloat(document.getElementById('inputPanjang').value) || 0;
                let l = parseFloat(document.getElementById('inputLebar').value) || 0;
                let strUkuran = document.getElementById('productUkuranStandar').value;
                let bahanStandar = strUkuran ? strUkuran.split(',').map(Number).sort((a,b) => a-b) : [1, 1.5, 2, 3];
                let lFinal = l;
                if (p > 0 && l > 0) {
                    let found = bahanStandar.find(size => size >= l);
                    if (found) lFinal = found;
                }
                totalHarga = p * lFinal * hargaDasar;
                document.getElementById('txtDetailHitung').innerText = p + "m x " + lFinal + "m = " + (p * lFinal).toFixed(2) + " m²";
            } else {
                let qty = parseInt(document.getElementById('inputQty').value) || 1;
                totalHarga = qty * hargaDasar;
            }

            let totalBulat = Math.ceil(totalHarga / 5000) * 5000;
            document.getElementById('txtTotalHarga').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(totalBulat);
        }
    </script>
</x-app-layout>