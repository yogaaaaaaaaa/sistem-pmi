@extends('admin.layouts.app')

@section('content')

{{-- Alert notifikasi sukses --}}
@if(session('success'))
<div id="alert-success"
     class="mb-4 flex items-center gap-3 bg-green-100 text-green-700 px-4 py-3 rounded-lg shadow transition-all duration-500">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5 13l4 4L19 7" />
    </svg>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="p-6">

    {{-- Header halaman --}}
    <div class="flex flex-col gap-4 mb-6">
        <h1 class="text-2xl font-bold">Manajemen Berita</h1>

        {{-- Area pencarian dan aksi --}}
        <div class="flex justify-between items-center flex-wrap gap-3">

            {{-- Form pencarian --}}
            <form method="GET"
                  action="{{ route('admin.berita.index') }}"
                  class="flex gap-2 max-w-md w-full">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari Judul / Penulis..."
                       class="w-full border rounded-lg px-3 py-2">

                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Cari
                </button>

                @if(request('search'))
                <a href="{{ route('admin.berita.index') }}"
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                    Reset
                </a>
                @endif
            </form>

            {{-- Tombol tambah data --}}
            <button onclick="openCreate()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                + Tambah Berita
            </button>
        </div>
    </div>

    {{-- Tabel data berita --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border">
        <table class="w-full border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border-b p-3 text-left">Judul</th>
                    <th class="px-4 py-2">Gambar</th>
                    <th class="border-b p-3 text-left">Penulis</th>
                    <th class="border-b p-3 text-left">Tanggal</th>
                    <th class="border-b p-3 text-center w-40">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($data as $row)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-3 font-semibold">{{ $row->judul }}</td>

                    <td class="px-4 py-2">
                        @if($row->thumbnail)
                            <img src="{{ asset('storage/'.$row->thumbnail) }}"
                                 class="w-20 h-14 object-cover rounded">
                        @else
                            <span class="text-gray-400 text-sm">Tidak ada</span>
                        @endif
                    </td>

                    <td class="p-3">{{ $row->penulis }}</td>
                    <td class="p-3">{{ $row->created_at->format('d M Y') }}</td>

                    <td class="p-3 flex gap-2 justify-center">
                        {{-- Tombol edit --}}
                        <button onclick='openEdit(@json($row))'
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                            Edit
                        </button>

                        {{-- Form hapus data --}}
                        <form id="delete-form-{{ $row->id }}"
                              action="{{ route('admin.berita.destroy', $row->id) }}"
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
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        Data berita tidak ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $data->links() }}
    </div>
</div>

{{-- Modal form tambah & edit --}}
<div id="modalForm"
     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-2xl">

        <h2 id="modalTitle" class="text-xl font-bold mb-4">Tambah Berita</h2>

        <form id="beritaForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <input type="text" name="judul" id="judul"
                   placeholder="Judul Berita"
                   class="input" required>

            <input type="text" name="penulis" id="penulis"
                   placeholder="Penulis"
                   class="input">

            <input type="file"
                   name="thumbnail"
                   accept="image/*"
                   class="input">

            <textarea name="isi" id="isi"
                      rows="6"
                      placeholder="Isi berita..."
                      class="input" required></textarea>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal()"
                        class="border px-4 py-2 rounded">
                    Batal
                </button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Style input umum --}}
<style>
.input{
    width: 100%;
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 6px;
}
</style>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Menampilkan notifikasi sukses
document.addEventListener('DOMContentLoaded', () => {
    const alert = document.getElementById('alert-success');
    if (alert) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });

        setTimeout(() => alert.remove(), 3500);
    }
});

// Konfirmasi hapus data
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Berita?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

// Membuka modal tambah data
function openCreate() {
    const form = document.getElementById('beritaForm');
    form.action = "{{ route('admin.berita.store') }}";
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('modalTitle').innerText = 'Tambah Berita';
    form.reset();
    document.getElementById('modalForm').classList.remove('hidden');
}

// Membuka modal edit data
function openEdit(data) {
    const form = document.getElementById('beritaForm');
    form.action = `/admin/berita/${data.id}`;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('modalTitle').innerText = 'Edit Berita';

    document.getElementById('judul').value   = data.judul;
    document.getElementById('penulis').value = data.penulis;
    document.getElementById('isi').value     = data.isi;

    document.getElementById('modalForm').classList.remove('hidden');
}

// Menutup modal
function closeModal() {
    document.getElementById('modalForm').classList.add('hidden');
}
</script>

@endsection
