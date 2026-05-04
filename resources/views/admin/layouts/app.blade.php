<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <title>{{ auth()->user()->name }}</title>

    {{-- Asset CSS & JS (Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

    {{-- ===================== SIDEBAR ===================== --}}
    <aside class="w-64 bg-[#1f2937] text-white flex flex-col">

        {{-- Logo --}}
        <img src="{{ asset('images/logo.png') }}"
             alt="Logo"
             class="h-12 w-auto object-contain mx-auto my-4">

        {{-- Judul Sidebar --}}
        <div class="p-2 text-xl text-center font-bold border-b border-gray-700">
            {{ auth()->user()->name }}
        </div>

        {{-- Navigasi --}}
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('admin.penempatan.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.penempatan.*') ? 'active' : '' }}">
                Penempatan PMI
            </a>

            <a href="{{ route('admin.berita.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                Berita
            </a>

            <a href="{{ route('admin.bukutamu.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.bukutamu.*') ? 'active' : '' }}">
                Buku Tamu
            </a>
        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-red-600 py-2 rounded hover:bg-red-700">
                    Logout
                </button>
            </form>
        </div>
    </aside>
    {{-- =================== END SIDEBAR =================== --}}

    {{-- ===================== CONTENT ===================== --}}
    <main class="flex-1 p-6 overflow-y-auto">
        @yield('content')
    </main>
    {{-- =================== END CONTENT =================== --}}

</div>

{{-- ===================== SCRIPTS ===================== --}}
@push('scripts')

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

/*
|--------------------------------------------------------------------------
| GLOBAL CHART INSTANCE
|--------------------------------------------------------------------------
*/
let chartTahunan = null;
let chartNegara = null;
let chartWilayah = null;


/* ======================
   CHART TAHUNAN
====================== */
function loadChartTahunan(){

    const negara  = document.getElementById('filterNegara')?.value ?? 'all';
    const wilayah = document.getElementById('filterWilayah')?.value ?? 'all';

    fetch(`/chart/penempatan?negara=${negara}&wilayah=${wilayah}`)
    .then(res => res.json())
    .then(res => {

        if(chartTahunan){
            chartTahunan.destroy();
        }

        chartTahunan = new Chart(
            document.getElementById('chartTahunan'),
            {
                type:'line',
                data:{
                    labels: res.labels,
                    datasets: res.datasets 
                },
                options:{
                    responsive:true,
                    interaction:{
                        mode:'index',
                        intersect:false
                    },
                    plugins:{
                        legend:{
                            position:'top'
                        }
                    },
                    scales:{
                        y:{
                            beginAtZero:true
                        }
                    }
                }
            }
        );
    });
}


/* ======================
   CHART NEGARA
====================== */
function loadChartNegara(){

    fetch('/chart/negara')
    .then(res => res.json())
    .then(res => {

        if(chartNegara){
            chartNegara.destroy();
        }

        chartNegara = new Chart(
            document.getElementById('chartNegara'),
            {
                type:'pie',
                data:{
                    labels: res.labels,
                    datasets:[{
                        label:'PMI per Negara',
                        data: res.data
                    }]
                },
                options:{
                    responsive:true,
                    plugins:{
                        legend:{
                            position:'bottom'
                        }
                    }
                }
            }
        );
    });
}


/* ======================
   CHART WILAYAH
====================== */
function loadChartWilayah(){

    fetch('/chart/wilayah')
    .then(res => res.json())
    .then(res => {

        if(chartWilayah){
            chartWilayah.destroy();
        }

        chartWilayah = new Chart(
            document.getElementById('chartWilayah'),
            {
                type:'bar',
                data:{
                    labels: res.labels,
                    datasets:[{
                        label:'Jumlah PMI',
                        data: res.data,
                        borderWidth:1
                    }]
                },
                options:{
                    responsive:true,
                    plugins:{
                        legend:{
                            display:true
                        }
                    },
                    scales:{
                        y:{
                            beginAtZero:true
                        }
                    }
                }
            }
        );
    });
}


/* ======================
   LOAD AWAL DASHBOARD
====================== */
document.addEventListener('DOMContentLoaded', function(){

    loadChartTahunan();
    loadChartNegara();
    loadChartWilayah();

});


/* ======================
   FILTER EVENT
====================== */
document.getElementById('filterNegara')
?.addEventListener('change', loadChartTahunan);

document.getElementById('filterWilayah')
?.addEventListener('change', loadChartTahunan);

</script>

@endpush
@stack('scripts')
{{-- =================== END SCRIPTS =================== --}}

</body>
</html>

{{-- ===================== STYLES ===================== --}}
<style>
.sidebar-link {
    display: block;
    padding: 10px 12px;
    border-radius: 6px;
    font-weight: 600;
}
.sidebar-link:hover {
    background: #374151;
}
.sidebar-link.active {
    background: #facc15;
    color: #000;
}
</style>
