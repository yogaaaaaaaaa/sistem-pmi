@extends('layouts.frontend')

@section('content')

<main class="relative container mx-auto py-12 px-6 max-w-4xl">
    <div class="max-w-4xl bg-white rounded-lg shadow p-6 md:p-10">

        {{-- Judul berita --}}
        <h1 class="text-3xl text-center font-bold mb-4">
            {{ $berita->judul }}
        </h1>

        {{-- Thumbnail berita --}}
        @if($berita->thumbnail)
            <img src="{{ asset('storage/'.$berita->thumbnail) }}"
                 class="w-full max-h-[400px] object-cover rounded mb-4"
                 alt="{{ $berita->judul }}">
        @endif

        {{-- Informasi berita --}}
        <p class="text-sm text-gray-500 mb-4">
            {{ $berita->created_at->isoFormat('DD MMMM YYYY') }}
            | Penulis: {{ $berita->penulis }}
            | 👁 {{ $berita->views }}
        </p>

        {{-- Konten berita --}}
        <article class="prose prose-lg max-w-none text-gray-800 leading-relaxed text-justify whitespace-pre-line">
            {!! $berita->isi !!}
        </article>

        {{-- Navigasi kembali --}}
        <a href="{{ route('berita.index') }}"
           class="inline-block mt-8 text-blue-600 hover:underline">
            ← Kembali ke Berita
        </a>

    </div>
</main>

@endsection
