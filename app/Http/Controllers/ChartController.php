<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penempatan;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    // ===============================
    // 1. Grafik Tahunan
    // ===============================
    public function penempatan(Request $request)
    {
        $query = Penempatan::query();

        if ($request->negara && $request->negara != 'all') {
            $query->where('negara', $request->negara);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER WILAYAH DIPILIH
        |--------------------------------------------------------------------------
        */
        if ($request->wilayah && $request->wilayah != 'all') {

            $data = $query
                ->where('wilayah', $request->wilayah)
                ->select(
                    'tahun_berangkat as tahun',
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('tahun_berangkat')
                ->orderBy('tahun_berangkat')
                ->get();

            return response()->json([
                'labels' => $data->pluck('tahun'),
                'datasets' => [
                    [
                        'label' => $request->wilayah,
                        'data' => $data->pluck('total'),
                        'borderWidth' => 3,
                        'tension' => .4,
                        'fill' => true
                    ]
                ]
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | DEFAULT → SEMUA WILAYAH + TOTAL
        |--------------------------------------------------------------------------
        */

        $data = $query->select(
                'tahun_berangkat as tahun',
                'wilayah',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('tahun_berangkat','wilayah')
            ->orderBy('tahun_berangkat')
            ->get();

        $tahun = $data->pluck('tahun')->unique()->values();

        $tangerang = [];
        $serang = [];
        $total = [];

        foreach ($tahun as $t) {

            $tang = $data->filter(function($item) use ($t) {
                return $item->tahun == $t && stripos($item->wilayah ?? '', 'tangerang') !== false;
            })->sum('total');

            $ser = $data->filter(function($item) use ($t) {
                return $item->tahun == $t && stripos($item->wilayah ?? '', 'serang') !== false;
            })->sum('total');

            $tangerang[] = $tang;
            $serang[] = $ser;
            $total[] = $tang + $ser;
        }

        return response()->json([
            'labels' => $tahun,
            'datasets' => [
                [
                    'label'=>'Tangerang',
                    'data'=>$tangerang,
                    'borderColor' => '#36A2EB', // Warna Biru
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderWidth'=>3,
                    'tension'=>.4,
                    'fill'=>true
                ],
                [
                    'label'=>'Serang',
                    'data'=>$serang,
                    'borderColor' => '#FF6384', // Warna Pink
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderWidth'=>3,
                    'tension'=>.4,
                    'fill'=>true
                ],
                [
                    'label'=>'Total',
                    'data'=>$total,
                    'borderColor' => '#FF9F40', // Warna Orange
                    'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                    'borderWidth'=>4,
                    'tension'=>.4,
                    'fill'=>true
                ]
            ]
        ]);
    }
}