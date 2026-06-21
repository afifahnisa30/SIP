@extends('layouts.admin')

@section('content')

{{-- STAT CARDS --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

    {{-- Card 4 - Total Pelanggan --}}
    <div class="bg-[#0891B2] p-6 rounded-2xl shadow-lg text-white hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 ease-in-out">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-box-open text-white"></i>
            </div>
            <span class="text-xs bg-white/20 px-2 py-1 rounded-full font-medium">Total</span>
        </div>
        <p class="text-3xl font-black mb-1">{{ $totalProduct }}</p>
        <p class="text-xs text-cyan-200 uppercase tracking-widest font-medium">Total Produk</p>
    </div>
    
    {{-- Card 1 - Pesanan Masuk --}}
    <div class="bg-[#7C3AED] p-6 rounded-2xl shadow-lg text-white hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 ease-in-out">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-white"></i>
            </div>
            <span class="text-xs bg-white/20 px-2 py-1 rounded-full font-medium">Hari ini</span>
        </div>
        <p class="text-3xl font-black mb-1">{{ $pendingCount }}</p>
        <p class="text-xs text-purple-200 uppercase tracking-widest font-medium">Pesanan Masuk</p>
    </div>

    {{-- Card 2 - Selesai Cetak --}}
    <div class="bg-[#2563EB] p-6 rounded-2xl shadow-lg text-white hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 ease-in-out">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-white"></i>
            </div>
            <span class="text-xs bg-white/20 px-2 py-1 rounded-full font-medium">Hari ini</span>
        </div>
        <p class="text-3xl font-black mb-1">{{ $completedCount }}</p>
        <p class="text-xs text-blue-200 uppercase tracking-widest font-medium">Selesai Cetak</p>
    </div>

    {{-- Card 3 - Pendapatan --}}
    <div class="bg-[#059669] p-6 rounded-2xl shadow-lg text-white hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 ease-in-out">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-wallet text-white"></i>
            </div>
            <span class="text-xs bg-white/20 px-2 py-1 rounded-full font-medium">Hari ini</span>
        </div>
        <p class="text-xl font-black mb-1">Rp {{ number_format($todayIncome, 0, ',', '.') }}</p>
        <p class="text-xs text-emerald-200 uppercase tracking-widest font-medium">Pendapatan Hari Ini</p>
    </div>

    

</div>

{{-- CHART LINE + DONUT --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">

    {{-- Chart Line --}}
    <div class="xl:col-span-2 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-sm font-bold text-gray-800">Pesanan 7 Hari Terakhir</h3>
                <p class="text-xs text-gray-400 mt-0.5">Jumlah pesanan masuk per hari</p>
            </div>
            <div class="w-8 h-8 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-line text-xs"></i>
            </div>
        </div>
        <canvas id="lineChart" height="120"></canvas>
    </div>

    {{-- Chart Donut --}}
    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-sm font-bold text-gray-800">Status Pesanan</h3>
                <p class="text-xs text-gray-400 mt-0.5">Distribusi per status</p>
            </div>
            <div class="w-8 h-8 bg-purple-50 text-purple-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-pie text-xs"></i>
            </div>
        </div>
        <canvas id="donutChart" height="200"></canvas>
    </div>

</div>

{{-- TABEL PESANAN TERBARU --}}
<div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-sm font-bold text-gray-800">Pesanan Terbaru</h3>
            <p class="text-xs text-gray-400 mt-0.5">5 pesanan terakhir masuk</p>
        </div>
        <a href="{{ route('orders.index') }}"
            class="text-xs text-blue-500 hover:text-blue-700 font-semibold transition">
            Lihat Semua →
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase tracking-widest border-b border-gray-100">
                    <th class="pb-3">Pelanggan</th>
                    <th class="pb-3">Produk</th>
                    <th class="pb-3">Total</th>
                    <th class="pb-3">Status</th>
                    <th class="pb-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentOrders as $order)
                <tr class="text-gray-700 hover:bg-slate-50 transition">
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr($order->user ? $order->user->name : $order->nama_pelanggan, 0, 1)) }}
                            </div>
                            <span class="font-medium">{{ $order->user ? $order->user->name : $order->nama_pelanggan }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-gray-500">{{ $order->product->nama }}</td>
                    <td class="py-3 whitespace-nowrap font-semibold text-gray-800">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td class="py-3">
                        @php
                            $statusColor = match($order->status) {
                                'Pending'       => 'bg-amber-100 text-amber-600',
                                'Diproses'      => 'bg-blue-100 text-blue-600',
                                'Selesai Cetak' => 'bg-emerald-100 text-emerald-600',
                                default         => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ $order->diambil ? 'Sudah Diambil' : $order->status }}
                        </span>
                    </td>
                    <td class="py-3 text-xs text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-400 text-xs">
                        <i class="fas fa-inbox text-2xl mb-2 block"></i>
                        Belum ada pesanan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Line
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($last7Days->pluck('label')) !!},
            datasets: [{
                label: 'Pesanan',
                data: {!! json_encode($last7Days->pluck('count')) !!},
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.08)',
                borderWidth: 2.5,
                pointBackgroundColor: '#3B82F6',
                pointRadius: 4,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 11 } },
                    grid: { color: 'rgba(0,0,0,0.04)' }
                },
                x: {
                    ticks: { font: { size: 11 } },
                    grid: { display: false }
                }
            }
        }
    });

    // Chart Donut
    const donutCtx = document.getElementById('donutChart').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($chartData)) !!},
            datasets: [{
                data: {!! json_encode(array_values($chartData)) !!},
                backgroundColor: ['#FCD34D', '#60A5FA', '#34D399'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 11 } } }
            }
        }
    });
</script>
@endpush