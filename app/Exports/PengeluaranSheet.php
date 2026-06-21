<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengeluaranSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
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
        $pengeluaran = Pengeluaran::whereDate('tanggal', '>=', $this->dari)
                        ->whereDate('tanggal', '<=', $this->sampai)
                        ->get();

        return $pengeluaran->map(function($item, $i) {
            return [
                'No'          => $i + 1,
                'Tanggal'     => \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y'),
                'Kategori'    => $item->kategori,
                'Keterangan'  => $item->keterangan,
                'Metode'      => $item->metode_bayar,
                'Harga'       => $item->harga,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No', 'Tanggal', 'Kategori',
            'Keterangan', 'Metode Bayar', 'Harga (Rp)'
        ];
    }

    public function title(): string
    {
        return 'Pengeluaran';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}