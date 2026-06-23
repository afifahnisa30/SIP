<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanHarianExport implements WithMultipleSheets
{
    protected $tanggal;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function sheets(): array
    {
        return [
            new TransaksiHarianSheet($this->tanggal),
            new PengeluaranHarianSheet($this->tanggal),
        ];
    }
}