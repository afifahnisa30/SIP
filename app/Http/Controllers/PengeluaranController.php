<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pengeluaran::latest('tanggal');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }

        // Cards — default hari ini, kalau ada filter ikut filter
        $cardQuery = Pengeluaran::query();
        if ($request->filled('dari') && $request->filled('sampai')) {
            $cardQuery->whereDate('tanggal', '>=', $request->dari)
                    ->whereDate('tanggal', '<=', $request->sampai);
        } elseif ($request->filled('dari')) {
            $cardQuery->whereDate('tanggal', $request->dari);
        } else {
            $cardQuery->whereDate('tanggal', today()); // ← default hari ini
        }

        if ($request->filled('kategori')) {
            $cardQuery->where('kategori', $request->kategori);
        }

        $totalPengeluaran    = (clone $cardQuery)->sum('harga');
        $pengeluaranTunai    = (clone $cardQuery)->where('metode_bayar', 'Tunai')->sum('harga');
        $pengeluaranTransfer = (clone $cardQuery)->where('metode_bayar', 'Transfer')->sum('harga');

        $pengeluaran = $query->paginate(10)->appends(request()->query());

        return view('admin.pengeluaran.index', compact(
            'pengeluaran', 'totalPengeluaran',
            'pengeluaranTunai', 'pengeluaranTransfer'
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
        $request->validate([
        'tanggal'      => 'required|date',
        'kategori'     => 'required|in:Listrik,Makan Karyawan,Internet,Expedisi,Umum',
        'keterangan'   => 'required|string|max:255',
        'harga'        => 'required|integer|min:1',
        'metode_bayar' => 'required|in:Tunai,Transfer',
    ]);

        Pengeluaran::create($request->all());

        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil ditambahkan!');
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
        $pengeluaran = Pengeluaran::findOrFail($id);

       $request->validate([
        'tanggal'      => 'required|date',
        'kategori'     => 'required|in:Listrik,Makan Karyawan,Internet,Expedisi,Umum',
        'keterangan'   => 'required|string|max:255',
        'harga'        => 'required|integer|min:1',
        'metode_bayar' => 'required|in:Tunai,Transfer',
    ]);

        $pengeluaran->update($request->all());

        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}
