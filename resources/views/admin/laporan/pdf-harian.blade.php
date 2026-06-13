<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; padding: 20px; }

        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .header-logo { display: flex; align-items: center; gap: 10px; }
        .header-logo img { width: 50px; height: 50px; object-fit: contain; }
        .header-logo h1 { font-size: 18px; font-weight: bold; color: #0891b2; }
        .header-logo p { font-size: 10px; color: #666; }
        .header-info { text-align: right; font-size: 10px; color: #555; line-height: 1.6; }

        hr { border: none; border-top: 2px solid #0891b2; margin: 8px 0; }
        hr.dashed { border-top: 1px dashed #ccc; }

        h2 { font-size: 13px; font-weight: bold; margin: 14px 0 8px 0; color: #1e3a5f; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        table thead tr { background-color: #0891b2; color: white; }
        table thead th { padding: 6px 8px; text-align: left; font-size: 10px; }
        table tbody tr:nth-child(even) { background-color: #f1f5f9; }
        table tbody td { padding: 5px 8px; font-size: 10px; border-bottom: 1px solid #e2e8f0; }
        table tfoot tr { background-color: #e0f2fe; }
        table tfoot td { padding: 6px 8px; font-weight: bold; font-size: 10px; }

        .rekap { width: 100%; margin-top: 10px; }
        .rekap-box { border: 1px dashed #0891b2; padding: 12px; width: 55%; float: right; }
        .rekap-row { display: flex; justify-content: space-between; margin-bottom: 4px; }
        .rekap-row.bold { font-weight: bold; font-size: 11px; }
        .rekap-row.sub { padding-left: 12px; font-size: 10px; color: #555; }
        .text-green { color: #059669; }
        .text-red { color: #dc2626; }
        .text-blue { color: #2563eb; }

        .footer { margin-top: 20px; font-size: 10px; color: #888; text-align: center; }
        .clearfix::after { content: ""; display: table; clear: both; }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-logo">
            <img src="{{ public_path('assets/img/logo.png') }}">
            <div>
                <h1>SALAM INDAH</h1>
                <p>CV Salam Indah Group</p>
                <p>Percetakan Digital</p>
            </div>
        </div>
        <div class="header-info">
            <div>Laporan tanggal : <strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</strong></div>
            <div>Dicetak oleh : <strong>{{ Auth::user()->name }}</strong></div>
            <div>Generate : <strong>{{ now()->format('d/m/Y H:i:s') }}</strong></div>
        </div>
    </div>
    <hr>

    {{-- TABEL TRANSAKSI --}}
    <h2>Transaksi Penjualan</h2>
    <table>
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Detail</th>
                <th>Metode</th>
                <th style="text-align:right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->product->nama }}</td>
                <td>
                    @if($order->panjang && $order->lebar)
                        {{ $order->panjang }} x {{ $order->lebar }} m
                    @elseif($order->quantity)
                        {{ $order->quantity }} pcs
                    @else
                        -
                    @endif
                </td>
                <td>{{ $order->metode_bayar }}</td>
                <td style="text-align:right">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; color:#999">Tidak ada transaksi</td>
            </tr>
            @endforelse
        </tbody>
        @if($orders->count() > 0)
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:right">TOTAL PENDAPATAN</td>
                <td style="text-align:right; color:#059669">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    {{-- TABEL PENGELUARAN --}}
    <h2>Pengeluaran</h2>
    <table>
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Metode</th>
                <th style="text-align:right">Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengeluaran as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $item->metode_bayar }}</td>
                <td style="text-align:right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; color:#999">Tidak ada pengeluaran</td>
            </tr>
            @endforelse
        </tbody>
        @if($pengeluaran->count() > 0)
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right">TOTAL PENGELUARAN</td>
                <td style="text-align:right; color:#dc2626">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    {{-- REKAP AKHIR --}}
    <div class="clearfix">
        <div class="rekap-box">
            <div style="font-weight:bold; font-size:12px; margin-bottom:8px; color:#1e3a5f;">Akhir Laporan :</div>

            <div class="rekap-row bold">
                <span>Kas Masuk</span>
                <span class="text-green">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            </div>
            <div class="rekap-row sub">
                <span>- Tunai</span>
                <span>Rp {{ number_format($kasMasukTunai, 0, ',', '.') }}</span>
            </div>
            <div class="rekap-row sub" style="margin-bottom:8px">
                <span>- Transfer</span>
                <span>Rp {{ number_format($kasMasukTransfer, 0, ',', '.') }}</span>
            </div>

            <div class="rekap-row bold">
                <span>Kas Keluar</span>
                <span class="text-red">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
            </div>
            <div class="rekap-row sub">
                <span>- Tunai</span>
                <span class="text-red">Rp {{ number_format($kasKeluarTunai, 0, ',', '.') }}</span>
            </div>
            <div class="rekap-row sub" style="margin-bottom:8px">
                <span>- Transfer</span>
                <span class="text-red">Rp {{ number_format($kasKeluarTransfer, 0, ',', '.') }}</span>
            </div>

            <hr class="dashed">

            <div class="rekap-row bold" style="margin-top:6px">
                <span>Hasil Akhir</span>
                <span class="{{ $labaBersih >= 0 ? 'text-blue' : 'text-red' }}">Rp {{ number_format($labaBersih, 0, ',', '.') }}</span>
            </div>
            <div class="rekap-row sub">
                <span>- Tunai</span>
                <span class="{{ ($kasMasukTunai - $kasKeluarTunai) >= 0 ? 'text-blue' : 'text-red' }}">
                    Rp {{ number_format($kasMasukTunai - $kasKeluarTunai, 0, ',', '.') }}
                </span>
            </div>
            <div class="rekap-row sub">
                <span>- Transfer</span>
                <span class="{{ ($kasMasukTransfer - $kasKeluarTransfer) >= 0 ? 'text-blue' : 'text-red' }}">
                    Rp {{ number_format($kasMasukTransfer - $kasKeluarTransfer, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Generate: {{ now()->format('d/m/Y H:i:s') }} — CV Salam Indah Group</p>
    </div>

</body>
</html>