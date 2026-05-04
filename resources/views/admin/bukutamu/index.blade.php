@extends('admin.layouts.app')

@section('content')
<div class="p-6">

    {{-- Header halaman --}}
    <div class="mb-4">
        <h1 class="text-2xl font-bold">Buku Tamu / Ulasan Masyarakat</h1>
    </div>

    {{-- Form pencarian --}}
    <form method="GET"
          action="{{ route('admin.bukutamu.index') }}"
          class="flex gap-2 mb-4 max-w-md">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari Nama / Alamat / Ulasan..."
               class="w-full border rounded-lg px-3 py-2">

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Cari
        </button>

        @if(request('search'))
            <a href="{{ route('admin.bukutamu.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Reset
            </a>
        @endif
    </form>

    {{-- Filter tahun & bulan serta export data --}}
    <form method="GET"
          action="{{ route('admin.bukutamu.index') }}"
          class="flex gap-2 mb-4 items-center">

        {{-- Filter tahun --}}
        <select name="tahun" class="border rounded-lg px-3 pr-10 py-2">
            <option value="">Semua Tahun</option>
            @for($y = now()->year; $y >= 2020; $y--)
                <option value="{{ $y }}" @selected(request('tahun') == $y)>
                    {{ $y }}
                </option>
            @endfor
        </select>

        {{-- Filter bulan --}}
        <select name="bulan" class="border rounded-lg px-3 pr-10 py-2">
            <option value="">Semua Bulan</option>
            @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" @selected(request('bulan') == $m)>
                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
            @endfor
        </select>

        {{-- Tombol filter --}}
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <i class="fa fa-filter"></i>
            Filter
        </button>

        {{-- Tombol export Excel --}}
        <a href="{{ route('admin.bukutamu.export', request()->query()) }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <i class="fa fa-file-excel"></i>
            Export Excel
        </a>
    </form>

    {{-- Tabel data buku tamu --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border">
        <table class="w-full border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border-b p-3 text-left">Nama</th>
                    <th class="border-b p-3 text-left">Alamat</th>
                    <th class="border-b p-3 text-left">Nomor Telpon</th>
                    <th class="border-b p-3 text-left">Negara</th>
                    <th class="border-b p-3 text-left">Sektor</th>
                    <th class="border-b p-3 text-left">Keperluan</th>
                    <th class="border-b p-3 text-left">Jenis Layanan</th>
                    <th class="border-b p-3 text-left">Tanggal</th>
                    <th class="border-b p-3 text-center w-28">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($data as $row)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-3 font-semibold">{{ $row->nama }}</td>
                    <td class="p-3">{{ $row->alamat }}</td>
                    <td class="p-3">{{ $row->no_telpon }}</td>
                    <td class="p-3">{{ $row->negara }}</td>
                    <td class="p-3">{{ $row->sektor }}</td>
                    <td class="p-3">{{ $row->keperluan }}</td>
                    <td class="p-3">{{ $row->jenis_layanan }}</td>
                    <td class="p-3">{{ $row->created_at->format('d M Y') }}</td>

                    <td class="p-3 text-center">
                        {{-- Form hapus data --}}
                        <form id="delete-form-{{ $row->id }}"
                              action="{{ route('admin.bukutamu.destroy', $row->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="button"
                                    onclick="confirmDelete({{ $row->id }})"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    {{-- Colspan diubah jadi 8 karena nambah 3 kolom --}}
                    <td colspan="8" class="p-6 text-center text-gray-500">
                        Belum ada data buku tamu
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($data->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $data->links() }}
        </div>
    @endif
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

{{-- Notifikasi sukses --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

@endsection