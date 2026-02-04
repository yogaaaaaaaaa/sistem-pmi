<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\BukuTamu;
use App\Models\Penempatan;
use App\Imports\PenempatanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use App\Exports\BukuTamuExport;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Menampilkan halaman dashboard utama
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Mengunduh rekap data buku tamu dalam format Excel
    public function exportBukuTamu(Request $request)
    {
        return Excel::download(
            new BukuTamuExport($request->tahun, $request->bulan),
            'buku_tamu.xlsx'
        );
    }

    // Memproses impor data penempatan menggunakan antrean (queue)
    public function importPenempatan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        // Simpan file sementara agar bisa dibaca oleh sistem antrean
        $path = $request->file('file')->store('imports');

        // Jalankan proses impor di latar belakang
        Excel::import(new PenempatanImport, $path);

        return back()->with(
            'success',
            'Import sedang diproses di background. Data akan masuk bertahap.'
        );
    }

    // Mengunduh template file Excel untuk kebutuhan impor data
    public function downloadTemplatePenempatan()
    {
        $path = public_path('template/template_penempatan.xlsx');

        if (!file_exists($path)) {
            abort(404, 'Template tidak ditemukan');
        }

        return response()->download($path, 'template_penempatan.xlsx');
    }

    // Menampilkan daftar data berdasarkan halaman yang sedang diakses
    public function index(Request $request)
    {
        // Logika tampilan untuk halaman data penempatan
        if ($request->is('admin/penempatan*')) {
            $search = $request->search;

            $data = Penempatan::when($search, function ($query) use ($search) {
                $query->where('id_pmi', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('negara', 'like', "%{$search}%")
                    ->orWhere('p3mi', 'like', "%{$search}%")
                    ->orWhere('paspor', 'like', "%{$search}%")
                    ->orWhere('tahun_berangkat', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(7)
            ->withQueryString();

            return view('admin.penempatan.index', compact('data', 'search'));
        }

        // Logika tampilan untuk halaman berita
        if ($request->is('admin/berita*')) {
            $data = Berita::when($request->search, function ($query) use ($request) {
                $query->where('judul', 'like', '%' . $request->search . '%')
                    ->orWhere('penulis', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(7)
            ->withQueryString();

            return view('admin.berita.index', compact('data'));
        }

        // Logika tampilan untuk halaman buku tamu
        if ($request->is('admin/bukutamu*')) {
            $data = BukuTamu::when($request->search, function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('alamat', 'like', '%' . $request->search . '%')
                    ->orWhere('jenis_layanan', 'like', '%' . $request->search . '%');
            })
            ->when($request->tahun, function ($query) use ($request) {
                $query->whereYear('created_at', $request->tahun);
            })
            ->when($request->bulan, function ($query) use ($request) {
                $query->whereMonth('created_at', $request->bulan);
            })
            ->latest()
            ->paginate(7)
            ->withQueryString();

            return view('admin.bukutamu.index', compact('data'));
        }
    }

    // Menyimpan data baru ke database
    public function store(Request $request)
    {
        if ($request->routeIs('admin.penempatan.store')) {
            Penempatan::create($request->all());
        }

        if ($request->routeIs('admin.berita.store')) {
            $data = $request->validate([
                'judul'     => 'required',
                'penulis'   => 'nullable',
                'isi'       => 'required',
                'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $data['slug']  = Str::slug($data['judul']);
            $data['views'] = 0;

            if ($request->hasFile('thumbnail')) {
                $image = $request->file('thumbnail');
                $filename = Str::random(20) . '.jpg';
                $path = storage_path('app/public/berita/' . $filename);

                Image::read($image)
                    ->resizeDown(800)
                    ->toJpeg(80)
                    ->save($path);

                $data['thumbnail'] = 'berita/' . $filename;
            }

            Berita::create($data);
        }

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    // Memperbarui data yang sudah ada
    public function update(Request $request, $id)
    {
        if ($request->routeIs('admin.penempatan.update')) {
            Penempatan::findOrFail($id)->update($request->all());
        }

        if ($request->routeIs('admin.berita.update')) {
            $berita = Berita::findOrFail($id);

            $data = $request->validate([
                'judul'     => 'required',
                'penulis'   => 'nullable',
                'isi'       => 'required',
                'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $data['slug'] = Str::slug($data['judul']);

            if ($request->hasFile('thumbnail')) {
                $image = $request->file('thumbnail');
                $filename = Str::random(20) . '.jpg';
                $path = storage_path('app/public/berita/' . $filename);

                Image::read($image)
                    ->resizeDown(800)
                    ->toJpeg(80)
                    ->save($path);

                $data['thumbnail'] = 'berita/' . $filename;
            }

            $berita->update($data);
        }

        return back()->with('success', 'Data berhasil diupdate');
    }

    // Menghapus data dari database
    public function destroy(Request $request, $id)
    {
        if ($request->routeIs('admin.penempatan.destroy')) {
            Penempatan::destroy($id);
        }

        if ($request->routeIs('admin.berita.destroy')) {
            Berita::destroy($id);
        }

        if ($request->routeIs('admin.bukutamu.destroy')) {
            BukuTamu::destroy($id);
        }

        return back()->with('success', 'Data berhasil dihapus');
    }
}