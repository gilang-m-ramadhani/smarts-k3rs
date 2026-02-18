<div>
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <p class="text-base-content/50 text-sm">Selamat datang di SMART K3 — Sistem Manajemen APAR</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="badge badge-lg badge-ghost">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('apar.index') }}" class="card bg-base-100 shadow-sm border border-base-300/50 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 group">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-base-content/50 text-xs font-medium uppercase tracking-wider">Total APAR</p>
                        <p class="text-3xl font-extrabold text-primary mt-1">{{ $totalApar }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary group-hover:text-primary-content" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-3">
                    <span class="badge badge-xs gap-1 status-aktif">{{ $aparAktif }} Aktif</span>
                    <span class="badge badge-xs gap-1 status-rusak">{{ $aparRusak }} Rusak</span>
                </div>
            </div>
        </a>

        <a href="{{ route('inspeksi.index') }}" class="card bg-base-100 shadow-sm border border-base-300/50 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 group">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-base-content/50 text-xs font-medium uppercase tracking-wider">Inspeksi Bulan Ini</p>
                        <p class="text-3xl font-extrabold text-info mt-1">{{ $inspeksiBulanIni }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-info/10 flex items-center justify-center group-hover:bg-info group-hover:scale-110 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-info group-hover:text-info-content" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-base-content/50">Progress</span>
                        <span class="font-semibold">{{ $complianceRate }}%</span>
                    </div>
                    <progress class="progress progress-info w-full h-2" value="{{ $complianceRate }}" max="100"></progress>
                </div>
            </div>
        </a>

        <a href="{{ route('maintenance.index') }}" class="card bg-base-100 shadow-sm border border-base-300/50 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 group">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-base-content/50 text-xs font-medium uppercase tracking-wider">Maintenance Pending</p>
                        <p class="text-3xl font-extrabold text-warning mt-1">{{ $maintenancePending }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-warning/10 flex items-center justify-center group-hover:bg-warning group-hover:scale-110 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-warning group-hover:text-warning-content" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
            </div>
        </a>

        <div class="card bg-base-100 shadow-sm border border-base-300/50 {{ $aparExpired > 0 ? 'ring-2 ring-error/20' : '' }}">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-base-content/50 text-xs font-medium uppercase tracking-wider">APAR Expired</p>
                        <p class="text-3xl font-extrabold text-error mt-1">{{ $aparExpired }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-error/10 flex items-center justify-center {{ $aparExpired > 0 ? 'animate-pulse' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        <div class="card bg-base-100 shadow-sm border border-base-300/50">
            <div class="card-body">
                <h2 class="card-title text-base font-bold">Status APAR</h2>
                <div id="statusChart"></div>
            </div>
        </div>
        <div class="card bg-base-100 shadow-sm border border-base-300/50">
            <div class="card-body">
                <h2 class="card-title text-base font-bold">APAR Berdasarkan Tipe</h2>
                <div id="tipeChart"></div>
            </div>
        </div>
    </div>

    {{-- Recent Inspeksi --}}
    <div class="card bg-base-100 shadow-sm border border-base-300/50 mb-6">
        <div class="card-body">
            <div class="flex items-center justify-between mb-2">
                <h2 class="card-title text-base font-bold">Inspeksi Terbaru</h2>
                <a href="{{ route('inspeksi.index') }}" class="btn btn-ghost btn-xs">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table table-sm">
                    <thead>
                        <tr><th>APAR</th><th>Tanggal</th><th>Inspektor</th><th>Tekanan</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentInspeksi as $inspeksi)
                        <tr>
                            <td>
                                <div class="font-medium text-sm">{{ $inspeksi->apar->id_apar }}</div>
                                <div class="text-xs text-base-content/50">{{ $inspeksi->apar->lokasi->nama_lokasi ?? '-' }}</div>
                            </td>
                            <td class="text-sm">{{ $inspeksi->tanggal_inspeksi->format('d/m/Y') }}</td>
                            <td class="text-sm">{{ $inspeksi->user->name ?? '-' }}</td>
                            <td>
                                <span class="badge badge-sm
                                    {{ $inspeksi->pressure_status === 'hijau' ? 'badge-success' : '' }}
                                    {{ $inspeksi->pressure_status === 'kuning' ? 'badge-warning' : '' }}
                                    {{ $inspeksi->pressure_status === 'merah' ? 'badge-error' : '' }}
                                ">{{ ucfirst($inspeksi->pressure_status) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-base-content/40 py-6">Belum ada data inspeksi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Expiring APAR --}}
    @if($expiringApar->count() > 0)
    <div class="card bg-base-100 shadow-sm border border-base-300/50">
        <div class="card-body">
            <div class="flex items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                <h2 class="card-title text-base font-bold">APAR Akan Expired (30 Hari)</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="table table-sm">
                    <thead>
                        <tr><th>APAR</th><th>Lokasi</th><th>Tipe</th><th>Expired</th></tr>
                    </thead>
                    <tbody>
                        @foreach($expiringApar as $apar)
                        <tr>
                            <td class="font-medium text-sm">{{ $apar->id_apar }}</td>
                            <td class="text-sm">{{ $apar->lokasi->nama_lokasi ?? '-' }}</td>
                            <td><span class="badge badge-outline badge-sm">{{ strtoupper($apar->tipe_apar) }}</span></td>
                            <td>
                                <span class="text-warning font-semibold text-sm">{{ $apar->tanggal_expire->format('d/m/Y') }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let statusChart, tipeChart;

    function getThemeColors() {
        const isDark = document.documentElement.getAttribute('data-theme') === 'smartk3dark';
        return {
            textColor: isDark ? '#cfe8ec' : '#2a4a52',
            gridColor: isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)',
            strokeColor: isDark ? '#162428' : '#ffffff',
        };
    }

    function renderCharts() {
        if (statusChart) statusChart.destroy();
        if (tipeChart) tipeChart.destroy();

        const { textColor, gridColor, strokeColor } = getThemeColors();

        // Status Chart (Donut)
        statusChart = new ApexCharts(document.querySelector("#statusChart"), {
            series: @json(collect($aparByStatus)->pluck('count')),
            labels: @json(collect($aparByStatus)->pluck('status')),
            colors: ['#86EFAC', '#FDA4AF', '#FDE68A', '#7DD3FC'],
            chart: { type: 'donut', height: 300, background: 'transparent', foreColor: textColor },
            stroke: { colors: [strokeColor], width: 3 },
            dataLabels: { enabled: true, style: { fontSize: '14px', fontWeight: 700 } },
            plotOptions: {
                pie: {
                    donut: {
                        size: '60%',
                        labels: {
                            show: true,
                            total: { show: true, label: 'Total', color: textColor, fontSize: '14px',
                                formatter: function() { return '{{ $totalApar }}'; }
                            },
                            value: { fontSize: '24px', fontWeight: 800, color: textColor }
                        }
                    }
                }
            },
            legend: { position: 'bottom', fontSize: '13px', labels: { colors: textColor } }
        });
        statusChart.render();

        // Tipe Chart (Bar)
        tipeChart = new ApexCharts(document.querySelector("#tipeChart"), {
            series: [{ name: 'Jumlah', data: @json(collect($aparByTipe)->pluck('count')) }],
            chart: { type: 'bar', height: 300, toolbar: { show: false }, background: 'transparent', foreColor: textColor },
            colors: ['#09637E', '#088395', '#7AB2B2', '#c5e4e7'],
            plotOptions: {
                bar: { borderRadius: 8, horizontal: false, distributed: true, columnWidth: '55%' }
            },
            dataLabels: { enabled: true, style: { fontSize: '14px', fontWeight: 700, colors: ['#fff'] } },
            xaxis: {
                categories: @json(collect($aparByTipe)->pluck('tipe')),
                labels: { style: { colors: textColor, fontSize: '12px' } }
            },
            yaxis: { labels: { style: { colors: textColor } } },
            grid: { borderColor: gridColor, strokeDashArray: 4 },
            legend: { show: false }
        });
        tipeChart.render();
    }

    // Initial render
    renderCharts();

    // Re-render charts when theme changes
    const themeBtn = document.getElementById('theme-toggle');
    if (themeBtn) {
        themeBtn.addEventListener('click', function() {
            setTimeout(renderCharts, 100);
        });
    }
});
</script>
@endpush
