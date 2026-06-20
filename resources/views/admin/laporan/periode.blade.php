@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Laporan Periode</h2>
        <p class="text-xs text-gray-400 mt-1">Rekap transaksi dan pengeluaran berdasarkan periode</p>
    </div>
</div>

{{-- PILIH PERIODE --}}
<form method="GET" action="{{ route('laporan.periode') }}" class="flex flex-wrap gap-3 mb-6">
    <div class="flex items-center gap-2">
        <label class="text-sm text-gray-500 font-medium">Dari</label>
        <input type="date" name="dari" value="{{ $dari }}"
            class="py-2.5 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>
    <div class="flex items-center gap-2">
        <label class="text-sm text-gray-500 font-medium">Sampai</label>
        <input type="date" name="sampai" value="{{ $sampai }}"
            class="py-2.5 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>
    <button type="submit"
        class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-semibold rounded-2xl hover:opacity-90 transition">
        <i class="fas fa-search mr-1"></i> Tampilkan
    </button>
    @if($dari && $sampai)
    <button type="button" onclick="window.print()"
        class="px-5 py-2.5 bg-slate-700 text-white text-sm font-semibold rounded-2xl hover:opacity-90 transition">
        <i class="fas fa-print mr-1"></i> Print Laporan
    </button>
    @endif
</form>

