<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;

// Rute Home
Route::get('/', function () { return view('welcome'); });

// RUTE CUSTOMER (User Biasa)
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        $products = Product::all();
        $activeOrders = Order::where('user_id', Auth::id())
                            ->whereIn('status', ['Pending', 'Diproses'])
                            ->count();
        $completedOrders = Order::where('user_id', Auth::id())
                            ->where('diambil', true)
                            ->count();
        return view('dashboard', compact('products', 'activeOrders', 'completedOrders'));
    })->name('dashboard');

    // Customer hanya bisa store order
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
    Route::get('/my-orders/{id}', [OrderController::class, 'detailOrder'])->name('orders.my.show');
    Route::get('/riwayat', [OrderController::class, 'riwayatCustomer'])->name('orders.riwayat.customer');
    Route::get('/tagihan', [OrderController::class, 'tagihan'])->name('orders.tagihan');
    Route::get('/panduan', function () {return view('customer.panduan'); })->name('panduan');
    Route::get('/profil/customer', [ProfilController::class, 'customerProfile'])->name('customer.profile');
    Route::get('/profil', [ProfilController::class, 'customerProfile'])->name('customer.profil.show');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('customer.profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('customer.profil.password');
    
    });

// RUTE ADMIN
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'admin'])
    ->prefix('admin')
    ->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // CRUD Produk
    Route::resource('product', ProductController::class);
    //Riwayat Pesanan
    Route::get('/orders/riwayat', [OrderController::class, 'riwayat'])->name('orders.riwayat');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders/store-admin', [OrderController::class, 'storeAdmin'])->name('orders.storeAdmin');
    Route::get('/piutang', [OrderController::class, 'piutang'])->name('orders.piutang');
    // Admin kelola pesanan (Daftar, Hapus, Show, Edit, dll)
    Route::resource('orders', OrderController::class)->except(['store']);
    //kategori
    Route::resource('category', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
    //pengeluaran
    Route::resource('pengeluaran', PengeluaranController::class)->only(['index', 'store', 'update', 'destroy']);
    //laporan
    Route::get('/laporan/harian', [LaporanController::class, 'harian'])->name('laporan.harian');
    Route::get('/laporan/periode', [LaporanController::class, 'periode'])->name('laporan.periode');
    Route::get('/laporan/periode/excel', [LaporanController::class, 'periodeExcel'])->name('laporan.periode.excel');
    //data pengguna
    Route::get('/data/pelanggan', [DataController::class, 'pelanggan'])->name('data.pelanggan');
    Route::get('/data/admin', [DataController::class, 'admin'])->name('data.admin');
    Route::post('/data/admin/tambah', [DataController::class, 'tambahAdmin'])->name('data.tambahAdmin');
    Route::get('/data/{id}/edit', [DataController::class, 'edit'])->name('data.edit');
    Route::put('/data/{id}', [DataController::class, 'update'])->name('data.update');
    Route::delete('/data/{id}', [DataController::class, 'destroy'])->name('data.destroy');

    Route::get('/profil', [ProfilController::class, 'adminProfile'])->name('admin.profile');
    Route::get('/profil', [ProfilController::class, 'adminProfile'])->name('admin.profil.show');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('admin.profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('admin.profil.password');
    });