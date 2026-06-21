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

class PengeluaranSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
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
        $pengeluaran = Pengeluaran::whereDate('tanggal', '>=', $this->dari)
                        ->whereDate('tanggal', '<=', $this->sampai)
                        ->get();

        $this->totalRows = $pengeluaran->count();

        return $pengeluaran->map(function($item, $i) {
            return [
                'No'         => $i + 1,
                'Tanggal'    => \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y'),
                'Kategori'   => $item->kategori,
                'Keterangan' => $item->keterangan,
                'Metode'     => $item->metode_bayar,
                'Harga'      => $item->harga,
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Tanggal', 'Kategori', 'Keterangan', 'Metode Bayar', 'Harga (Rp)'];
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
                
                // 1. Geser data ke bawah untuk memberi ruang judul
                $sheet->insertNewRowBefore(1, 3);

                // 2. Judul
                $dari = \Carbon\Carbon::parse($this->dari)->translatedFormat('d F Y');
                $sampai = \Carbon\Carbon::parse($this->sampai)->translatedFormat('d F Y');
                
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'Laporan Pengeluaran ' . $dari . ' - ' . $sampai);
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 13],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // 3. Styling Header (Sekarang di baris 4)
                $sheet->getStyle('A4:F4')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A5F']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // 4. Lebar kolom
                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(14);
                $sheet->getColumnDimension('C')->setWidth(18);
                $sheet->getColumnDimension('D')->setWidth(30);
                $sheet->getColumnDimension('E')->setWidth(15);
                $sheet->getColumnDimension('F')->setWidth(18);

                // 5. Border (Mulai dari baris 4)
                $lastRow = $this->totalRows + 4;
                $sheet->getStyle('A4:F' . $lastRow)->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]]
                ]);

                // 6. Format angka
                $sheet->getStyle('F5:F' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle('A5:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F5:F' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                // 7. Baris total
                $totalRow = $lastRow + 1;
                $sheet->mergeCells('A' . $totalRow . ':E' . $totalRow);
                $sheet->setCellValue('A' . $totalRow, 'TOTAL PENGELUARAN');
                $sheet->setCellValue('F' . $totalRow, '=SUM(F5:F' . $lastRow . ')');
                $sheet->getStyle('A' . $totalRow . ':F' . $totalRow)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFEBEE']],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
                ]);
                $sheet->getStyle('F' . $totalRow)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle('A' . $totalRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            }
        ];
    }
}