<div id="printArea">
@if($dari && $sampai)

    {{-- ===== KONTEN LAYAR ===== --}}
    <div class="print:hidden">

        {{-- REKAP + STAT --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">

            {{-- Rekap Kas --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Rekap Laporan</h3>
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-sm font-bold text-gray-700">Kas Masuk</span>
                        <span class="text-sm font-black text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                    </div>
                    <div class="space-y-1 pl-3 text-xs text-gray-400">
                        <div class="flex justify-between"><span>— Tunai</span><span>Rp {{ number_format($kasMasukTunai, 0, ',', '.') }}</span></div>
                        <div class="flex justify-between"><span>— Transfer</span><span>Rp {{ number_format($kasMasukTransfer, 0, ',', '.') }}</span></div>
                    </div>
                </div>
                <hr class="border-gray-100 my-3">
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-sm font-bold text-gray-700">Kas Keluar</span>
                        <span class="text-sm font-black text-red-500">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
                    </div>
                    <div class="space-y-1 pl-3 text-xs text-gray-400">
                        <div class="flex justify-between"><span>— Tunai</span><span class="text-red-400">Rp {{ number_format($kasKeluarTunai, 0, ',', '.') }}</span></div>
                        <div class="flex justify-between"><span>— Transfer</span><span class="text-red-400">Rp {{ number_format($kasKeluarTransfer, 0, ',', '.') }}</span></div>
                    </div>
                </div>
                <hr class="border-dashed border-gray-200 my-3">
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-sm font-bold text-gray-700">Hasil Akhir</span>
                        <span class="text-sm font-black {{ $labaBersih >= 0 ? 'text-blue-600' : 'text-red-500' }}">
                            Rp {{ number_format($labaBersih, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="space-y-1 pl-3 text-xs text-gray-400">
                        <div class="flex justify-between">
                            <span>— Tunai</span>
                            <span class="{{ ($kasMasukTunai - $kasKeluarTunai) >= 0 ? 'text-blue-500' : 'text-red-400' }}">Rp {{ number_format($kasMasukTunai - $kasKeluarTunai, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>— Transfer</span>
                            <span class="{{ ($kasMasukTransfer - $kasKeluarTransfer) >= 0 ? 'text-blue-500' : 'text-red-400' }}">Rp {{ number_format($kasMasukTransfer - $kasKeluarTransfer, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>{{-- end rekap kas --}}

            {{-- Stat Cards --}}
            <div class="flex flex-col gap-4">
                <div class="bg-[#059669] p-5 rounded-2xl shadow-lg text-white flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-arrow-up text-white"></i>
                    </div>
                    <div>
                        <p class="text-xs text-emerald-100 uppercase tracking-widest">Total Pendapatan</p>
                        <p class="text-xl font-black mt-0.5">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="bg-[#DC2626] p-5 rounded-2xl shadow-lg text-white flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-arrow-down text-white"></i>
                    </div>
                    <div>
                        <p class="text-xs text-red-100 uppercase tracking-widest">Total Pengeluaran</p>
                        <p class="text-xl font-black mt-0.5">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="bg-[#2563EB] p-5 rounded-2xl shadow-lg text-white flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-wallet text-white"></i>
                    </div>
                    <div>
                        <p class="text-xs text-blue-100 uppercase tracking-widest">Laba Bersih</p>
                        <p class="text-xl font-black mt-0.5">
                            Rp {{ number_format($labaBersih, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>{{-- end stat cards --}}

        </div>{{-- end grid rekap + stat --}}

        {{-- TABEL TRANSAKSI --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-700">Transaksi Penjualan</h3>
                <span class="text-xs text-gray-400">{{ $orders->count() }} transaksi</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-xs text-gray-400 uppercase tracking-widest border-b border-gray-100">
                            <th class="px-5 py-3 text-left">No</th>
                            <th class="px-5 py-3 text-left">Tanggal</th>
                            <th class="px-5 py-3 text-left">Pelanggan</th>
                            <th class="px-5 py-3 text-left">Produk</th>
                            <th class="px-5 py-3 text-left">Detail</th>
                            <th class="px-5 py-3 text-left">Metode</th>
                            <th class="px-5 py-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($orders as $order)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3 text-gray-400">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 text-xs text-gray-500">{{ $order->updated_at->format('d M Y') }}</td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $order->user ? $order->user->name : $order->nama_pelanggan }}</td>
                            <td class="px-5 py-3 text-gray-700">{{ $order->product->nama }}</td>
                            <td class="px-5 py-3 text-xs text-gray-500">
                                @if($order->panjang && $order->lebar) {{ $order->panjang }} x {{ $order->lebar }} m
                                @elseif($order->quantity) {{ $order->quantity }} pcs
                                @else - @endif
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $order->metode_bayar == 'Tunai' ? 'bg-amber-50 text-amber-600' : 'bg-purple-50 text-purple-600' }}">
                                    {{ $order->metode_bayar }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right font-semibold text-emerald-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-5 py-10 text-center text-gray-400 text-xs"><i class="fas fa-inbox text-2xl mb-2 block"></i>Tidak ada transaksi</td></tr>
                        @endforelse
                    </tbody>
                    @if($orders->count() > 0)
                    <tfoot>
                        <tr class="bg-emerald-50">
                            <td colspan="6" class="px-5 py-3 text-sm font-bold text-gray-700 text-right">Total Pendapatan</td>
                            <td class="px-5 py-3 text-right font-black text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>

        {{-- TABEL PENGELUARAN --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-700">Transaksi Pengeluaran</h3>
                <span class="text-xs text-gray-400">{{ $pengeluaran->count() }} pengeluaran</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-xs text-gray-400 uppercase tracking-widest border-b border-gray-100">
                            <th class="px-5 py-3 text-left">No</th>
                            <th class="px-5 py-3 text-left">Tanggal</th>
                            <th class="px-5 py-3 text-left">Kategori</th>
                            <th class="px-5 py-3 text-left">Keterangan</th>
                            <th class="px-5 py-3 text-left">Metode</th>
                            <th class="px-5 py-3 text-right">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($pengeluaran as $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3 text-gray-400">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td class="px-5 py-3"><span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600">{{ $item->kategori }}</span></td>
                            <td class="px-5 py-3 text-gray-700">{{ $item->keterangan }}</td>
                            <td class="px-5 py-3"><span class="px-2 py-1 rounded-full text-xs font-medium {{ $item->metode_bayar == 'Tunai' ? 'bg-amber-50 text-amber-600' : 'bg-purple-50 text-purple-600' }}">{{ $item->metode_bayar }}</span></td>
                            <td class="px-5 py-3 text-right font-semibold text-red-500">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400 text-xs"><i class="fas fa-receipt text-2xl mb-2 block"></i>Tidak ada pengeluaran</td></tr>
                        @endforelse
                    </tbody>
                    @if($pengeluaran->count() > 0)
                    <tfoot>
                        <tr class="bg-red-50">
                            <td colspan="5" class="px-5 py-3 text-sm font-bold text-gray-700 text-right">Total Pengeluaran</td>
                            <td class="px-5 py-3 text-right font-black text-red-500">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>

    </div>{{-- end print:hidden --}}

    {{-- ===== KONTEN PRINT ===== --}}
    <div class="hidden print:block">
        <div class="print-header">
            <div class="print-header-logo">
                <img src="{{ asset('assets/img/logo.png') }}">
                <div>
                    <h1>SALAM INDAH</h1>
                    <p>CV Salam Indah Group</p>
                </div>
            </div>
            <div class="print-header-info">
                <table style="font-size:10px; text-align:left; border:none;">
                    <tr>
                        <td style="padding:1px 4px;">Laporan periode</td>
                        <td style="padding:1px 4px;">:</td>
                        <td style="padding:1px 4px;"><strong>{{ \Carbon\Carbon::parse($dari)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->translatedFormat('d F Y') }}</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:1px 4px;">Diperiksa & dicetak oleh</td>
                        <td style="padding:1px 4px;">:</td>
                        <td style="padding:1px 4px;"><strong>{{ Auth::user()->name }}</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:1px 4px;">Username</td>
                        <td style="padding:1px 4px;">:</td>
                        <td style="padding:1px 4px;"><strong>{{ Auth::user()->email }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
        <hr style="border-top: 2px solid #0891b2; margin-bottom: 10px;">

        <p style="font-weight:bold; margin-bottom:5px;">Transaksi Penjualan</p>
        <table>
            <thead>
                <tr>
                    <th>No</th><th>Tanggal</th><th>Pelanggan</th><th>Produk</th><th>Detail</th>
                    <th style="text-align:right">Total</th><th>Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->updated_at->format('d M Y') }}</td>
                    <td>{{ $order->user ? $order->user->name : $order->nama_pelanggan }}</td>
                    <td>{{ $order->product->nama }}</td>
                    <td>@if($order->panjang && $order->lebar){{ $order->panjang }}x{{ $order->lebar }}m@elseif($order->quantity){{ $order->quantity }} pcs@else-@endif</td>
                    <td style="text-align:right">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $order->metode_bayar }}</td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center">Tidak ada transaksi</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align:right">TOTAL</td>
                    <td style="text-align:right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <p style="font-weight:bold; margin-bottom:5px;">Transaksi Pengeluaran</p>
        <table>
            <thead>
                <tr>
                    <th>No</th><th>Tanggal</th><th>Kategori</th><th>Keterangan</th>
                    <th style="text-align:right">Total</th><th>Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengeluaran as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td style="text-align:right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>{{ $item->metode_bayar }}</td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center">Tidak ada pengeluaran</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:right">TOTAL</td>
                    <td style="text-align:right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <div style="overflow:hidden; margin-top:10px;">
            <p class="print-generate">Generate: {{ now()->format('d/m/Y H:i:s') }}</p>
            <div class="print-rekap">
                <p style="font-weight:bold; margin-bottom:8px; color:#1e3a5f;">Akhir Laporan :</p>
                <div class="print-rekap-row" style="font-weight:bold"><span>Kas Masuk</span><span style="color:#059669">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span></div>
                <div class="print-rekap-row" style="padding-left:10px; color:#555"><span>- Saldo TUNAI</span><span>Rp {{ number_format($kasMasukTunai, 0, ',', '.') }}</span></div>
                <div class="print-rekap-row" style="padding-left:10px; color:#555; margin-bottom:6px"><span>- Saldo TRANSFER</span><span>Rp {{ number_format($kasMasukTransfer, 0, ',', '.') }}</span></div>
                <div class="print-rekap-row" style="font-weight:bold"><span>Kas Keluar</span><span style="color:#dc2626">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span></div>
                <div class="print-rekap-row" style="padding-left:10px; color:#dc2626"><span>- Saldo TUNAI</span><span>Rp {{ number_format($kasKeluarTunai, 0, ',', '.') }}</span></div>
                <div class="print-rekap-row" style="padding-left:10px; color:#dc2626; margin-bottom:6px"><span>- Saldo TRANSFER</span><span>Rp {{ number_format($kasKeluarTransfer, 0, ',', '.') }}</span></div>
                <hr style="border-top: 1px dashed #0891b2; margin: 6px 0;">
                <div class="print-rekap-row" style="font-weight:bold"><span>Hasil Akhir</span><span style="color:{{ $labaBersih >= 0 ? '#2563eb' : '#dc2626' }}">Rp {{ number_format($labaBersih, 0, ',', '.') }}</span></div>
                <div class="print-rekap-row" style="padding-left:10px; color:{{ ($kasMasukTunai - $kasKeluarTunai) >= 0 ? '#2563eb' : '#dc2626' }}"><span>- TUNAI</span><span>Rp {{ number_format($kasMasukTunai - $kasKeluarTunai, 0, ',', '.') }}</span></div>
                <div class="print-rekap-row" style="padding-left:10px; color:{{ ($kasMasukTransfer - $kasKeluarTransfer) >= 0 ? '#2563eb' : '#dc2626' }}"><span>- TRANSFER</span><span>Rp {{ number_format($kasMasukTransfer - $kasKeluarTransfer, 0, ',', '.') }}</span></div>
            </div>
        </div>
    </div>{{-- end print:block --}}

@else
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-16 text-center text-gray-400">
        <i class="fas fa-calendar-alt text-4xl mb-3 block text-gray-300"></i>
        <p class="font-semibold text-gray-500">Pilih periode dan tekan Tampilkan</p>
        <p class="text-xs mt-1">Data transaksi dan pengeluaran akan muncul di sini</p>
    </div>
@endif
</div>

@endsection

@push('scripts')
<style>
    @media print {
        body * { visibility: hidden; }
        #printArea, #printArea * { visibility: visible; }
        #printArea { position: absolute; left: 0; top: 0; width: 100%; padding: 20px; font-family: Arial, sans-serif; font-size: 11px; }
        .print-hide { display: none !important; }
        .print-header { display: flex !important; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .print-header-logo { display: flex !important; align-items: center; gap: 10px; }
        .print-header-logo img { width: 50px; height: 50px; object-fit: contain; }
        .print-header-logo h1 { font-size: 18px; font-weight: bold; color: #0891b2; margin: 0; }
        .print-header-logo p { font-size: 10px; color: #666; margin: 0; }
        .print-header-info { text-align: right; font-size: 10px; line-height: 1.8; }
        .print-header-info table, .print-header-info table td { border: none !important; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 14px; font-size: 10px; }
        table thead tr { background-color: #eab308 !important; -webkit-print-color-adjust: exact; }
        table thead th { padding: 5px 8px; text-align: left; border: 1px solid #ccc; }
        table tbody td { padding: 4px 8px; border: 1px solid #e2e8f0; }
        table tfoot td { padding: 5px 8px; font-weight: bold; border: 1px solid #ccc; }
        .print-rekap { float: right; width: 45%; border: 1px dashed #0891b2; padding: 10px; font-size: 10px; }
        .print-rekap-row { display: flex; justify-content: space-between; margin-bottom: 3px; }
        .print-generate { font-size: 10px; color: #888; margin-top: 8px; }
        .rounded-3xl, .rounded-2xl, .rounded-xl { border-radius: 0 !important; }
        .shadow-sm { box-shadow: none !important; }
    }
</style>
@endpush