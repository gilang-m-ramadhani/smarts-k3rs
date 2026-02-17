<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Laporan</h1>
            <p class="text-base-content/50 text-sm">Ringkasan dan laporan inspeksi APAR</p>
        </div>
        <div class="flex gap-2 items-center">
            <select wire:model.live="selectedMonth" class="select select-bordered select-sm">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ \Carbon\Carbon::create(null, $i)->locale('id')->isoFormat('MMMM') }}</option>
                @endfor
            </select>
            <select wire:model.live="selectedYear" class="select select-bordered select-sm">
                @for ($y = now()->year; $y >= now()->year - 3; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
            <button wire:click="generateReport" class="btn btn-primary btn-sm shadow-sm shadow-primary/20">
                <span wire:loading.remove wire:target="generateReport">Generate</span>
                <span wire:loading wire:target="generateReport" class="loading loading-spinner loading-xs"></span>
            </button>
        </div>
    </div>

    @if(session('message'))
    <div class="alert alert-success mb-4 text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('message') }}
    </div>
    @endif

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <div class="card bg-base-100 shadow-sm border border-base-300/50 p-4">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Total APAR</p>
            <p class="text-2xl font-bold text-primary">{{ $totalApar }}</p>
        </div>
        <div class="card bg-base-100 shadow-sm border border-base-300/50 p-4">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Inspeksi Bulan Ini</p>
            <p class="text-2xl font-bold text-info">{{ $inspeksiThisMonth }}</p>
        </div>
        <div class="card bg-base-100 shadow-sm border border-base-300/50 p-4">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Compliance Rate</p>
            <p class="text-2xl font-bold text-success">{{ $complianceRate }}%</p>
        </div>
        <div class="card bg-base-100 shadow-sm border border-base-300/50 p-4">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">APAR Rusak</p>
            <p class="text-2xl font-bold text-error">{{ $aparByStatus['rusak'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        <div class="card bg-base-100 shadow-sm border border-base-300/50">
            <div class="card-body">
                <h2 class="card-title text-base font-bold">Status APAR</h2>
                <div id="statusPieChart"></div>
            </div>
        </div>
        <div class="card bg-base-100 shadow-sm border border-base-300/50">
            <div class="card-body">
                <h2 class="card-title text-base font-bold">Distribusi Status</h2>
                <div id="statusBarChart"></div>
            </div>
        </div>
    </div>

    {{-- Laporan History --}}
    <div class="card bg-base-100 shadow-sm border border-base-300/50">
        <div class="card-body">
            <h2 class="card-title text-base font-bold mb-2">Riwayat Laporan</h2>
            <div class="overflow-x-auto">
                <table class="table table-sm">
                    <thead>
                        <tr><th>Bulan</th><th>Tahun</th><th>Total Inspeksi</th><th>Compliance</th></tr>
                    </thead>
                    <tbody>
                        @forelse($laporanList as $lap)
                        <tr class="hover">
                            <td class="text-sm">{{ \Carbon\Carbon::create(null, $lap->bulan)->locale('id')->isoFormat('MMMM') }}</td>
                            <td class="text-sm">{{ $lap->tahun }}</td>
                            <td class="text-sm font-semibold">{{ $lap->total_inspeksi ?? 0 }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <progress class="progress progress-primary w-20 h-2" value="{{ $lap->compliance_rate ?? 0 }}" max="100"></progress>
                                    <span class="text-xs font-semibold">{{ $lap->compliance_rate ?? 0 }}%</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-8 text-base-content/40">Belum ada laporan. Klik Generate untuk membuat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'smartk3dark';
    const textColor = isDark ? '#cfe8ec' : '#2a4a52';
    const labels = @json(array_keys($aparByStatus));
    const data = @json(array_values($aparByStatus));

    // Donut chart
    new ApexCharts(document.querySelector("#statusPieChart"), {
        series: data,
        labels: labels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
        colors: ['#7AB2B2', '#088395', '#09637E', '#EBF4F6'],
        chart: { type: 'donut', height: 280, background: 'transparent', foreColor: textColor },
        stroke: { colors: ['#fff'], width: 3 },
        dataLabels: { enabled: true, style: { fontSize: '13px', fontWeight: 700 } },
        plotOptions: { pie: { donut: { size: '60%', labels: { show: true, total: { show: true, label: 'Total', color: textColor, formatter: () => '{{ $totalApar }}' }, value: { fontSize: '22px', fontWeight: 800, color: textColor } } } } },
        legend: { position: 'bottom', fontSize: '12px', labels: { colors: textColor } }
    }).render();

    // Bar chart
    new ApexCharts(document.querySelector("#statusBarChart"), {
        series: [{ name: 'Jumlah', data: data }],
        chart: { type: 'bar', height: 280, toolbar: { show: false }, background: 'transparent', foreColor: textColor },
        colors: ['#09637E', '#088395', '#7AB2B2', '#c5e4e7'],
        plotOptions: { bar: { borderRadius: 8, distributed: true, columnWidth: '55%' } },
        dataLabels: { enabled: true, style: { fontSize: '14px', fontWeight: 700, colors: ['#fff'] } },
        xaxis: { categories: labels.map(l => l.charAt(0).toUpperCase() + l.slice(1)), labels: { style: { colors: textColor } } },
        yaxis: { labels: { style: { colors: textColor } } },
        grid: { borderColor: isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)', strokeDashArray: 4 },
        legend: { show: false }
    }).render();
});
</script>
@endpush
