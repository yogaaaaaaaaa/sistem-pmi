@extends('layouts.frontend')

{{-- Definisi data manual untuk keperluan konten halaman --}}
@php
    $dataManual = [
        1 => [
            'judul'  => 'G to G (Government to Government)',
            'gambar' => 'images/show/g-to-g.jpg',
            'konten' => 'Adalah program kerja sama resmi antar pemerintah (Indonesia dengan Jepang, Korea Selatan, Jerman, dll.) untuk menempatkan tenaga kerja Indonesia secara legal dan aman ke luar negeri. Program ini mengurus rekrutmen, pelatihan, hingga penempatan tanpa perantara swasta, menawarkan perlindungan, gaji kompetitif, dan biaya lebih terjangkau karena ada subsidi pemerintah, terutama untuk sektor seperti perawat dan manufaktur.',
            'negara' => [
                [
                    'nama'       => 'Jepang',
                    'bendera'    => 'https://flagcdn.com/w320/jp.png',
                    'popup'      => 'images/g-to-g/jepang.png',
                    'direktorat' => 'Direktorat Penempatan Pemerintah Kawasan Asia dan Afrika'
                ],
                [
                    'nama'       => 'Korea Selatan',
                    'bendera'    => 'https://flagcdn.com/w320/kr.png',
                    'popup'      => 'images/g-to-g/korea-selatan.png',
                    'direktorat' => 'Direktorat Penempatan Pemerintah Kawasan Asia dan Afrika'
                ],
                [
                    'nama'       => 'Jerman',
                    'bendera'    => 'https://flagcdn.com/w320/de.png',
                    'popup'      => 'images/g-to-g/jerman.png',
                    'direktorat' => 'Direktorat Penempatan Pemerintah Kawasan Eropa'
                ],
            ],
        ],
        2 => [
            'judul'  => 'Mandiri',
            'gambar' => 'images/show/mandiri.jpg',
            'konten' => 'Adalah mekanisme penempatan Pekerja Migran Indonesia (PMI) ke luar negeri yang dilakukan oleh individu pekerja itu sendiri tanpa melalui pelaksana penempatan (seperti agen P3MI atau pemerintah/G to G).',
            'negara' => [
                [
                    'nama'  => 'Mandiri/Perorang',
                    'popup' => 'images/mandiri/mandiri.png'
                ],
                [
                    'nama'       => 'SSW',
                    'bendera'    => 'https://flagcdn.com/w320/jp.png',
                    'popup'      => 'images/mandiri/ssw.png',
                    'direktorat' => 'Direktorat Penempatan Non Pemerintah Kawasan Asia dan Afrika'
                ],
                [
                    'nama'       => 'SP2T',
                    'bendera'    => 'https://flagcdn.com/w320/tw.png',
                    'popup'      => 'images/mandiri/taiwan.png',
                    'direktorat' => 'Direktorat Penempatan Non Pemerintah Kawasan Asia dan Afrika'
                ],
            ],
        ],
        3 => [
            'judul'  => 'P to P (Private to Private)',
            'gambar' => 'images/show/p-to-p.jpg',
            'konten' => 'Adalah sistem penempatan Pekerja Migran Indonesia (PMI) yang difasilitasi oleh perusahaan swasta, yaitu Perusahaan Penempatan Pekerja Migran Indonesia (P3MI), untuk bekerja pada pemberi kerja berbadan hukum (perusahaan) di luar negeri, bukan untuk pemberi kerja perseorangan di sektor rumah tangga.',
            'negara' => [
                [
                    'nama'       => 'P to P',
                    'popup'      => 'images/p-to-p/p-to-p.png',
                    'direktorat' => 'Direktorat Penempatan Non Pemerintah Semua Kawasan'
                ],
                [
                    'nama'       => 'Visa E-7 Korea',
                    'bendera'    => 'https://flagcdn.com/w320/kr.png',
                    'popup'      => 'images/p-to-p/korea.png',
                    'direktorat' => 'Direktorat Penempatan Non Pemerintah Kawasan Asia dan Afrika'
                ],
            ],
        ],
        4 => [
            'judul'  => 'UKPS (Untuk Kepentingan Perusahaan Sendiri)',
            'gambar' => 'images/show/ukps.jpg',
            'konten' => 'Adalah skema penempatan di mana sebuah perusahaan yang berbadan hukum di Indonesia mengirimkan karyawannya sendiri ke luar negeri untuk mengerjakan suatu pekerjaan atau proyek milik perusahaan tersebut di negara tujuan.',
            'negara' => [
                [
                    'nama'       => 'UKPS',
                    'popup'      => 'images/ukps/ukps.png',
                    'direktorat' => 'Direktorat Penempatan Non Pemerintah Semua Kawasan'
                ],
            ]
        ],
    ];

    $detail = $dataManual[$id] ?? null;
