<?php

namespace App\Imports;

use App\Models\Penempatan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class PenempatanImport implements
    ToModel,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts,
    ShouldQueue,
    SkipsOnError,
    SkipsEmptyRows
{
    use SkipsErrors;

    // Memetakan setiap baris data dari file Excel ke dalam model database
    public function model(array $row)
    {
        // Melewati proses impor jika kolom wajib tidak memiliki data
        if (empty($row['id_pmi']) || empty($row['nama']) || empty($row['paspor'])) {
            return null;
        }

        return new Penempatan([
            'id_pmi'          => trim($row['id_pmi']),
            'nama'            => trim($row['nama']),
            'negara'          => $row['negara'] ?? null,
            'p3mi'            => $row['p3mi'] ?? null,
            'paspor'          => trim($row['paspor']),
            'tahun_berangkat' => $row['tahun_berangkat'] ?? null,
        ]);
    }

    // Membatasi pembacaan file Excel per 1000 baris untuk menjaga performa memori
    public function chunkSize(): int
    {
        return 1000;
    }

    // Mengirim data ke database dalam kelompok 1000 baris untuk mempercepat proses
    public function batchSize(): int
    {
        return 1000;
    }
}