<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penempatan extends Model
{
    protected $table = 'penempatans';
    protected $fillable = ['id_pmi', 'nama', 'negara', 'p3mi', 'paspor', 'tahun_berangkat'];
}
