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

        $totalPengeluaran = (clone $query)->sum('harga');
        $pengeluaran = $query->paginate(10)->appends(request()->query());

        return view('admin.pengeluaran.index', compact('pengeluaran', 'totalPengeluaran'));
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
