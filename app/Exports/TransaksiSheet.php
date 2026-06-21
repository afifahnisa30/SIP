<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
//use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TransaksiSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $dari;
    protected $sampai;

    public function __construct($dari, $sampai)
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
    }

    public function collection()
    {
        $orders = Order::with(['user', 'product'])
                    ->where('diambil', true)
                    ->where('status_bayar', 'Lunas')
                    ->whereDate('updated_at', '>=', $this->dari)
                    ->whereDate('updated_at', '<=', $this->sampai)
                    ->get();

        return $orders->map(function($order, $i) {
            return [
                'No'          => $i + 1,
                'Tanggal'     => $order->updated_at->format('d/m/Y'),
                'Pelanggan'   => $order->user ? $order->user->name : $order->nama_pelanggan,
                // Kolom No. Telp sudah dihapus dari sini
                'Produk'      => $order->product->nama,
                'Detail'      => $order->panjang && $order->lebar
                                    ? $order->panjang . 'x' . $order->lebar . 'm'
                                    : ($order->quantity ? $order->quantity . ' pcs' : '-'),
                'Metode'      => $order->metode_bayar,
                'Total'       => $order->total_harga,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No', 'Tanggal', 'Pelanggan',
            'Produk', 'Detail', 'Metode Bayar', 'Total (Rp)' // Judul kolom disesuaikan
        ];
    }

    // 3. Tambahkan fungsi ini untuk format mata uang
    public function columnFormats(): array
    {
        return [
            'G' => '#,##0', // pemisah ribuan
        ];
    }

    public function title(): string
    {
        return 'Transaksi Penjualan';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}