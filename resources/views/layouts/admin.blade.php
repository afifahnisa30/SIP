<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIP- Salam Indah Post</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Icon -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100 font-sans">
    <div class="flex min-h-screen">
        <!-- SIDEBAR -->
        <aside id="sidebar"
        class="fixed left-0 top-0 h-screen w-64 bg-slate-900 text-white flex flex-col justify-between transition-all duration-300 ease-in-out">
            <!-- Logo -->
            <div class="h-20 flex items-center px-6 border-b border-slate-800 cursor-pointer" id="logoContainer">
                <img src="{{ asset('assets/img/logo.png') }}"
                    class="w-11 h-11 bg-white rounded-xl p-1 object-contain">
                <div class="ml-3 menu-text transition-all duration-300">
                    <h1 class="text-lg font-semibold tracking-wide">Salam Indah</h1>
                    <p class="text-xs text-slate-400">Admin Panel</p>
                </div>
            </div>

            <!-- MENU -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-cyan-600 text-white shadow-lg'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span class="menu-text">Dashboard</span>
                </a>

                <div x-data="{ openMaster: false }">
                    <button
                        id="masterMenuBtn"
                        @click="openMaster = !openMaster"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-slate-300 hover:bg-slate-800 hover:text-white">
                        <div class="flex items-center gap-3">
                            <i data-lucide="database" class="w-5 h-5"></i>
                            <span class="menu-text">Master Data</span>
                        </div>
                        <i data-lucide="chevron-right"
                            class="w-4 h-4 transition-transform duration-300 menu-text"
                            :class="{ 'rotate-90': openMaster }">
                        </i>
                    </button>
                    <div x-show="openMaster" x-transition class="submenu ml-6 mt-2 space-y-2">
                        <a href="{{ route('product.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                            {{ request()->routeIs('product.*')
                                ? 'bg-cyan-600 text-white'
                                : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                            <span class="w-2 h-2 rounded-full bg-current"></span>
                            <span>Produk</span>
                        </a>
                        <a href="{{ route('category.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                            {{ request()->routeIs('category.*')
                                ? 'bg-cyan-600 text-white'
                                : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <span class="w-2 h-2 rounded-full bg-current"></span>
                            <span>Variasi Produk</span>
                        </a>
                    </div>
                </div>

                <div x-data="{ openTransaksi: false }">
                    <button
                        id="transaksiMenuBtn"
                        @click="openTransaksi = !openTransaksi"
                        class="w-full flex items-center justify-between px-4 py-3 text-slate-300 hover:bg-slate-800 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                            <span class="menu-text">Transaksi</span>
                        </div>
                        <i data-lucide="chevron-right"
                            class="w-4 h-4 transition-transform duration-300 menu-text"
                            :class="{ 'rotate-90': openTransaksi }">
                        </i>
                    </button>
                    <div x-show="openTransaksi" x-transition class="submenu ml-6 mt-2">
                        <a href="{{ route('orders.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                            {{ request()->routeIs('orders.index')
                                ? 'bg-cyan-600 text-white'
                                : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <span class="w-2 h-2 rounded-full bg-current"></span>
                            <span>Daftar Pesanan</span>
                        </a>
                        <a href="{{ route('orders.riwayat') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                            {{ request()->routeIs('orders.riwayat')
                                ? 'bg-cyan-600 text-white'
                                : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <span class="w-2 h-2 rounded-full bg-current"></span>
                            <span>Riwayat Transaksi</span>
                        </a>
                        <a href="{{ route('pengeluaran.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                            {{ request()->routeIs('pengeluaran.*')
                                ? 'bg-cyan-600 text-white'
                                : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <span class="w-2 h-2 rounded-full bg-current"></span>
                            <span>Pengeluaran</span>
                        </a>
                    </div>
                </div>

                <div x-data="{ openLaporan: false }">
                    <button
                        id="laporanMenuBtn"
                        @click="openLaporan = !openLaporan"
                        class="w-full flex items-center justify-between px-4 py-3 text-slate-300 hover:bg-slate-800 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                            <span class="menu-text">Laporan</span>
                        </div>
                        <i data-lucide="chevron-right"
                            class="w-4 h-4 transition-transform duration-300 menu-text"
                            :class="{ 'rotate-90': openLaporan }">
                        </i>
                    </button>
                    <div x-show="openLaporan" x-transition class="submenu ml-6 mt-2">
                        <a href="#"
                            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-slate-400 hover:bg-slate-800 hover:text-white">
                            <span class="w-2 h-2 rounded-full bg-current"></span>
                            <span>Laporan Harian</span>
                        </a>
                        <a href="#"
                            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-slate-400 hover:bg-slate-800 hover:text-white">
                            <span class="w-2 h-2 rounded-full bg-current"></span>
                            <span>Laporan Periode</span>
                        </a>
                    </div>
                </div>

                <div x-data="{ openData: false }">
                    <button
                        id="dataMenuBtn"
                        @click="openData = !openData"
                        class="w-full flex items-center justify-between px-4 py-3 text-slate-300 hover:bg-slate-800 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <i data-lucide="Users" class="w-5 h-5"></i>
                            <span class="menu-text">Data Pengguna</span>
                        </div>
                        <i data-lucide="chevron-right"
                            class="w-4 h-4 transition-transform duration-300 menu-text"
                            :class="{ 'rotate-90': openData }">
                        </i>
                    </button>
                    <div x-show="openData" x-transition class="submenu ml-6 mt-2">
                        <a href="#"
                            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-slate-400 hover:bg-slate-800 hover:text-white">
                            <span class="w-2 h-2 rounded-full bg-current"></span>
                            <span>Pelanggan</span>
                        </a>
                        <a href="#"
                            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-slate-400 hover:bg-slate-800 hover:text-white">
                            <span class="w-2 h-2 rounded-full bg-current"></span>
                            <span>Admin</span>
                        </a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- MAIN -->
        <main id="mainContent" class="flex-1 flex flex-col ml-64 bg-slate-100 transition-all duration-300">
            <!-- NAVBAR -->
            <header class="h-20 bg-gradient-to-r from-cyan-600 to-blue-700 shadow-md px-6 flex items-center justify-between text-white">
                <!-- Pindahkan tombol toggle ke sini -->
                <div class="flex items-center gap-4">
                    <button id="toggleSidebar" class="w-11 h-11 rounded-xl hover:bg-white/20 flex items-center justify-center transition">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <h2 class="font-semibold text-lg">
                            Halo, {{ Auth::user()->name }} 👋
                        </h2>
                        <p class="text-xs text-blue-100">
                            Kelola produk, pesanan, dan laporan percetakan CV Salam Indah
                        </p>
                    </div>
                </div>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium hover:text-blue-100 transition">
                        <span>Admin</span>
                        <i class="fas fa-chevron-down text-[10px]"></i>
                    </button>
                <!-- Dropdown menu tetap sama seperti sebelumnya -->
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-3 w-48 bg-white text-gray-700 rounded-2xl shadow-xl py-2 z-50">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm hover:bg-slate-50">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-slate-50">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- CONTENT -->
            <section class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </section>
        </main>
    </div>

<script>
    lucide.createIcons();

    const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const menuTexts = document.querySelectorAll('.menu-text');
    const subMenus = document.querySelectorAll('.submenu');

    let sidebarCollapsed = false;

    toggleSidebar.addEventListener('click', () => {
        sidebarCollapsed = !sidebarCollapsed;
        sidebar.classList.toggle('w-64');
        sidebar.classList.toggle('w-20');
        mainContent.classList.toggle('ml-64');
        mainContent.classList.toggle('ml-20');
        menuTexts.forEach(text => {
            text.classList.toggle('hidden');
        });

        if (sidebarCollapsed) {
            subMenus.forEach(menu => {
                menu.classList.add('hidden');
            });
        } else {
            subMenus.forEach(menu => {
                menu.classList.remove('hidden');
            });
        }

    });
</script>
 @stack('scripts')
</body>
</html>