<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{

    public function index()
    {
        $pendingCount   = Order::where('status', 'Pending')->count();
        $completedCount = Order::whereDate('updated_at', today())
                                 ->where('status', 'Selesai Cetak')
                                 ->count();
        $todayIncome    = Order::whereDate('updated_at', today())
                                ->where('diambil', true)
                                ->where('status_bayar', 'Lunas')
                                ->sum('total_harga');

        $monthIncome = Order::whereMonth('updated_at', now()->month)
                            ->whereYear('updated_at', now()->year)
                            ->where('diambil', true)
                            ->sum('total_harga');

        $totalProduct = \App\Models\Product::count();

        $chartData = [
            'Pending'       => Order::where('status', 'Pending')->count(),
            'Diproses'      => Order::where('status', 'Diproses')->count(),
            'Selesai Cetak' => Order::where('status', 'Selesai Cetak')->count(),
        ];

        $last7Days = collect(range(6, 0))->map(function($i) {
            $date = now()->subDays($i);
            return [
                'label' => $date->format('d M'),
                'count' => Order::whereDate('created_at', $date)->count(),
                'income' => Order::whereDate('updated_at', $date)->where('diambil', true)->sum('total_harga'),
            ];
        });

        $recentOrders = Order::with(['user', 'product'])
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact(
            'pendingCount', 'completedCount', 'todayIncome',
            'monthIncome', 'totalProduct', 'chartData',
            'last7Days', 'recentOrders'
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
