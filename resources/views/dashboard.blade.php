<x-app-layout>
    <div class="bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            
            {{-- Kiri: Greeting --}}
            <div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight drop-shadow-sm">
                    Halo, {{ Auth::user()->name }}
                </h1>
                <p class="mt-2 text-blue-100 max-w-xl text-sm sm:text-base">
                    Selamat datang di panel pemesanan resmi 
                    <span class="font-bold underline decoration-cyan-300 underline-offset-4">Percetakan Salam Indah</span>. 
                    Silakan pilih produk percetakan yang ingin Anda pesan.
                </p>
            </div>

            {{-- Kanan: Stat Cards --}}
            <div class="flex gap-4 shrink-0">
                {{-- Card Pesanan Aktif --}}
                <div class="bg-white/10 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/20 shadow-lg flex items-center gap-3 min-w-[150px] hover:bg-white/20 transition duration-200 cursor-pointer">
                    <div class="w-10 h-10 bg-amber-400/30 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-clock text-amber-300 text-sm"></i>
                    </div>
                    <div class="text-left">
                        <span class="block text-2xl font-black">{{ $activeOrders }}</span>
                        <span class="text-[11px] text-blue-100 font-medium leading-tight">Pesanan Aktif</span>
                    </div>
                </div>

                {{-- Card Total Selesai --}}
                <div class="bg-white/10 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/20 shadow-lg flex items-center gap-3 min-w-[150px] hover:bg-white/20 transition duration-200 cursor-pointer">        <div class="w-10 h-10 bg-emerald-400/30 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-check-circle text-emerald-300 text-sm"></i>
                    </div>
                    <div class="text-left">
                        <span class="block text-2xl font-black">{{ $completedOrders }}</span>
                        <span class="text-[11px] text-blue-100 font-medium leading-tight">Total Selesai</span>
                    </div>
                </div>

            </div>
            
        </div>
    </div>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500 text-white rounded-2xl shadow-md font-medium flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <header class="mb-10">
                <h2 class="text-2xl font-extrabold text-gray-800 text-center sm:text-left">Katalog Produk Percetakan</h2>
                <p class="text-sm text-gray-500 mt-1 text-center sm:text-left">Cari produk spanduk, brosur, stiker, atau kebutuhan cetak digital lainnya di bawah ini.</p>
                
                <div class="mt-6 max-w-2xl">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <i class="fas fa-search text-gray-400"></i>
                        </span>
                        <input type="search" id="searchInput" placeholder="Ketik nama produk (misal: Spanduk, Kartu Nama, Stiker)..."
                            class="w-full py-3 pl-12 pr-4 text-gray-700 bg-white border border-gray-200 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                    </div>
                </div>
            </header>

            <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @if($products->count() > 0)
                    @foreach($products as $product)
                    <div class="product-card bg-white rounded-3xl overflow-hidden flex flex-col group shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-gray-100" 
                        data-title="{{ strtolower($product->nama . ' ' . $product->kategori) }}">
                        
                        <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                            <img src="{{ $product->image ? asset($product->image) : 'https://placehold.co/600400?text=' . urlencode($product->nama) }}" 
                                alt="{{ $product->nama }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            <div class="absolute top-3 right-3 px-3 py-1 text-xs font-bold text-white rounded-full shadow-md bg-cyan-500 flex items-center gap-1.5">
                                <i class="fas fa-tags"></i>
                                <span>{{ $product->kategori }}</span>
                            </div>
                        </div>

                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-gray-800 leading-tight mb-1 group-hover:text-blue-600 transition-colors">
                                {{ $product->nama }}
                            </h3>
                            
                            <p class="text-xs text-slate-500 mb-3 flex items-center gap-2">
                                <i class="fas fa-info-circle text-cyan-500"></i>
                                <span>{{ Str::limit($product->deskripsi, 45, '...') ?? 'Kualitas cetak premium' }}</span>
                            </p>
                            
                            <p class="text-sm font-black text-blue-600 mb-4">
                                Mulai Rp {{ number_format($product->harga_dasar, 0, ',', '.') }} 
                                <span class="text-xs font-normal text-gray-400">
                                    {{ in_array($product->kategori, ['Spanduk', 'Stiker']) ? '/ meter²' : '/ lembar-box' }}
                                </span>
                            </p>

                            <hr class="border-gray-100 my-2">

                            <div class="mt-auto pt-2">
                                <button type="button" 
                                    onclick="openOrderModal({{ json_encode($product) }})"
                                    class="block w-full text-center bg-gradient-to-r from-cyan-400 to-blue-500 text-white font-bold py-2.5 rounded-full shadow-md shadow-blue-500/10 hover:opacity-90 active:scale-[0.98] transition duration-200 tracking-wide text-xs sm:text-sm">
                                    <i class="fas fa-shopping-cart mr-2"></i> PESAN SEKARANG
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-12 bg-white rounded-3xl border border-gray-100 shadow-sm">
                        <i class="fas fa-box-open fa-3x text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium">Belum ada produk yang tersedia di katalog saat ini.</p>
                    </div>
                @endif
            </div>

            <div id="noResultsMessage" class="hidden text-center text-gray-500 mt-16">
                <i class="fas fa-search fa-3x text-gray-300 mb-3"></i>
                <p class="text-lg font-semibold">Produk percetakan tidak ditemukan.</p>
                <p class="text-sm text-gray-400">Coba kata kunci lain seperti 'spanduk', 'stiker', atau 'kartu'.</p>
            </div>
        </div>
    </div>

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
        document.addEventListener('DOMContentLoaded', () => {
            // JS SEARCH ASLI MILIKMU
            const searchInput = document.getElementById('searchInput');
            const productCards = document.querySelectorAll('.product-card');
            const noResultsMessage = document.getElementById('noResultsMessage');

            searchInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase().trim();
                let hasResults = false;

                productCards.forEach(card => {
                    const titleData = card.getAttribute('data-title');
                    const isMatch = titleData.includes(searchTerm);
                    
                    if (isMatch) {
                        card.style.display = 'flex';
                        hasResults = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (hasResults) {
                    noResultsMessage.classList.add('hidden');
                } else {
                    noResultsMessage.classList.remove('hidden');
                }
            });
        });

        // JAVASCRIPT MODAL & KALKULATOR MATANG
        const modal = document.getElementById('orderModal');
        const groupMeteran = document.getElementById('groupMeteran');
        const groupQuantity = document.getElementById('groupQuantity');
        const rowPerhitungan = document.getElementById('rowPerhitungan');

        function openOrderModal(product) {
            modal.classList.remove('hidden');
            
            document.getElementById('modalProductName').innerText = "Pesan: " + product.nama;
            document.getElementById('modalProductCategory').innerText = "Kategori: " + product.kategori;
            
            document.getElementById('productId').value = product.id;
            document.getElementById('productHargaDasar').value = product.harga_dasar;
            document.getElementById('productUkuranStandar').value = product.ukuran_standar || "";

            document.getElementById('txtHargaDasar').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(product.harga_dasar);

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
                let pCustomer = parseFloat(document.getElementById('inputPanjang').value) || 0;
                let lCustomer = parseFloat(document.getElementById('inputLebar').value) || 0;

                let strUkuran = document.getElementById('productUkuranStandar').value;
                // Mengurai data '1,1.5,2,3' dari database menjadi array angka
                let bahanStandar = strUkuran ? strUkuran.split(',').map(Number).sort((a,b) => a-b) : [1, 1.5, 2, 3];

                let pFinal = pCustomer;
                let lFinal = lCustomer;

                if (pCustomer > 0 && lCustomer > 0) {
                    // Algoritma pembulatan lebar mesin otomatis
                    let lebarTerpilih = bahanStandar.find(size => size >= lCustomer);
                    if (lebarTerpilih) {
                        lFinal = lebarTerpilih;
                    }
                }

                let luasMeterPersegi = pFinal * lFinal;
                totalHarga = luasMeterPersegi * hargaDasar;

                document.getElementById('txtDetailHitung').innerText = pFinal + "m x " + lFinal + "m = " + luasMeterPersegi.toFixed(2) + " m²";
            } else {
                let qty = parseInt(document.getElementById('inputQty').value) || 1;
                totalHarga = qty * hargaDasar;
            }

            // Menggunakan rumus kelipatan 5000 ke atas
            let totalDibulatkan = Math.ceil(totalHarga / 5000) * 5000;
            document.getElementById('txtTotalHarga').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(totalDibulatkan);
        }
    </script>
</x-app-layout>