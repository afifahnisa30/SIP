<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Pengeluaran;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function harian()
    {
        $tanggal = request('tanggal');

        $orders = collect();
        $pengeluaran = collect();
        $totalPendapatan = 0;
        $totalPengeluaran = 0;
        $labaBersih = 0;
        $kasMasukTunai = 0;
        $kasMasukTransfer = 0;
        $kasKeluarTunai = 0;
        $kasKeluarTransfer = 0;

        if ($tanggal) {
            $orders = Order::with(['user', 'product'])
                        ->where('diambil', true)
                        ->whereDate('updated_at', $tanggal)
                        ->get();

            $pengeluaran = Pengeluaran::whereDate('tanggal', $tanggal)->get();

            $totalPendapatan   = $orders->sum('total_harga');
            $totalPengeluaran  = $pengeluaran->sum('harga');
            $labaBersih        = $totalPendapatan - $totalPengeluaran;
            $kasMasukTunai     = $orders->where('metode_bayar', 'Tunai')->sum('total_harga');
            $kasMasukTransfer  = $orders->where('metode_bayar', 'Transfer')->sum('total_harga');
            $kasKeluarTunai    = $pengeluaran->where('metode_bayar', 'Tunai')->sum('harga');
            $kasKeluarTransfer = $pengeluaran->where('metode_bayar', 'Transfer')->sum('harga');
        }

        return view('admin.laporan.harian', compact(
            'tanggal', 'orders', 'pengeluaran',
            'totalPendapatan', 'totalPengeluaran', 'labaBersih',
            'kasMasukTunai', 'kasMasukTransfer',
            'kasKeluarTunai', 'kasKeluarTransfer'
        ));
    }

    public function periode()
    {
        $dari = request('dari');
        $sampai = request('sampai');

        $orders = collect();
        $pengeluaran = collect();
        $totalPendapatan = 0;
        $totalPengeluaran = 0;
        $labaBersih = 0;
        $kasMasukTunai = 0;
        $kasMasukTransfer = 0;
        $kasKeluarTunai = 0;
        $kasKeluarTransfer = 0;

        if ($dari && $sampai) {
            $orders = Order::with(['user', 'product'])
                        ->where('diambil', true)
                        ->whereDate('updated_at', '>=', $dari)
                        ->whereDate('updated_at', '<=', $sampai)
                        ->get();

            $pengeluaran = Pengeluaran::whereDate('tanggal', '>=', $dari)
                        ->whereDate('tanggal', '<=', $sampai)
                        ->get();

            $totalPendapatan   = $orders->sum('total_harga');
            $totalPengeluaran  = $pengeluaran->sum('harga');
            $labaBersih        = $totalPendapatan - $totalPengeluaran;
            $kasMasukTunai     = $orders->where('metode_bayar', 'Tunai')->sum('total_harga');
            $kasMasukTransfer  = $orders->where('metode_bayar', 'Transfer')->sum('total_harga');
            $kasKeluarTunai    = $pengeluaran->where('metode_bayar', 'Tunai')->sum('harga');
            $kasKeluarTransfer = $pengeluaran->where('metode_bayar', 'Transfer')->sum('harga');
        }

        return view('admin.laporan.periode', compact(
            'dari', 'sampai', 'orders', 'pengeluaran',
            'totalPendapatan', 'totalPengeluaran', 'labaBersih',
            'kasMasukTunai', 'kasMasukTransfer',
            'kasKeluarTunai', 'kasKeluarTransfer'
        ));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
