<?php

namespace App\Exports;

// use App\Models\Order;
// use App\Models\Pengeluaran;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\TransaksiSheet;
use App\Exports\PengeluaranSheet;

class LaporanPeriodeExport implements WithMultipleSheets
{
    protected $dari;
    protected $sampai;

    public function __construct($dari, $sampai)
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
    }

    public function sheets(): array
    {
        return [
            new TransaksiSheet($this->dari, $this->sampai),
            new PengeluaranSheet($this->dari, $this->sampai),
        ];
    }
}