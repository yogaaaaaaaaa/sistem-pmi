@extends('layouts.frontend')

@section('content')
<main class="relative">

    {{-- Section hero --}}
    <section class="relative h-[700px] flex items-center justify-center text-center" 
             style="background-image: url('{{ asset('images/kp4mi.jpg') }}'); background-size: cover; background-position: center;">
        
        <div class="absolute inset-0 bg-black/60 z-0"></div>

        <div class="relative z-10 p-6 px-4">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white drop-shadow-lg mb-4" 
                style="text-shadow: 2px 2px 8px rgba(0,0,0,0.8);">
                Selamat Datang
            </h1>
            <p class="mt-2 text-xl md:text-2xl font-bold text-[#F4CF3B] drop-shadow-md tracking-wide">
                Di Pos Pelayanan Perlindungan Pekerja Migran Indonesia
            </p>
        </div>
    </section>
    
    <hr>

    {{-- Section grafik statistik --}}
<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Penempatan PMI</h2>
                <p class="text-sm text-gray-500">Data statistik per tahun</p>
            </div>

            <div class="relative">
                <select id="filterNegara"
                    class="appearance-none border border-gray-300 rounded-lg px-4 py-2 pr-10 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-yellow-400 font-medium text-gray-700 shadow-sm">
                    <option value="all">Semua Negara</option>
                    <option value="Taiwan">Taiwan</option>
                    <option value="Hongkong">Hongkong</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Jepang">Jepang</option>
                    <option value="Korea">Korea</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 h-[320px]">
            <canvas id="chartTahunan" class="w-full h-full"></canvas>
        </div>
    </div>
