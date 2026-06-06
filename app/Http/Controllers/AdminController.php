<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{

    public function index()
    {
        $pendingCount   = Order::where('status', 'Pending')->count();
        $completedCount = Order::where('status', 'Selesai Cetak')->count();
        $todayIncome    = Order::whereDate('created_at', today())
                                ->whereIn('status', ['Selesai Cetak', 'Bisa Diambil'])
                                ->sum('total_harga');

        $chartData = [
            'Pending'       => Order::where('status', 'Pending')->count(),
            'Diproses'      => Order::where('status', 'Diproses')->count(),
            'Selesai Cetak' => Order::where('status', 'Selesai Cetak')->count(),
            'Bisa Diambil'  => Order::where('status', 'Bisa Diambil')->count(),
        ];

        $recentOrders = Order::with(['user', 'product'])
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact(
            'pendingCount', 'completedCount', 'todayIncome',
            'chartData', 'recentOrders'
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
