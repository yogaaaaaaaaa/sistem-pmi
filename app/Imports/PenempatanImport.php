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

    protected $wilayah;
    protected $user_id;

    public function __construct($wilayah, $user_id)
    {
        $this->wilayah = $wilayah;
        $this->user_id = $user_id;
    }

    public function model(array $row)
    {
        // skip kalau data wajib kosong
        if (
            empty($row['id_pmi']) ||
            empty($row['nama']) ||
            empty($row['paspor'])
        ) {
            return null;
        }

        // skip duplicate paspor
        if (Penempatan::where('paspor', $row['paspor'])->exists()) {
            return null;
        }

        return new Penempatan([
            'user_id'         => $this->user_id,
            'wilayah'         => $this->wilayah,
            'id_pmi'          => trim($row['id_pmi']),
            'nama'            => trim($row['nama']),
            'negara'          => $row['negara'] ?? null,
            'p3mi'            => $row['p3mi'] ?? null,
            'paspor'          => trim($row['paspor']),
            'tahun_berangkat' => $row['tahun_berangkat'] ?? null,
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}