<?php

namespace App\Http\Controllers;

use App\Models\Penempatan;
use App\Models\Berita;
use App\Models\BukuTamu;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    // Menampilkan halaman beranda beserta daftar berita terbaru
    public function beranda(Request $request)
    {
        $beritaTerbaru = Berita::latest()->take(3)->get();

        return view('beranda', compact('beritaTerbaru'));
    }

    // Menampilkan halaman daftar seluruh berita dengan paginasi
    public function beritaIndex()
    {
        $semuaBerita = Berita::latest()->paginate(10);

        return view('berita.index', compact('semuaBerita'));
    }

    // Menampilkan detail berita dan menambahkan jumlah tayangan (views)
    public function show(Berita $berita)
    {
        $key = 'berita_viewed_' . $berita->id;

        if (!session()->has($key)) {
            $berita->increment('views');
            session()->put($key, true);
        }

        return view('berita.show', compact('berita'));
    }

    // Menampilkan daftar data penempatan pekerja migran dengan paginasi
    public function penempatanIndex()
    {
        $penempatan = Penempatan::latest()->paginate(20);

        return view('penempatan.index', compact('penempatan'));
    }

    // Memvalidasi dan menyimpan data buku tamu baru ke database
    public function bukuTamuStore(Request $request)
    {

        $request->validate([
            'nama'          => 'required',
            'alamat'        => 'required',
            'no_telpon'     => 'required',
            'negara'        => 'required',
            'sektor'        => 'required',
            'keperluan'     => 'required',
            'jenis_layanan' => 'required',
        ]);

        BukuTamu::create($request->only(
            'nama', 
            'alamat', 
            'no_telpon', 
            'negara', 
            'sektor', 
            'keperluan', 
            'jenis_layanan'
        ));

        return back()->with('success', 'Terima kasih! Data berhasil dikirim.');
    }
}