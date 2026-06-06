@extends('layouts.admin')

@section('content')

{{-- STAT CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="p-4 bg-amber-50 text-amber-500 rounded-2xl text-xl">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <span class="block text-2xl font-bold text-gray-800">{{ $pendingCount }}</span>
            <span class="text-[11px] text-gray-500 font-medium uppercase tracking-widest">Pesanan Masuk</span>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="p-4 bg-emerald-50 text-emerald-500 rounded-2xl text-xl">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <span class="block text-2xl font-bold text-gray-800">{{ $completedCount }}</span>
            <span class="text-[11px] text-gray-500 font-medium uppercase tracking-widest">Selesai Cetak</span>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="p-4 bg-blue-50 text-blue-500 rounded-2xl text-xl">
            <i class="fas fa-wallet"></i>
        </div>
        <div>
            <span class="block text-2xl font-bold text-gray-800">Rp {{ number_format($todayIncome, 0, ',', '.') }}</span>
            <span class="text-[11px] text-gray-500 font-medium uppercase tracking-widest">Pendapatan Hari Ini</span>
        </div>
    </div>
</div>

{{-- CHART + TABEL --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

    {{-- Chart --}}
    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-widest">Pesanan per Status</h3>
        <canvas id="orderChart" height="220"></canvas>
    </div>

    {{-- Tabel Pesanan Terbaru --}}
    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-widest">Pesanan Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="pb-3">Pelanggan</th>
                        <th class="pb-3">Produk</th>
                        <th class="pb-3">Total</th>
                        <th class="pb-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentOrders as $order)
                    <tr class="text-gray-700">
                        <td class="py-3">{{ $order->user->name }}</td>
                        <td class="py-3">{{ $order->product->nama }}</td>
                        <td class="py-3 whitespace-nowrap">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td class="py-3">
                            @php
                                $statusColor = match($order->status) {
                                    'Pending'       => 'bg-amber-100 text-amber-600',
                                    'Diproses'      => 'bg-blue-100 text-blue-600',
                                    'Selesai Cetak' => 'bg-emerald-100 text-emerald-600',
                                    'Bisa Diambil'  => 'bg-purple-100 text-purple-600',
                                    default         => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                {{ $order->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-400 text-xs">Belum ada pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('orderChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($chartData)) !!},
            datasets: [{
                data: {!! json_encode(array_values($chartData)) !!},
                backgroundColor: ['#FCD34D', '#60A5FA', '#34D399', '#A78BFA'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush