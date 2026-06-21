<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
//use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
//use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TransaksiSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    protected $dari;
    protected $sampai;
    protected $totalRows;

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

        $this->totalRows = $orders->count();

        return $orders->map(function($order, $i) {
            return [
                'No'        => $i + 1,
                'Tanggal'   => $order->updated_at->format('d/m/Y'),
                'Pelanggan' => $order->user ? $order->user->name : $order->nama_pelanggan,
                'Produk'    => $order->product->nama,
                'Detail'    => $order->panjang && $order->lebar
                                ? $order->panjang . 'x' . $order->lebar . 'm'
                                : ($order->quantity ? $order->quantity . ' pcs' : '-'),
                'Metode'    => $order->metode_bayar,
                'Total'     => $order->total_harga,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No', 'Tanggal', 'Pelanggan', 'Produk',
            'Detail', 'Metode Bayar', 'Total'
        ];
    }

    public function title(): string
    {
        return 'Transaksi Penjualan';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // 1. Geser seluruh tabel ke bawah sebanyak 3 baris
                $sheet->insertNewRowBefore(1, 3);

                // 2. Tulis Judul di baris 1
                $dari = \Carbon\Carbon::parse($this->dari)->translatedFormat('d F Y');
                $sampai = \Carbon\Carbon::parse($this->sampai)->translatedFormat('d F Y');
                
                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', 'Laporan Periode ' . $dari . ' - ' . $sampai);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // 3. Styling Header sekarang berada di baris 4 (karena sudah digeser 3 baris)
                $sheet->getStyle('A4:G4')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A5F']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(14);
                $sheet->getColumnDimension('C')->setWidth(20);
                $sheet->getColumnDimension('D')->setWidth(25);
                $sheet->getColumnDimension('E')->setWidth(12);
                $sheet->getColumnDimension('F')->setWidth(15);
                $sheet->getColumnDimension('G')->setWidth(18);

                // 4. Sesuaikan semua koordinat lain (seperti lastRow)
                // lastRow sekarang adalah total baris data + 4 (baris ke-4 adalah header)
                $lastRow = $this->totalRows + 4;
                $sheet->getStyle('A4:G' . $lastRow)->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]]
                ]);

                // Format Total sebagai angka
                $sheet->getStyle('G4:G' . $lastRow)
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');

                // Alignment
                $sheet->getStyle('A4:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('G4:G' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                // Baris total
                $totalRow = $lastRow + 1;
                $sheet->mergeCells('A' . $totalRow . ':F' . $totalRow);
                $sheet->setCellValue('A' . $totalRow, 'TOTAL PENDAPATAN');
                $sheet->setCellValue('G' . $totalRow, '=SUM(G4:G' . $lastRow . ')');
                $sheet->getStyle('A' . $totalRow . ':G' . $totalRow)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'CCCCCC'],
                        ],
                    ],
                ]);
                $sheet->getStyle('G' . $totalRow)
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');
                $sheet->getStyle('A' . $totalRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            }
        ];
    }
}