@endphp

@section('content')
<main class="bg-gray-50 min-h-screen py-16">
    <div class="container mx-auto px-6 max-w-4xl">
        
        {{-- Pengecekan ketersediaan data --}}
        @if($detail)
            
            {{-- Tombol kembali --}}
            <div class="mb-6">
                <a href="{{ route('beranda') }}#penempatan" class="text-gray-600 hover:text-black font-bold flex items-center gap-2 transition">
                    &larr; Kembali ke Beranda
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border-t-8 border-[#F4CF3B]">
                
                {{-- Bagian gambar header --}}
                <div class="h-80 w-full relative group">
                    <img src="{{ asset($detail['gambar']) }}" 
                         alt="{{ $detail['judul'] }}"
                         class="w-full h-full object-cover transition duration-700 group-hover:scale-105">

                    {{-- Lapisan overlay gelap --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    
                    {{-- Judul konten --}}
                    <div class="absolute bottom-0 left-0 w-full p-8 text-center">
                        <h1 class="text-3xl md:text-4xl font-black text-white drop-shadow-lg leading-tight">
                            {{ $detail['judul'] }}
                        </h1>
                    </div>
                </div>

                {{-- Bagian isi konten --}}
                <div class="p-8 md:p-12">
                    <p class="text-gray-800 text-lg leading-loose text-justify">
                        {{ $detail['konten'] }}
                    </p>

                    <div class="mt-8 bg-yellow-50 p-6 rounded-xl border border-yellow-200 flex gap-4 items-start">
                        <div class="text-2xl">💡</div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Info Penting</h4>
                            <p class="text-sm text-gray-700">Pastikan selalu mengikuti prosedur resmi. Hubungi P4MI jika menemukan kejanggalan.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian daftar negara penempatan --}}
            @if(isset($detail['negara']) && is_array($detail['negara']))
                <div class="mt-10">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">
                        Negara Penempatan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($detail['negara'] as $n)
                            <button
                                @if(!empty($n['popup']))
                                    onclick="openModal('{{ asset($n['popup']) }}')"
                                @endif
                                class="flex items-center gap-4 p-4 bg-white border rounded-xl shadow hover:shadow-lg transition text-left"
                            >
                                {{-- Menampilkan bendera jika tersedia --}}
                                @if(!empty($n['bendera']))
                                    <img src="{{ $n['bendera'] }}"
                                         class="w-16 h-12 object-cover rounded border"
                                         alt="{{ $n['nama'] ?? 'Negara' }}">
                                @else
                                    <div class="w-16 h-12 flex items-center justify-center bg-gray-100 rounded border text-xs text-gray-400">
                                        N/A
                                    </div>
                                @endif

                                <div>
                                    <p class="font-bold text-gray-900">
                                        {{ $n['nama'] ?? 'Negara' }}
                                    </p>

                                    {{-- Menampilkan nama direktorat secara dinamis --}}
                                    <p class="text-sm text-gray-600">
                                        {{ $n['direktorat'] ?? 'Direktorat Penempatan' }}
                                    </p>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

        @else
            {{-- Tampilan jika data tidak ditemukan --}}
            <div class="text-center py-20">
                <h2 class="text-2xl font-bold text-red-500">Data tidak ditemukan.</h2>
                <a href="{{ route('beranda') }}" class="text-blue-600 underline mt-4 block">Kembali ke Beranda</a>
            </div>
        @endif

    </div>

    {{-- Komponen modal gambar --}}
    <div id="modalNegara"
         class="fixed inset-0 bg-black/70 hidden z-50 flex items-center justify-center"
         onclick="closeModal()">

        <div class="relative bg-white p-4 rounded-xl max-w-4xl w-full mx-4"
             onclick="event.stopPropagation()">

            <button onclick="closeModal()"
                    class="absolute -top-4 -right-4 bg-black text-white w-10 h-10 rounded-full text-2xl">
                &times;
            </button>

            <img id="modalImage"
                 src=""
                 class="w-full max-h-[80vh] object-contain rounded-lg">
        </div>
    </div>

    {{-- Script untuk logika modal --}}
    <script>
        function openModal(img) {
            document.getElementById('modalImage').src = img;
            document.getElementById('modalNegara').classList.remove('hidden');
        }
        
        function closeModal() {
            document.getElementById('modalNegara').classList.add('hidden');
        }
    </script>

</main>
@endsection