</section>

    {{-- Section cek status --}}
    <section id="cek-penempatan" class="py-16 bg-yellow-500">
        <div class="text-white text-center px-6">
            <h3 class="text-2xl font-bold mb-4">
               <a href="https://kp2mi.go.id/epmi_form">Cek Status Penempatan Anda</a> 
            </h3>
            <button class="bg-green-600 px-6 py-3 rounded hover:bg-green-700 font-semibold transition transform hover:scale-105">
                <a href="https://kp2mi.go.id/epmi_form" class="block w-full h-full">Cek Status</a>
            </button>
        </div>
    </section>

    {{-- Section tentang --}}
    <section id="tentang" class="py-12 px-6 bg-yellow-100 border-t border-b border-yellow-200 scroll-mt-28">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 items-center">
            <div class="flex justify-center md:justify-end">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Logo P4MI" 
                     class="w-48 h-auto md:w-64 object-contain drop-shadow-xl hover:scale-105 transition duration-300">
            </div>

            <div class="md:col-span-2 text-center md:text-left">
                <h2 class="text-4xl font-bold mb-6 text-gray-900 tracking-tight">Tentang</h2>
                <p class="text-gray-800 leading-relaxed text-lg font-medium  text-justify">
                    <span class="font-bold text-black">P4MI Tangerang</span> (Pos Pelayanan Pelindungan Pekerja Migran Indonesia) merupakan unit layanan teknis yang berada di bawah naungan dan koordinasi langsung BP3MI Banten (Balai Pelayanan Pelindungan Pekerja Migran Indonesia Provinsi Banten). 
                    <br><br>
                    Dibentuk oleh Badan Pelindungan Pekerja Migran Indonesia (BP2MI), P4MI Tangerang hadir untuk mendekatkan akses pelayanan pemerintah kepada masyarakat di wilayah Kota Tangerang, memastikan proses migrasi berjalan sesuai prosedur resmi.
                </p>
            </div>
        </div>
    </section>

    {{-- Section proses penempatan --}}
    <section id="penempatan" class="py-12 px-6 bg-white scroll-mt-28">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">PROSES PENEMPATAN</h2>
            
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

            <div class="relative px-0 md:px-8">
                <div class="swiper mySwiper pb-12">
                    <div class="swiper-wrapper">
                        
                        {{-- Item slide 1 --}}
                        <div class="swiper-slide h-auto">
                            <a href="{{ route('proses.show', 1) }}" class="group block h-full bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-2xl hover:border-[#F4CF3B] transition duration-300 transform hover:-translate-y-2">
                                <div class="relative h-64 overflow-hidden">
                                    <img src="{{ asset('images/penempatan/g-to-g.png') }}" alt="Pendaftaran" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                        <span class="text-[#F4CF3B] font-bold border-2 border-[#F4CF3B] px-4 py-2 rounded-full uppercase text-sm">Lihat Detail</span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-yellow-600 transition">G to G (Government to Government)</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">Adalah program kerja sama resmi antar pemerintah</p>
                                </div>
                            </a>
                        </div>

                        {{-- Item slide 2 --}}
                        <div class="swiper-slide h-auto">
                            <a href="{{ route('proses.show', 2) }}" class="group block h-full bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-2xl hover:border-[#F4CF3B] transition duration-300 transform hover:-translate-y-2">
                                <div class="relative h-64 overflow-hidden">
                                    <img src="{{ asset('images/penempatan/mandiri.png') }}" alt="Seleksi" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                        <span class="text-[#F4CF3B] font-bold border-2 border-[#F4CF3B] px-4 py-2 rounded-full uppercase text-sm">Lihat Detail</span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-yellow-600 transition">Mandiri</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">Adalah mekanisme penempatan Pekerja Migran Indonesia (PMI) ke luar negeri yang dilakukan oleh individu</p>
                                </div>
                            </a>
                        </div>

                        {{-- Item slide 3 --}}
                        <div class="swiper-slide h-auto">
                            <a href="{{ route('proses.show', 3) }}" class="group block h-full bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-2xl hover:border-[#F4CF3B] transition duration-300 transform hover:-translate-y-2">
                                <div class="relative h-64 overflow-hidden">
                                    <img src="{{ asset('images/penempatan/p-to-p.png') }}" alt="Dokumen" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                        <span class="text-[#F4CF3B] font-bold border-2 border-[#F4CF3B] px-4 py-2 rounded-full uppercase text-sm">Lihat Detail</span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-yellow-600 transition">P to P (Private to Private)</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">Adalah sistem penempatan Pekerja Migran Indonesia (PMI) yang difasilitasi oleh perusahaan swasta</p>
                                </div>
                            </a>
                        </div>

                        {{-- Item slide 4 --}}
                        <div class="swiper-slide h-auto">
                            <a href="{{ route('proses.show', 4) }}" class="group block h-full bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-2xl hover:border-[#F4CF3B] transition duration-300 transform hover:-translate-y-2">
                                <div class="relative h-64 overflow-hidden">
                                    <img src="{{ asset('images/penempatan/ukps.png') }}" alt="Berangkat" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                        <span class="text-[#F4CF3B] font-bold border-2 border-[#F4CF3B] px-4 py-2 rounded-full uppercase text-sm">Lihat Detail</span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-yellow-600 transition">UKPS (Untuk Kepentingan Perusahaan Sendiri)</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">Adalah skema penempatan di mana sebuah perusahaan yang berbadan hukum</p>
                                </div>
                            </a>
                        </div>

                    </div>
                    <div class="swiper-pagination"></div>
                </div>

                <div class="swiper-button-next !text-[#F4CF3B] !font-black"></div>
                <div class="swiper-button-prev !text-[#F4CF3B] !font-black"></div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
            <script>
                var swiper = new Swiper(".mySwiper", {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: true,
                    autoplay: { delay: 3500, disableOnInteraction: false },
                    pagination: { el: ".swiper-pagination", clickable: true },
                    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
                    breakpoints: {
                        640: { slidesPerView: 2, spaceBetween: 20 },
                        768: { slidesPerView: 3, spaceBetween: 30 },
                        1024: { slidesPerView: 4, spaceBetween: 30 },
                    },
                });
            </script>
        </div>
    </section>

    {{-- Section berita --}}
    <section id="berita" class="py-8 px-5 bg-yellow-100 border-t border-b border-yellow-200 scroll-mt-28">
        <div class="container mx-auto max-w-4xl">
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Berita</h2>

            <div class="space-y-4">
                @forelse($beritaTerbaru as $berita)
                    <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-green-600 hover:shadow-lg transition duration-300 flex gap-4">
                        @if($berita->thumbnail)
                            <img src="{{ asset('storage/'.$berita->thumbnail) }}"
                                 alt="{{ $berita->judul }}"
                                 class="w-24 h-24 object-cover rounded-md flex-shrink-0">
                        @endif

                        <div>
                            <a href="{{ route('berita.show', $berita->slug) }}"
                               class="text-lg font-semibold text-gray-800 hover:text-green-700 transition">
                                {{ $berita->judul }}
                            </a>

                            <p class="text-sm text-gray-600 mt-1">
                                {{ $berita->created_at->isoFormat('DD MMMM YYYY') }}
                                | {{ $berita->penulis ?? 'Admin' }}
                            </p>

                            <p class="text-sm text-gray-700 mt-2 line-clamp-2">
                                {{ Str::limit(strip_tags($berita->isi), 120) }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Belum ada berita terbaru.</p>
                @endforelse
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('berita.index') }}"
                   class="text-green-600 font-semibold hover:underline">
                    Lihat Semua Berita →
                </a>
            </div>
        </div>
    </section>


    {{-- Section buku tamu --}}
    <section id="bukutamu" class="py-12 px-6 bg-white scroll-mt-28">
        <div class="container mx-auto max-w-3xl">
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">BUKU TAMU</h2>
            
            <div class="bg-gray-50 border border-gray-200 p-8 md:p-12 rounded-3xl shadow-xl">
                {{-- Pesan sukses --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold rounded">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                        <ul class="list-disc list-inside font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('bukutamu.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="nama" class="block text-lg font-bold text-gray-800 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" 
                               class="w-full p-4 rounded-xl border-2 border-gray-300 focus:border-[#F4CF3B] focus:ring-4 focus:ring-[#F4CF3B]/30 outline-none transition font-medium" 
                               placeholder="Masukkan nama lengkap Anda" required>
                    </div>

                    <div>
                        <label for="alamat" class="block text-lg font-bold text-gray-800 mb-2">Alamat</label>
                        <input type="text" name="alamat" id="alamat" 
                               class="w-full p-4 rounded-xl border-2 border-gray-300 focus:border-[#F4CF3B] focus:ring-4 focus:ring-[#F4CF3B]/30 outline-none transition font-medium" 
                               placeholder="Masukkan alamat domisili Anda" required>
                    </div>

                    <div>
                        <label for="no_telpon" class="block text-lg font-bold text-gray-800 mb-2">Nomor Telpon</label>
                        <input type="text" name="no_telpon" id="no_telpon" 
                               class="w-full p-4 rounded-xl border-2 border-gray-300 focus:border-[#F4CF3B] focus:ring-4 focus:ring-[#F4CF3B]/30 outline-none transition font-medium" 
                               placeholder="Masukkan nomor telpon Anda" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-lg font-bold text-gray-800 mb-2">Negara</label>
                            <input type="text" name="negara" 
                                   class="w-full p-4 rounded-xl border-2 border-gray-300 focus:border-[#F4CF3B] focus:ring-4 focus:ring-[#F4CF3B]/30 outline-none transition font-medium" 
                                   placeholder="Ketik negara..." required>
                        </div>

                        <div>
                            <label class="block text-lg font-bold text-gray-800 mb-2">Sektor</label>
                            <select name="sektor" 
                                    class="w-full p-4 rounded-xl border-2 border-gray-300 bg-white focus:border-[#F4CF3B] focus:ring-4 focus:ring-[#F4CF3B]/30 outline-none transition font-medium" required>
                                <option value="" disabled selected>Pilih Sektor...</option>
                                <option value="Formal">Formal</option>
                                <option value="Informal">Informal</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-lg font-bold text-gray-800 mb-2">Keperluan</label>
                            <select name="keperluan" 
                                    class="w-full p-4 rounded-xl border-2 border-gray-300 bg-white focus:border-[#F4CF3B] focus:ring-4 focus:ring-[#F4CF3B]/30 outline-none transition font-medium" required>
                                <option value="" disabled selected>Pilih Keperluan...</option>
                                <option value="Pelayanan Keberangkatan">SSW</option>
                                <option value="Pelayanan Pengaduan">Mandiri</option>
                                <option value="Pelayanan Pengaduan">Pengaduan</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="jenis_layanan" class="block text-lg font-bold text-gray-800 mb-2">Jenis Layanan</label>
                        <textarea name="jenis_layanan" id="jenis_layanan" rows="5" 
                                  class="w-full p-4 rounded-xl border-2 border-gray-300 focus:border-[#F4CF3B] focus:ring-4 focus:ring-[#F4CF3B]/30 outline-none transition font-medium resize-none" 
                                  placeholder="Tuliskan jenis layanan yang Anda minta..." required></textarea>
                    </div>

                    <button type="submit" 
                            class="w-full bg-[#F4CF3B] text-gray-900 font-black text-xl py-4 rounded-xl hover:bg-yellow-400 transition duration-300 shadow-lg transform hover:-translate-y-1 uppercase tracking-wider">
                        Kirim
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- Script halaman --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Logika scroll halus tanpa loader
    document.addEventListener("DOMContentLoaded", function() {
        // Tangani klik link untuk scroll halus
        document.body.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link) {
                const href = link.getAttribute('href');
                const target = link.getAttribute('target');
                
                // Validasi target link
                if (href && href !== '#' && !href.startsWith('javascript')) {
                    const currentUrl = window.location.href.split('#')[0];
                    const targetUrl = href.split('#')[0];
                    
                    // Tangani scroll jika link mengarah ke halaman yang sama dengan hash
                    if (href.includes('#') && (currentUrl === targetUrl || href.startsWith('#'))) {
                        // Biarkan browser menangani scroll atau tambahkan logika scroll manual jika diperlukan
                    }
                }
            }
        });
    });

    // Konfigurasi chart
    let chartInstance;

    function loadChart(negara = 'all') {
        // Tambahin parameter wilayah=all biar controllernya ngereturn 3 dataset (Tangerang, Serang, Total)
        fetch("{{ route('chart.penempatan') }}?negara=" + negara + "&wilayah=all")
            .then(res => res.json())
            .then(res => {
                const ctx = document.getElementById('chartTahunan').getContext('2d');

                if (chartInstance) {
                    chartInstance.destroy();
                }

                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: res.labels,
                        // 🔥 Ambil datasets dari backend, lalu gabungkan dengan styling UI halaman utama lu
                        datasets: res.datasets.map(dataset => ({
                            ...dataset,
                            pointBackgroundColor: '#FFFFFF',
                            pointBorderColor: dataset.borderColor, // Warnanya ngikutin garis masing-masing
                            pointBorderWidth: 3,
                            pointRadius: 5, // Disesuaikan dikit biar gak terlalu numpuk
                            pointHoverRadius: 7,
                        }))
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                align: 'end',
                                labels: { boxWidth: 12, usePointStyle: true }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 12,
                                titleFont: { size: 14 },
                                bodyFont: { size: 14 },
                                displayColors: true, // Diaktifkan biar muncul buletan warna di tooltip
                                callbacks: {
                                    // Bikin tooltip nampilin nama wilayah + jumlah orangnya
                                    label: function(context) {
                                        return ' ' + context.dataset.label + ': ' + context.parsed.y + ' Orang';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { borderDash: [4, 4], color: '#F3F4F6' },
                                ticks: { stepSize: 1, font: { size: 11 } }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 12, weight: 'bold' } }
                            }
                        }
                    }
                });
            })
            .catch(err => console.error("Error loading chart:", err));
    }

    // Muat chart saat awal
    document.addEventListener("DOMContentLoaded", function() {
        loadChart();
    });

    // Tangani perubahan filter chart
    document.getElementById('filterNegara').addEventListener('change', function() {
        loadChart(this.value);
    });
</script>

</main>
@endsection