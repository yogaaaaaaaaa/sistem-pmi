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
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-4">
        <h1 class="text-2xl font-bold">Manajemen Penempatan</h1>

        {{-- Download Template Import --}}
        <a href="{{ route('admin.penempatan.template') }}"
           class="bg-gray-600 text-white px-4 py-2 rounded flex items-center gap-2">
            📥 Download Template Excel
        </a>
    </div>

    {{-- ================= SEARCH & ACTION ================= --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">

        {{-- SEARCH --}}
        <form method="GET"
              action="{{ route('admin.penempatan.index') }}"
              class="flex items-center gap-2 w-full md:w-auto">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari ID PMI, Nama, Negara, P3MI, Paspor..."
                   class="w-full md:w-80 border rounded-lg px-4 py-2 text-sm">

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Cari
            </button>

            @if(request()->filled('search'))
            <a href="{{ route('admin.penempatan.index') }}"
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm font-semibold">
                Reset
            </a>
            @endif
        </form>

        {{-- IMPORT & TAMBAH DATA --}}
        <div class="flex items-center gap-3">

            {{-- Import Excel --}}
            <form action="{{ route('admin.penempatan.import') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="flex items-center gap-2 bg-white px-3 py-2 rounded-lg shadow border">
                @csrf

                <label class="flex items-center gap-2 cursor-pointer">
                    <span class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-2 rounded-lg text-sm font-semibold">
                        Pilih File
                    </span>

                    <span id="fileName"
                          class="text-gray-500 text-sm truncate max-w-[120px]">
                        Belum ada file
                    </span>

                    <input type="file"
                           name="file"
                           required
                           class="hidden"
                           onchange="document.getElementById('fileName').innerText = this.files[0]?.name">
                </label>

                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Import
                </button>
            </form>

            {{-- Tambah Data --}}
            <button onclick="openCreate()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow">
                + Tambah
            </button>
        </div>
    </div>

    {{-- Tabel data penempatan --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border">
        <table class="w-full border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border-b p-3 text-left">ID PMI</th>
                    <th class="border-b p-3 text-left">Nama</th>
                    <th class="border-b p-3 text-left">Negara</th>
                    <th class="border-b p-3 text-left">P3MI</th>
                    <th class="border-b p-3 text-left">Paspor</th>
                    <th class="border-b p-3 text-left">Tahun Berangkat</th>
                    <th class="border-b p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($data as $row)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-3">{{ $row->id_pmi }}</td>
                    <td class="p-3">{{ $row->nama }}</td>
                    <td class="p-3">{{ $row->negara }}</td>
                    <td class="p-3">{{ $row->p3mi }}</td>
                    <td class="p-3">{{ $row->paspor }}</td>
                    <td class="p-3">{{ $row->tahun_berangkat }}</td>
                    <td class="p-3 flex gap-2 justify-center">

                        {{-- Edit --}}
                        <button onclick='openEdit(@json($row))'
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                            Edit
                        </button>

                        {{-- Hapus --}}
                        <form id="delete-form-{{ $row->id }}"
                              action="{{ route('admin.penempatan.destroy', $row->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="button"
                                    onclick="confirmDelete({{ $row->id }})"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-6 text-center text-gray-500">
                        Data tidak ditemukan
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

    {{-- Modal form tambah & edit --}}
    <div id="modalForm"
         class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

        <div class="bg-white p-6 rounded-lg w-full max-w-lg">
            <h2 id="modalTitle" class="text-xl font-bold mb-4"></h2>

            <form id="penempatanForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod">

                <input type="text" name="id_pmi" id="id_pmi" placeholder="ID PMI" class="input" required>
                <input type="text" name="nama" id="nama" placeholder="Nama" class="input" required>
                <input type="text" name="negara" id="negara" placeholder="Negara" class="input" required>
                <input type="text" name="p3mi" id="p3mi" placeholder="P3MI" class="input" required>
                <input type="text" name="paspor" id="paspor" placeholder="No Paspor" class="input" required>
                <input type="number" name="tahun_berangkat" id="tahun_berangkat" placeholder="Tahun Berangkat" class="input" required>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeModal()" class="border px-4 py-2 rounded">
                        Batal
                    </button>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= STYLE ================= --}}
<style>
.input {
    width: 100%;
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 6px;
}
</style>

{{-- ================= SCRIPT ================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
/**
 * Menampilkan notifikasi sukses menggunakan SweetAlert
 */
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('alert-success')) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    }
});

/**
 * Konfirmasi hapus data
 */
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Data Penempatan?',
        text: 'Data yang dihapus tidak dapat dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then(result => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

/**
 * Buka modal tambah data
 */
function openCreate() {
    modalForm.classList.remove('hidden');
    modalTitle.innerText = 'Tambah Penempatan';

    penempatanForm.action = "{{ route('admin.penempatan.store') }}";
    formMethod.value = 'POST';
    penempatanForm.reset();
}

/**
 * Buka modal edit data
 */
function openEdit(data) {
    modalForm.classList.remove('hidden');
    modalTitle.innerText = 'Edit Penempatan';

    penempatanForm.action = `/admin/penempatan/${data.id}`;
    formMethod.value = 'PUT';

    id_pmi.value = data.id_pmi;
    nama.value = data.nama;
    negara.value = data.negara;
    p3mi.value = data.p3mi;
    paspor.value = data.paspor;
    tahun_berangkat.value = data.tahun_berangkat;
}

/**
 * Tutup modal
 */
function closeModal() {
    modalForm.classList.add('hidden');
}
</script>
@endsection
