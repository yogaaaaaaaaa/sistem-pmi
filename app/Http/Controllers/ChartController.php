<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penempatan;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    // Mengambil data statistik penempatan dikelompokkan berdasarkan tahun keberangkatan
    public function penempatan(Request $request)
    {
        $query = Penempatan::query();

        if ($request->has('negara') && $request->negara != 'all') {
            $query->where('negara', $request->negara);
        }

        $data = $query->select(
            'tahun_berangkat as tahun',
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('tahun_berangkat')
            ->orderBy('tahun_berangkat', 'ASC')
            ->get();

        return response()->json([
            'labels' => $data->pluck('tahun'),
            'data'   => $data->pluck('total')
        ]);
    }
}