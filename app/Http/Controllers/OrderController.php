<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;   
use App\Models\Product;    
use Illuminate\Support\Facades\Auth; 

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'product'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->paginate(10)->appends(request()->query());

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function myOrders()
    {
        $orders = Order::with('product')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->paginate(10);

        return view('customer.my-orders', compact('orders'));
    }
    
    public function store(Request $request)
    {
       // 1. Validasi Input Data dari Form Pelanggan
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'file_desain' => 'required|file|mimes:pdf,jpg,png,jpeg,tiff|max:20480', // Maksimal file 20MB
            'catatan' => 'nullable|string',
            'panjang' => 'nullable|numeric|min:0.1',
            'lebar' => 'nullable|numeric|min:0.1',
            'quantity' => 'nullable|integer|min:1',
        ]);

        // 2. Ambil Data Produk Asli dari Database untuk Keamanan Harga
        $product = Product::findOrFail($request->product_id);
        $totalHarga = 0;

        // 3. Logika Perhitungan Ulang di Sisi Server (Mencegah Manipulasi Harga)
        if ($product->kategori === 'Spanduk' || $product->kategori === 'Stiker') {
            $pCustomer = floatval($request->panjang);
            $lCustomer = floatval($request->lebar);

            // Ambil array ukuran standar mesin dari produk (contoh: [1, 1.5, 2, 3])
            $strUkuran = $product->ukuran_standar;
            $bahanStandar = $strUkuran ? array_map('floatval', explode(',', $strUkuran)) : [1, 1.5, 2, 3];
            sort($bahanStandar);

            $pFinal = $pCustomer;
            $lFinal = $lCustomer;

            if ($pCustomer > 0 && $lCustomer > 0) {
                // Cari ukuran gulungan bahan mesin yang pas atau di atas kebutuhan customer
                foreach ($bahanStandar as $size) {
                    if ($size >= $lCustomer) {
                        $lFinal = $size;
                        break;
                    }
                }
            }

            // Hitung luas meter persegi dan kalikan dengan harga dasar
            $luasMeter = $pFinal * $lFinal;
            $totalHarga = $luasMeter * $product->harga_dasar;
        } else {
            // Hitung kuantitas lembaran biasa untuk Brosur / Kartu Nama
            $qty = intval($request->quantity) ?: 1;
            $totalHarga = $qty * $product->harga_dasar;
        }

        // 4. Pembulatan Ke Atas Kelipatan Rp 5.000 (Sesuai Tampilan di Customer)
        $totalHargaFinal = ceil($totalHarga / 5000) * 5000;

        /// 5. Proses Upload File Desain Pelanggan ke Folder Proyek
        $pathFileDesain = null; // <--- DEFINISIKAN AWAL DI SINI AGAR SANG MERAH TOBAT
        if ($request->hasFile('file_desain')) {
            $file = $request->file('file_desain');
            // Membuat nama file unik: order_waktu_namafile.ekstensi
            $namaFile = 'order_' . time() . '_' . $file->getClientOriginalName();
            // Menyimpan file fisik ke folder: public/uploads/desain/
            $file->move(public_path('uploads/desain'), $namaFile);
            $pathFileDesain = 'uploads/desain/' . $namaFile;
        }

        // 6. Simpan Seluruh Data ke Tabel Orders
        Order::create([
            'user_id' => Auth::id(), // ID Customer yang sedang login
            'product_id' => $product->id,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'quantity' => $request->quantity,
            'file_desain' => $pathFileDesain,
            'catatan' => $request->catatan,
            'total_harga' => $totalHargaFinal,
            'status' => 'Pending',
        ]);

        // 7. Alihkan Kembali ke Dashboard dengan Pesan Sukses Berbunga-bunga
        return redirect()->route('dashboard')->with('success', 'Pesanan Anda berhasil dikirim ke CV Salam Indah! Tim kami akan segera memproses berkas cetak Anda.');
    }

    public function riwayat(Request $request)
    {
        $query = Order::with(['user', 'product'])
                    ->where('diambil', true)
                    ->latest();

        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('dari')) {
            $query->whereDate('updated_at', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('updated_at', '<=', $request->sampai);
        }

        $totalPendapatan = (clone $query)->sum('total_harga');
        $orders = $query->paginate(10)->appends(request()->query());
        
        return view('admin.orders.riwayat', compact('orders', 'totalPendapatan'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['user', 'product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        if ($request->has('status')) {
            $request->validate([
                'status' => 'required|in:Pending,Diproses,Selesai Cetak',
            ]);
            $order->update(['status' => $request->status]);
            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
        }

        if ($request->has('diambil')) {
            $request->validate([
                'metode_bayar' => 'required|in:Tunai,Transfer',
            ]);
            $order->update([
                'diambil'      => true,
                'metode_bayar' => $request->metode_bayar,
            ]);
            return redirect()->back()->with('success', 'Pesanan ditandai sudah diambil!');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}
