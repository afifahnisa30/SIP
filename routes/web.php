<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PengeluaranController;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;

// Rute Home
Route::get('/', function () { return view('welcome'); });

// ==========================================
// RUTE CUSTOMER (User Biasa)
// ==========================================
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
    });

// ==========================================
// RUTE ADMIN
// ==========================================
// Pastikan middleware 'admin' sudah didaftarkan di Kernel.php atau bootstrap/app.php
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'admin'])
    ->prefix('admin')
    ->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // CRUD Produk
    Route::resource('product', ProductController::class);
    //Riwayat Pesanan
    Route::get('/orders/riwayat', [OrderController::class, 'riwayat'])->name('orders.riwayat');
    // Admin kelola pesanan (Daftar, Hapus, Show, Edit, dll)
    Route::resource('orders', OrderController::class)->except(['store']);
    //kategori
    Route::resource('category', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
    //pengeluaran
    Route::resource('pengeluaran', PengeluaranController::class)->only(['index', 'store', 'update', 'destroy']);

    });