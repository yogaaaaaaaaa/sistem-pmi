<?php

namespace App\Exports;

use App\Models\BukuTamu;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BukuTamuExport implements FromView, ShouldAutoSize
{
    protected $tahun;
    protected $bulan;

    public function __construct($tahun, $bulan)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        
        $data = BukuTamu::when($this->tahun, function ($q) {
                $q->whereYear('created_at', $this->tahun);
            })
            ->when($this->bulan, function ($q) {
                $q->whereMonth('created_at', $this->bulan);
            })
            ->latest()
            ->get();

        return view('exports.bukutamu', [
            'data' => $data
        ]);
    }
}
