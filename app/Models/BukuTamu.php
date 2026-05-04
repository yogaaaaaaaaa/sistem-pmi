<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
    protected $table = 'buku_tamus';
    protected $fillable = ['nama', 'alamat','no_telpon','negara','sektor','keperluan', 'jenis_layanan'];
}
