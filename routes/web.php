<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Aplikasi Web
|--------------------------------------------------------------------------
*/

// --- RUTE FRONTEND (PUBLIK) ---

// Menampilkan halaman utama (Beranda)
Route::get('/', [FrontendController::class, 'beranda'])->name('beranda');

// Mengambil data JSON untuk grafik statistik
Route::get('/chart/penempatan', [ChartController::class, 'penempatan'])->name('chart.penempatan');

// Menampilkan daftar data penempatan
Route::get('/penempatan-list', [FrontendController::class, 'penempatanIndex'])->name('penempatan.index');

// Menampilkan daftar dan detail berita
Route::get('/berita-list', [FrontendController::class, 'beritaIndex'])->name('berita.index');
Route::get('/berita/{berita}', [FrontendController::class, 'show'])->name('berita.show');

// Menampilkan halaman statis tentang kami
Route::view('/tentang-page', 'tentang.index')->name('tentang.index');

// Menampilkan form dan memproses kiriman buku tamu
Route::get('/bukutamu-page', [FrontendController::class, 'bukuTamuIndex'])->name('bukutamu.index');
Route::post('/bukutamu-store', [FrontendController::class, 'bukuTamuStore'])->name('bukutamu.store');

// Menampilkan detail proses penempatan secara langsung
Route::get('/proses/{id}', function ($id) {
    return view('proses.show', ['id' => $id]);
})->name('proses.show');


// --- RUTE BACKEND (ADMINISTRATOR) ---

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard utama admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Data grafik khusus tampilan admin
        Route::get('/chart/penempatan', [ChartController::class, 'penempatan'])->name('chart.penempatan');
        Route::get('/chart/negara', [ChartController::class, 'negara'])->name('chart.negara');
        Route::get('/chart/wilayah', [ChartController::class, 'wilayah'])->name('chart.wilayah');

        // Manajemen data penempatan (CRUD)
        Route::get('/penempatan', [AdminController::class, 'index'])->name('penempatan.index');
        Route::post('/penempatan', [AdminController::class, 'store'])->name('penempatan.store');
        Route::put('/penempatan/{id}', [AdminController::class, 'update'])->name('penempatan.update');
        Route::delete('/penempatan/{id}', [AdminController::class, 'destroy'])->name('penempatan.destroy');

        // Fitur impor data dan unduh template excel
        Route::post('/penempatan/import', [AdminController::class, 'importPenempatan'])->name('penempatan.import');
        Route::get('/penempatan/template', [AdminController::class, 'downloadTemplatePenempatan'])->name('penempatan.template');

        // Manajemen data berita (CRUD)
        Route::get('/berita', [AdminController::class, 'index'])->name('berita.index');
        Route::post('/berita', [AdminController::class, 'store'])->name('berita.store');
        Route::put('/berita/{id}', [AdminController::class, 'update'])->name('berita.update');
        Route::delete('/berita/{id}', [AdminController::class, 'destroy'])->name('berita.destroy');

        // Manajemen data buku tamu
        Route::get('/bukutamu', [AdminController::class, 'index'])->name('bukutamu.index');
        Route::get('/bukutamu/export', [AdminController::class, 'exportBukuTamu'])->name('bukutamu.export');
        Route::delete('/bukutamu/{id}', [AdminController::class, 'destroy'])->name('bukutamu.destroy');
    });

require __DIR__.'/auth.php';