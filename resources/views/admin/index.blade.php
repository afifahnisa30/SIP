<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500 text-white rounded-2xl shadow-md font-medium flex items-center gap-2 animate-pulse">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-gray-100 gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-black text-gray-800">Panel Utama Admin 🛠️</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola data produk, orderan masuk, dan laporan penjualan CV Salam Indah.</p>
                </div>
                <a href="{{ route('product.create') }}" class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold py-3 px-6 rounded-full shadow-lg shadow-blue-500/20 hover:opacity-90 transition duration-200 text-sm flex items-center gap-2">
                    <i class="fas fa-plus"></i> TAMBAH PRODUK BARU
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="p-4 bg-amber-100 text-amber-600 rounded-2xl text-2xl"><i class="fas fa-clock"></i></div>
                    <div>
                        <span class="block text-2xl font-black text-gray-800">0</span>
                        <span class="text-xs text-gray-400 font-medium">Orderan Menunggu</span>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="p-4 bg-blue-100 text-blue-600 rounded-2xl text-2xl"><i class="fas fa-spinner"></i></div>
                    <div>
                        <span class="block text-2xl font-black text-gray-800">0</span>
                        <span class="text-xs text-gray-400 font-medium">Sedang Diproses</span>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="p-4 bg-emerald-100 text-emerald-600 rounded-2xl text-2xl"><i class="fas fa-wallet"></i></div>
                    <div>
                        <span class="block text-2xl font-black text-gray-800">Rp 0</span>
                        <span class="text-xs text-gray-400 font-medium">Pendapatan Bulan Ini</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm text-center py-12">
                <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                <p class="text-gray-500 font-medium">Belum ada aktivitas pesanan masuk hari ini.</p>
            </div>

        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</x-app-layout>