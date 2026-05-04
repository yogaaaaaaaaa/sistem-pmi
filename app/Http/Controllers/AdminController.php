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
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT BUKU TAMU
    |--------------------------------------------------------------------------
    */
    public function exportBukuTamu(Request $request)
    {
        return Excel::download(
            new BukuTamuExport($request->tahun, $request->bulan),
            'buku_tamu.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT PENEMPATAN (AUTO WILAYAH ADMIN)
    |--------------------------------------------------------------------------
    */
    public function importPenempatan(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    // simpan file
    $path = $request->file('file')->store('imports');

    $user = auth()->user();

    // import
    Excel::import(
        new PenempatanImport(
            $user->wilayah,
            $user->id
        ),
        $path 
    );

    return back()->with('success','Import berhasil.');
}

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD TEMPLATE
    |--------------------------------------------------------------------------
    */
    public function downloadTemplatePenempatan()
    {
        $path = public_path('template/template_penempatan.xlsx');

        if (!file_exists($path)) {
            abort(404, 'Template tidak ditemukan');
        }

        return response()->download($path, 'template_penempatan.xlsx');
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX HALAMAN
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        /*
        ===========================
        PENEMPATAN
        ===========================
        */
        if ($request->is('admin/penempatan*')) {

            $search = $request->search;
            $wilayah = $request->wilayah;

            $data = Penempatan::when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('id_pmi','like',"%$search%")
                          ->orWhere('wilayah','like',"%$search%")
                          ->orWhere('nama','like',"%$search%")
                          ->orWhere('negara','like',"%$search%")
                          ->orWhere('p3mi','like',"%$search%")
                          ->orWhere('paspor','like',"%$search%")
                          ->orWhere('tahun_berangkat','like',"%$search%");
                    });
                })
                ->when($wilayah, function ($query) use ($wilayah) {
                $query->where('wilayah', 'like', "%$wilayah%");
            })
                ->latest()
                ->paginate(10)
                ->withQueryString();

            return view('admin.penempatan.index', compact('data','search', 'wilayah'));
        }

        /*
        ===========================
        BERITA
        ===========================
        */
        if ($request->is('admin/berita*')) {

            $data = Berita::when($request->search, function ($query) use ($request) {
                    $query->where('judul','like','%'.$request->search.'%')
                          ->orWhere('penulis','like','%'.$request->search.'%');
                })
                ->latest()
                ->paginate(7)
                ->withQueryString();

            return view('admin.berita.index', compact('data'));
        }

        /*
        ===========================
        BUKU TAMU
        ===========================
        */
        if ($request->is('admin/bukutamu*')) {

            $data = BukuTamu::when($request->search, function ($query) use ($request) {
                    $query->where('nama','like','%'.$request->search.'%')
                          ->orWhere('alamat','like','%'.$request->search.'%')
                          ->orWhere('no_telpon','like','%'.$request->search.'%')
                          ->orWhere('negara','like','%'.$request->search.'%')
                          ->orWhere('sektor','like','%'.$request->search.'%')
                          ->orWhere('keperluan','like','%'.$request->search.'%')
                          ->orWhere('jenis_layanan','like','%'.$request->search.'%');
                })
                ->when($request->tahun, fn($q)=>$q->whereYear('created_at',$request->tahun))
                ->when($request->bulan, fn($q)=>$q->whereMonth('created_at',$request->bulan))
                ->latest()
                ->paginate(7)
                ->withQueryString();

            return view('admin.bukutamu.index', compact('data'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | STORE DATA
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        /*
        ===========================
        PENEMPATAN
        ===========================
        */
        if ($request->routeIs('admin.penempatan.store')) {

            $data = $request->all();

            // AUTO wilayah & user
            $data['wilayah'] = auth()->user()->wilayah;
            $data['user_id'] = auth()->id();

            Penempatan::create($data);
        }

        /*
        ===========================
        BERITA
        ===========================
        */
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

                $filename = Str::random(20).'.jpg';
                $path = storage_path('app/public/berita/'.$filename);

                Image::read($request->file('thumbnail'))
                    ->resizeDown(800)
                    ->toJpeg(80)
                    ->save($path);

                $data['thumbnail'] = 'berita/'.$filename;
            }

            Berita::create($data);
        }

        return back()->with('success','Data berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
{
    /*
    ===========================
    PENEMPATAN
    ===========================
    */
    if ($request->routeIs('admin.penempatan.update')) {

        $penempatan = Penempatan::findOrFail($id);

        // 🔥 CEK POLICY
        $this->authorize('update', $penempatan);

        $penempatan->update($request->all());
    }

    /*
    ===========================
    BERITA
    ===========================
    */
    if ($request->routeIs('admin.berita.update')) {

        $berita = Berita::findOrFail($id);

        $data = $request->validate([
            'judul'=>'required',
            'penulis'=>'nullable',
            'isi'=>'required',
            'thumbnail'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['slug'] = Str::slug($data['judul']);

        if ($request->hasFile('thumbnail')) {

            $filename = Str::random(20).'.jpg';
            $path = storage_path('app/public/berita/'.$filename);

            Image::read($request->file('thumbnail'))
                ->resizeDown(800)
                ->toJpeg(80)
                ->save($path);

            $data['thumbnail']='berita/'.$filename;
        }

        $berita->update($data);
    }

    return back()->with('success','Data berhasil diupdate');
}

    /*
    |--------------------------------------------------------------------------
    | DELETE DATA
    |--------------------------------------------------------------------------
    */
   public function destroy(Request $request, $id)
{
    /*
    ===========================
    PENEMPATAN
    ===========================
    */
    if ($request->routeIs('admin.penempatan.destroy')) {

        $penempatan = Penempatan::findOrFail($id);

        // cek policy wilayah
        $this->authorize('delete', $penempatan);

        $penempatan->delete();
    }

    /*
    ===========================
    BERITA
    ===========================
    */
    if ($request->routeIs('admin.berita.destroy')) {
        Berita::destroy($id);
    }

    /*
    ===========================
    BUKU TAMU
    ===========================
    */
    if ($request->routeIs('admin.bukutamu.destroy')) {
        BukuTamu::destroy($id);
    }

    return back()->with('success','Data berhasil dihapus');
}
}
