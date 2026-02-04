@extends('layouts.frontend')

@section('content')

<main class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto p-6">

        {{-- Judul halaman --}}
        <header class="text-center mb-5">
            <h1 class="text-4xl font-extrabold text-gray-800">Berita Terkini</h1>
            <p class="text-gray-500">Daftar lengkap berita dari Sistem Informasi PMI</p>
        </header>

        {{-- Tombol kembali ke beranda --}}
        <div class="mb-6">
            <a href="{{ route('beranda') }}#berita"
               class="text-gray-600 hover:text-black font-bold flex items-center gap-2 transition">
                &larr; Kembali ke Beranda
            </a>
        </div>

        {{-- Daftar berita --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($semuaBerita as $berita)
                <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col justify-between h-full hover:shadow-xl transition">
                    
                    {{-- Informasi dan ringkasan berita --}}
                    <div>
                        <p class="text-sm text-gray-500 mb-2">
                            {{ \Carbon\Carbon::parse($berita->created_at)->isoFormat('DD MMMM YYYY') }}
                        </p>

                        <img src="{{ asset('storage/'.$berita->thumbnail) }}"
                             alt="{{ $berita->judul }}"
                             class="w-full h-48 object-cover rounded-md mb-4">

                        <p class="text-base text-gray-700 line-clamp-5">
                            {{ Str::limit(strip_tags($berita->isi), 200) }}
                        </p>
                    </div>

                    {{-- Tombol detail berita --}}
                    <div class="mt-4">
                        <a href="{{ route('berita.show', $berita->slug) }}"
                           class="inline-block bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition">
                            Baca Detail
                        </a>
                    </div>
                </div>
            @empty
                {{-- Kondisi jika data kosong --}}
                <p class="col-span-3 text-center text-gray-500">
                    Belum ada berita yang tersedia.
                </p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-5">
            {{ $semuaBerita->links() }}
        </div>

    </div>
</main>

@endsection
