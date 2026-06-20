<x-app-layout>
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black tracking-tight"><i class="fas fa-circle-question"></i> Panduan Memesan</h1>
                <p class="mt-2 text-blue-100 text-sm">Ikuti langkah-langkah berikut untuk memesan produk percetakan dengan mudah.</p>
            </div>
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white text-sm font-semibold px-5 py-2.5 rounded-2xl transition">
                <i class="fas fa-arrow-left"></i> Kembali ke Katalog
            </a>
        </div>
    </div>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- LANGKAH MEMESAN --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <h2 class="text-lg font-black text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-list-ol text-cyan-500"></i> Langkah-Langkah Memesan
                </h2>
                <div class="space-y-5">
                    @foreach([
                        ['icon' => 'fas fa-th-large', 'color' => 'bg-blue-50 text-blue-500', 'title' => 'Pilih Produk',
                            'desc' => 'Buka halaman Katalog dan pilih produk percetakan yang ingin Anda pesan seperti Spanduk, Brosur, Stiker, atau Kartu Nama.'],
                        ['icon' => 'fas fa-ruler-combined', 'color' => 'bg-cyan-50 text-cyan-500', 'title' => 'Isi Ukuran / Jumlah',
                            'desc' => 'Masukkan ukuran cetak (panjang x lebar dalam meter) untuk Spanduk/Stiker, atau jumlah lembar/box untuk produk lainnya.'],
                        ['icon' => 'fas fa-file-upload', 'color' => 'bg-purple-50 text-purple-500', 'title' => 'Upload File Desain (Opsional)',
                            'desc' => 'Upload file desain Anda dalam format JPG, PNG, PDF, atau TIFF. Jika belum memiliki desain, Tuliskan konsep atau ide Anda di kolom catatan, tim desainer kami siap membantu membuatkan desain sesuai keinginan Anda.'],                        ['icon' => 'fas fa-sticky-note', 'color' => 'bg-amber-50 text-amber-500', 'title' => 'Tambahkan Catatan', 'desc' => 'Tambahkan catatan khusus jika diperlukan, seperti finishing (laminasi, mata ayam, dll) atau instruksi pemotongan.'],
                        ['icon' => 'fas fa-paper-plane', 'color' => 'bg-emerald-50 text-emerald-500', 'title' => 'Konfirmasi Pesanan',
                            'desc' => 'Klik tombol Konfirmasi Pesanan. Tim kami akan segera memproses pesanan Anda dan mengubah status menjadi Diproses.'],
                        ['icon' => 'fas fa-box', 'color' => 'bg-indigo-50 text-indigo-500', 'title' => 'Ambil Pesanan',
                            'desc' => 'Setelah status berubah menjadi Selesai Cetak, Anda bisa datang ke workshop kami untuk mengambil pesanan dan melakukan pembayaran.'],
                    ] as $i => $step)
                    <div class="flex items-start gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 {{ $step['color'] }} rounded-2xl flex items-center justify-center shrink-0">
                                <i class="{{ $step['icon'] }} text-sm"></i>
                            </div>
                            @if($i < 5)
                            <div class="w-0.5 h-5 bg-gray-100 mt-1"></div>
                            @endif
                        </div>
                        <div class="pt-1.5">
                            <p class="font-bold text-gray-800 text-sm">{{ $i + 1 }}. {{ $step['title'] }}</p>
                            <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-100 p-4 rounded-2xl mb-4 flex items-start gap-3">
                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fas fa-lightbulb text-xs"></i>
                </div>
                <div>
                    <p class="font-bold text-blue-800 text-sm">Belum punya file desain?</p>
                    <p class="text-xs text-blue-600 mt-0.5 leading-relaxed">
                        Tidak perlu khawatir! Anda bisa langsung memesan dan tuliskan konsep desain yang Anda inginkan di kolom catatan — misalnya warna, teks, gambar, atau referensi yang diinginkan. Tim kami akan menghubungi Anda via WhatsApp untuk mendiskusikan desainnya lebih lanjut.
                    </p>
                </div>
            </div>

            {{-- FORMAT FILE --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <h2 class="text-lg font-black text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-file-alt text-cyan-500"></i> Ketentuan File Desain
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Format File Diterima</p>
                        <div class="space-y-2">
                            @foreach(['PDF', 'JPG / JPEG', 'PNG', 'TIFF'] as $format)
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-emerald-500 text-xs"></i>
                                {{ $format }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Ketentuan File</p>
                        <div class="space-y-2">
                            @foreach(['Ukuran file maksimal 20 MB', 'Resolusi minimal 72 DPI', 'Warna mode CMYK lebih baik', 'Sertakan bleed area jika ada'] as $ketentuan)
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-info-circle text-blue-500 text-xs"></i>
                                {{ $ketentuan }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- PEMBAYARAN --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <h2 class="text-lg font-black text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-wallet text-cyan-500"></i> Informasi Pembayaran
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-amber-50 border border-amber-100 p-5 rounded-2xl flex items-start gap-3">
                        <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">Tunai</p>
                            <p class="text-xs text-gray-500 mt-1">Pembayaran dilakukan langsung saat pengambilan pesanan di workshop kami.</p>
                        </div>
                    </div>
                    <div class="bg-purple-50 border border-purple-100 p-5 rounded-2xl flex items-start gap-3">
                        <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fas fa-university"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">Transfer Bank</p>
                            <p class="text-xs text-gray-500 mt-1">Transfer ke rekening CV Salam Indah dan konfirmasi via WhatsApp sebelum pengambilan.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BUTUH BANTUAN --}}
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-3xl p-8 text-white text-center">
                <i class="fab fa-whatsapp text-4xl mb-3 block"></i>
                <h2 class="text-lg font-black mb-2">Masih Ada Pertanyaan?</h2>
                <p class="text-sm text-green-100 mb-5">Hubungi kami via WhatsApp, kami siap membantu Anda!</p>
                <a href="https://wa.me/6282189346164?text=Halo%20Salam%20Indah%2C%20saya%20ingin%20bertanya%20mengenai%20cara%20memesan"
                    target="_blank"
                    class="inline-flex items-center gap-2 bg-white text-green-600 font-bold px-6 py-3 rounded-2xl hover:bg-green-50 transition text-sm">
                    <i class="fab fa-whatsapp"></i> Chat WhatsApp Sekarang
                </a>
            </div>

        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</x-app-layout>