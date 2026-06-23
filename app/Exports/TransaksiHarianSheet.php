<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TransaksiHarianSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    protected $tanggal;
    protected $totalRows;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        $orders = Order::with(['user', 'product'])
                    ->where('diambil', true)
                    ->where('status_bayar', 'Lunas')
                    ->whereDate('updated_at', $this->tanggal)
                    ->orderBy('updated_at', 'asc')
                    ->get();

        $this->totalRows = $orders->count();

        return $orders->map(function($order, $i) {
            return [
                'No'        => $i + 1,
                'Pelanggan' => $order->user ? $order->user->name : $order->nama_pelanggan,
                'No. Telp'  => $order->user ? $order->user->phone_number : $order->no_telp,
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
        return ['No', 'Pelanggan', 'No. Telp', 'Produk', 'Detail', 'Metode Bayar', 'Total'];
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

                $sheet->insertNewRowBefore(1, 3);

                $tgl = \Carbon\Carbon::parse($this->tanggal)->translatedFormat('d F Y');

                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', 'Laporan Harian - ' . $tgl);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle('A4:G4')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A5F']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(16);
                $sheet->getColumnDimension('D')->setWidth(25);
                $sheet->getColumnDimension('E')->setWidth(12);
                $sheet->getColumnDimension('F')->setWidth(15);
                $sheet->getColumnDimension('G')->setWidth(18);

                $lastRow = $this->totalRows + 4;
                $sheet->getStyle('A4:G' . $lastRow)->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]]
                ]);

                $sheet->getStyle('G5:G' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle('A5:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('G5:G' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                $totalRow = $lastRow + 1;
                $sheet->mergeCells('A' . $totalRow . ':F' . $totalRow);
                $sheet->setCellValue('A' . $totalRow, 'TOTAL PENDAPATAN');
                $sheet->setCellValue('G' . $totalRow, '=SUM(G5:G' . $lastRow . ')');
                $sheet->getStyle('A' . $totalRow . ':G' . $totalRow)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
                ]);
                $sheet->getStyle('G' . $totalRow)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle('A' . $totalRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            }
        ];
    }
}