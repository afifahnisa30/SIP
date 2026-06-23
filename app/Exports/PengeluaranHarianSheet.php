<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PengeluaranHarianSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    protected $tanggal;
    protected $totalRows;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        $pengeluaran = Pengeluaran::whereDate('tanggal', $this->tanggal)
                        ->orderBy('tanggal', 'asc')
                        ->get();

        $this->totalRows = $pengeluaran->count();

        return $pengeluaran->map(function($item, $i) {
            return [
                'No'         => $i + 1,
                'Kategori'   => $item->kategori,
                'Keterangan' => $item->keterangan,
                'Metode'     => $item->metode_bayar,
                'Harga'      => $item->harga,
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Kategori', 'Keterangan', 'Metode Bayar', 'Harga'];
    }

    public function title(): string
    {
        return 'Pengeluaran';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->insertNewRowBefore(1, 3);

                $tgl = \Carbon\Carbon::parse($this->tanggal)->translatedFormat('d F Y');

                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', 'Laporan Pengeluaran Harian - ' . $tgl);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle('A4:E4')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A5F']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(18);
                $sheet->getColumnDimension('C')->setWidth(30);
                $sheet->getColumnDimension('D')->setWidth(15);
                $sheet->getColumnDimension('E')->setWidth(18);

                $lastRow = $this->totalRows + 4;
                $sheet->getStyle('A4:E' . $lastRow)->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]]
                ]);

                $sheet->getStyle('E5:E' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle('A5:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E5:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                $totalRow = $lastRow + 1;
                $sheet->mergeCells('A' . $totalRow . ':D' . $totalRow);
                $sheet->setCellValue('A' . $totalRow, 'TOTAL PENGELUARAN');
                $sheet->setCellValue('E' . $totalRow, '=SUM(E5:E' . $lastRow . ')');
                $sheet->getStyle('A' . $totalRow . ':E' . $totalRow)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFEBEE']],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
                ]);
                $sheet->getStyle('E' . $totalRow)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle('A' . $totalRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            }
        ];
    }
}