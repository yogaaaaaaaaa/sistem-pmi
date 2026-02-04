<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <title>Admin Panel</title>

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
            ADMIN P4MI
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
/**
 * Chart Penempatan Tahunan
 * Data diambil dari controller melalui AJAX (fetch)
 */

let chartInstance = null;

/**
 * Load dan render chart berdasarkan filter negara
 */
function loadChart(negara = 'all') {
    fetch("{{ route('chart.penempatan') }}?negara=" + negara)
        .then(response => response.json())
        .then(response => {
            const ctx = document.getElementById('chartTahunan').getContext('2d');

            // Hapus chart sebelumnya agar tidak menumpuk
            if (chartInstance) {
                chartInstance.destroy();
            }

            const labelText = negara === 'all'
                ? 'Total Penempatan'
                : 'Penempatan ke ' + negara;

            chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: response.labels,
                    datasets: [{
                        label: labelText,
                        data: response.data,
                        borderColor: '#F59E0B',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#FFFFFF',
                        pointBorderColor: '#F59E0B',
                        pointBorderWidth: 3,
                        backgroundColor: (context) => {
                            const ctx = context.chart.ctx;
                            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                            gradient.addColorStop(0, 'rgba(245,158,11,0.3)');
                            gradient.addColorStop(1, 'rgba(245,158,11,0)');
                            return gradient;
                        }
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end'
                        },
                        tooltip: {
                            displayColors: false,
                            callbacks: {
                                label: ctx => ctx.parsed.y + ' Orang'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error load chart:', error));
}

// Load chart pertama kali
document.addEventListener('DOMContentLoaded', () => {
    loadChart();
});

// Event filter negara
document.getElementById('filterNegara')?.addEventListener('change', function () {
    loadChart(this.value);
});
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
