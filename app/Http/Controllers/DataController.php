<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function pelanggan(Request $request)
    {
        // Pelanggan Online
        $onlineQuery = \App\Models\User::where('role', 'customer');
        if ($request->filled('search')) {
            $onlineQuery->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('phone_number', 'like', '%' . $request->search . '%');
            });
        }
        $onlineUsers = $onlineQuery->get()->map(function($user) {
            return [
                'id'          => $user->id,
                'nama'        => $user->name,
                'email'       => $user->email,
                'no_telp'     => $user->phone_number,
                'tipe'        => $user->tipe,
                'kategori'    => 'Online',
                'tgl_daftar'  => $user->created_at->format('d M Y'),
                'is_user'     => true,
            ];
        });

        // Pelanggan Offline — ambil unik berdasarkan nama + no_telp
        $offlineQuery = \App\Models\Order::whereNull('user_id')
                    ->select('nama_pelanggan', 'no_telp')
                    ->groupBy('nama_pelanggan', 'no_telp');

        if ($request->filled('search')) {
            $offlineQuery->where(function($q) use ($request) {
                $q->where('nama_pelanggan', 'like', '%' . $request->search . '%')
                ->orWhere('no_telp', 'like', '%' . $request->search . '%');
            });
        }

        $offlineUsers = $offlineQuery->get()->map(function($order) {
            return [
                'id'         => null,
                'nama'       => $order->nama_pelanggan,
                'email'      => '-',
                'no_telp'    => $order->no_telp,
                'tipe'       => 'Umum',
                'kategori'   => 'Offline',
                'tgl_daftar' => '-',
                'is_user'    => false,
            ];
        });

        // Filter kategori
        if ($request->filled('kategori')) {
            if ($request->kategori == 'Online') {
                $allPelanggan = $onlineUsers;
            } elseif ($request->kategori == 'Offline') {
                $allPelanggan = $offlineUsers;
            } else {
                $allPelanggan = $onlineUsers->merge($offlineUsers);
            }
        } else {
            $allPelanggan = $onlineUsers->merge($offlineUsers);
        }

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = 10;
        $total = $allPelanggan->count();
        $pelanggan = new \Illuminate\Pagination\LengthAwarePaginator(
            $allPelanggan->forPage($page, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.data.pelanggan', compact('pelanggan'));
    }

    public function admin(Request $request)
    {
        $query = User::where('role', 'admin');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(10)->appends(request()->query());
        return view('admin.data.admin', compact('users'));
    }

    public function tambahAdmin(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'nullable|email|unique:users,email',
            'phone_number' => 'required|string|unique:users,phone_number',
            'password'     => 'required|string|min:8',
        ]);

        User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'password'     => bcrypt($request->password),
            'role'         => 'admin',
        ]);

        return redirect()->route('data.admin')->with('success', 'Admin baru berhasil ditambahkan!');
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
        $user = User::findOrFail($id);
        return view('admin.data.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'nullable|email|unique:users,email,' . $id,
            'phone_number' => 'required|string|unique:users,phone_number,' . $id,
            'role'         => 'required|in:admin,customer',
            'tipe'         => 'required|in:Umum,Reseller',
        ]);

        $user->update($request->only('name', 'email', 'phone_number', 'role', 'tipe',));

        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
    }

}
