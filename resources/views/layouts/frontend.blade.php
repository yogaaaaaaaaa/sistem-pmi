<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>P4MI Tangerang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
        }

        .header-yellow-bg {
            background-color: #F4CF3B;
            clip-path: polygon(60px 0, 100% 0, 100% 100%, 0% 100%);
        }
        @media (max-width: 768px) {
            .header-yellow-bg {
                clip-path: none;
                width: 100%;
            }
        }
    </style>
</head>
<body class="antialiased font-sans">
    
    <header class="bg-white shadow-md sticky top-0 z-50 h-24 flex">
        
        {{-- Section logo header --}}
        <div class="w-[25%] bg-white flex items-center pl-4 lg:pl-8 z-20">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo_pmi.jpeg') }}" alt="Logo" class="h-16 w-auto object-contain">
            </div>
        </div>

        {{-- Menu navigasi dan styling --}}
        <div class="w-[75%] relative h-full flex justify-center items-center pl-12 pr-4">
            
           <div class="absolute inset-0 header-yellow-bg z-10 hidden md:block pointer-events-none"></div>

            <nav class="relative z-20 hidden md:flex space-x-12 lg:space-x-16">
                <a href="{{ route('beranda') }}" class="text-gray-900 font-bold text-sm hover:text-white transition uppercase tracking-wide">Beranda</a>
                <a href="{{ route('beranda') }}#tentang" class="text-gray-900 font-bold text-sm hover:text-white transition uppercase tracking-wide">Tentang</a>
                <a href="{{ route('beranda') }}#penempatan" class="text-gray-900 font-bold text-sm hover:text-white transition uppercase tracking-wide">Proses Penempatan</a>
                <a href="{{ route('beranda') }}#berita" class="text-gray-900 font-bold text-sm hover:text-white transition uppercase tracking-wide">Berita</a>
                <a href="{{ route('beranda') }}#bukutamu" class="text-gray-900 font-bold text-sm hover:text-white transition uppercase tracking-wide">Buku Tamu</a>
            </nav>

            <button class="md:hidden absolute top-1/2 right-3 -translate-y-1/2 z-[999] p-2 text-gray-900">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </header>

    {{-- Menu navigasi mobile --}}
    <div id="mobileMenu" class="md:hidden hidden fixed top-24 left-0 w-full bg-[#F4CF3B] z-[998] shadow-lg">
        <nav class="flex flex-col divide-y divide-yellow-300 text-center font-bold">
            <a href="{{ route('beranda') }}" class="py-4">Beranda</a>
            <a href="{{ route('beranda') }}#tentang" class="py-4">Tentang</a>
            <a href="{{ route('beranda') }}#penempatan" class="py-4">Proses Penempatan</a>
            <a href="{{ route('beranda') }}#berita" class="py-4">Berita</a>
            <a href="{{ route('beranda') }}#bukutamu" class="py-4">Buku Tamu</a>
        </nav>
    </div>

    <div id="content">
        @yield('content')
    </div>

    {{-- Section footer aplikasi --}}
    <footer class="bg-[#F4CF3B] pt-10 pb-5 text-gray-900 font-sans">
    <div class="container mx-auto px-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- Kolom footer 1 --}}
            <div class="flex flex-col items-start">
                <div class="mb-4">
                    <img src="{{ asset('images/footer.png') }}" 
                         alt="Logo P4MI" 
                         class="h-16 w-auto object-contain mix-blend-multiply">
                </div>
                <p class="text-sm text-justify leading-relaxed font-semibold text-gray-800">
                    Pos Pelayanan Perlindungan Migran Indonesia (P4MI) Tangerang bertugas memberikan pelayanan, perlindungan, dan pembinaan terhadap CPMI dan PMI.
                </p>
            </div>

            {{-- Kolom footer 2 --}}
            <div>
                <h3 class="text-lg font-black mb-4 uppercase tracking-wider text-black">Link Cepat</h3>
                <ul class="space-y-2 text-sm font-bold text-gray-800">
                    <li><a href="{{ route('beranda') }}" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="{{ route('beranda') }}#tentang" class="hover:text-white transition">Tentang</a></li>
                    <li><a href="{{ route('beranda') }}#penempatan" class="hover:text-white transition">Proses Penempatan</a></li>
                    <li><a href="{{ route('beranda') }}#berita" class="hover:text-white transition">Berita</a></li>
                    <li><a href="{{ route('beranda') }}#bukutamu" class="hover:text-white transition">Buku Tamu</a></li>
                </ul>
            </div>

            {{-- Kolom footer 3 --}}
            <div>
                <h3 class="text-lg font-black mb-4 uppercase tracking-wider text-black">Media Sosial</h3>
                <p class="text-sm font-bold text-gray-800 mb-4">Ikuti informasi terbaru kami:</p>
                
                <div class="flex gap-4">
                    <a href="https://www.instagram.com/bp3mi_banten/?hl=id" target="_blank" class="bg-black/10 p-3 rounded-full hover:bg-white hover:text-[#F4CF3B] transition flex items-center justify-center w-12 h-12">
                        <i class="bi bi-instagram text-xl"></i>
                    </a>
                    <a href="https://www.tiktok.com/@bp3mibanten" target="_blank" class="bg-black/10 p-3 rounded-full hover:bg-white hover:text-[#F4CF3B] transition flex items-center justify-center w-12 h-12">
                        <i class="bi bi-tiktok text-xl"></i>
                    </a>
                </div>
            </div>

            {{-- Kolom footer 4 --}}
            <div>
                <h3 class="text-lg font-black mb-4 uppercase tracking-wider text-black">Lokasi Kami</h3>
                <ul class="space-y-4 text-sm font-bold text-gray-800">
                    <li>
                        <span class="block text-black uppercase text-xs mb-1">P4MI TANGERANG:</span>
                        Ruko Downtown Drive Blok. DDA No. 25-26, Medang, Pagedangan, Tangerang, 15334.
                    </li>
                </ul>
            </div>

        </div>

        <div class="border-t border-black/10 mt-12 pt-8 text-center">
            <p class="text-sm font-bold text-gray-800">
                &copy; {{ date('Y') }} Pos Pelayanan Perlindungan Migran Indonesia - Tangerang.
            </p>
        </div>
    </div>
</footer>

<script>
    // Fungsionalitas toggle menu mobile
    const btn = document.querySelector('button.md\\:hidden');
    const menu = document.getElementById('mobileMenu');

    if (btn && menu) {
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
        menu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
            });
        });
    }

    // Script utama untuk perilaku smooth scrolling tanpa reload halaman
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('a').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                
                if (!this.href || this.getAttribute('href') === '#') return;
                if (this.target === '_blank') return;

                const targetUrl = new URL(this.href);
                const currentUrl = window.location;

                // Menangani smooth scroll untuk link anchor internal pada halaman yang sama
                if (targetUrl.origin === currentUrl.origin && targetUrl.pathname === currentUrl.pathname) {
                    
                    e.preventDefault(); 

                    if (targetUrl.hash) {
                        const targetId = targetUrl.hash.substring(1);
                        const targetElement = document.getElementById(targetId);

                        if (targetElement) {
                            targetElement.scrollIntoView({ behavior: 'smooth' });
                            history.pushState(null, null, targetUrl.hash);
                        }
                    } else {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        history.pushState(null, null, targetUrl.pathname);
                    }

                    if (menu && !menu.classList.contains('hidden')) {
                        menu.classList.add('hidden');
                    }
                }
            });
        });
    });
</script>

</body>
</html>