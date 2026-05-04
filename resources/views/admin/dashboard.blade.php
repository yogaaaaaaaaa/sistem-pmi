@extends('admin.layouts.app')

@section('content')

<div class="p-6 flex flex-col">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
    </div>

    {{-- Navigasi --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('admin.penempatan.index') }}"
           class="bg-blue-600 text-white p-6 rounded shadow hover:bg-blue-700 transition">
            <span class="font-semibold text-lg">Penempatan PMI</span>
            <p class="text-sm opacity-80 mt-1">Kelola data penempatan</p>
        </a>

        <a href="{{ route('admin.berita.index') }}"
           class="bg-green-600 text-white p-6 rounded shadow hover:bg-green-700 transition">
            <span class="font-semibold text-lg">Berita</span>
            <p class="text-sm opacity-80 mt-1">Kelola informasi</p>
        </a>

        <a href="{{ route('admin.bukutamu.index') }}"
           class="bg-yellow-500 text-white p-6 rounded shadow hover:bg-yellow-600 transition">
            <span class="font-semibold text-lg">Buku Tamu</span>
            <p class="text-sm opacity-80 mt-1">Data pengunjung</p>
        </a>
    </div>

    {{-- Grafik --}}
<div class="bg-white p-6 rounded-xl shadow border">

    <div class="flex justify-between items-center mb-4 flex-wrap gap-3">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">Penempatan PMI</h2>
            <p class="text-sm text-gray-500">Statistik per tahun</p>
        </div>

        <div class="flex gap-3">

            {{-- FILTER WILAYAH --}}
            <select id="filterWilayah"
                class="border rounded-lg px-4 pr-10 py-2 text-sm bg-white shadow-sm">
                <option value="all">Semua Wilayah</option>
                <option value="tangerang">Tangerang</option>
                <option value="serang">Serang</option>
            </select>

            {{-- FILTER NEGARA --}}
            <select id="filterNegara"
                class="border rounded-lg px-4 pr-10 py-2 text-sm bg-white shadow-sm">
                <option value="all">Semua Negara</option>
                <option value="Taiwan">Taiwan</option>
                <option value="Hongkong">Hongkong</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Singapore">Singapore</option>
                <option value="Jepang">Jepang</option>
                <option value="Korea">Korea</option>
            </select>

        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Chart Tahunan -->
    <canvas id="chartTahunan"></canvas>

</div>

@endsection
