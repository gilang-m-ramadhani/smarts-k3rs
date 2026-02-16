<div>
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Dashboard</h1>
            <p class="text-base-content/100">Selamat datang di SMART K3 - Sistem Manajemen APAR</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 mt-4 md:mt-0">
        <span class="badge badge-lg
            bg-[#EC008C]
            text-white
            border-0">
            {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </span>
            <div class="divider divider-horizontal mx-0 hidden md:flex"></div>
            <a href="{{ route('inspeksi.create') }}" class="btn btn-sm btn-primary gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Buat Inspeksi
            </a>
            <a href="{{ route('apar.create') }}" class="btn btn-sm btn-secondary gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah APAR
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total APAR -->
        <a href="{{ route('apar.index') }}" class="glass-card p-6 group hover:scale-[1.02] transition-all duration-200 cursor-pointer hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-base-content/100 text-sm">Total APAR</p>
                    <p class="text-3xl font-bold text-primary">{{ $totalApar }}</p>
                </div>
                <div class="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-4 text-sm">
                <span class="badge badge-success badge-sm">{{ $aparAktif }} Aktif</span>
                <span class="badge badge-error badge-sm">{{ $aparRusak }} Rusak</span>
            </div>
        </a>

        <!-- Inspeksi Bulan Ini -->
        <a href="{{ route('inspeksi.index') }}" class="glass-card p-6 group hover:scale-[1.02] transition-all duration-200 cursor-pointer hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-base-content/100 text-sm">Inspeksi Bulan Ini</p>
                    <p class="text-3xl font-bold text-info">{{ $inspeksiBulanIni }}</p>
                </div>
                <div class="w-14 h-14 rounded-full bg-info/10 flex items-center justify-center group-hover:bg-info group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-info group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between text-sm mb-1">
                    <span>Progress</span>
                    <span>{{ $complianceRate }}%</span>
                </div>
                <progress class="progress progress-info w-full" value="{{ $complianceRate }}" max="100"></progress>
            </div>
        </a>

        <!-- Maintenance Pending -->
        <a href="{{ route('maintenance.index') }}" class="glass-card p-6 group hover:scale-[1.02] transition-all duration-200 cursor-pointer hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-base-conten80 text-sm">Maintenance Pending</p>
                    <p class="text-3xl font-bold text-warning">{{ $maintenancePending }}</p>
                </div>
                <div class="w-14 h-14 rounded-full bg-warning/10 flex items-center justify-center group-hover:bg-warning group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-warning group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm text-warning group-hover:font-medium">
                <span>Lihat Detail</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>
        </a>

        <!-- APAR Expired -->
        <a href="{{ route('apar.index') }}?status=expired" class="glass-card p-6 group hover:scale-[1.02] transition-all duration-200 cursor-pointer hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-base-content/100 text-sm">APAR Expired</p>
                    <p class="text-3xl font-bold text-error">{{ $aparExpired }}</p>
                </div>
                <div class="w-14 h-14 rounded-full bg-error/10 flex items-center justify-center group-hover:bg-error group-hover:text-white transition-all {{ $aparExpired > 0 ? 'animate-pulse' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-error group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm text-error group-hover:font-medium">
                <span>Perlu Tindakan</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>
        </a>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Status Chart -->
        <div class="glass-card p-6">
            <h2 class="card-title text-lg mb-4">Status APAR</h2>
            <div id="statusChart" class="h-72"></div>
        </div>

        <!-- Tipe Chart -->
        <div class="glass-card p-6">
            <h2 class="card-title text-lg mb-4">APAR Berdasarkan Tipe</h2>
            <div id="tipeChart" class="h-72"></div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Recent Inspeksi -->
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="card-title text-lg">Inspeksi Terbaru</h2>
                <a href="{{ route('inspeksi.index') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
            <table class="table table-sm table-bordered border-2 border-base-200/70">
                <thead class="bg-base-200/40">
                    <tr>
                        <th class="border-1 border-base-200/70">APAR</th>
                        <th class="border-1 border-base-200/70">Tanggal</th>
                        <th class="border-1 border-base-200/70">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-base-200/70">
                    @forelse($recentInspeksi as $inspeksi)
                    <tr class="hover:bg-base-200/30 transition">
                        <td class="border-1 border-base-200/70">
                            <div class="font-medium">{{ $inspeksi->apar->id_apar }}</div>
                            <div class="text-xs text-base-content/70">
                                {{ $inspeksi->apar->lokasi->nama_lokasi ?? '-' }}
                            </div>
                        </td>

                        <td class="border-1 border-base-200/70">
                            {{ $inspeksi->tanggal_inspeksi->format('d/m/Y') }}
                        </td>

                        <td class="border-1 border-base-200/70">
                            <span class="badge {{ $inspeksi->overall_status_badge }} badge-sm">
                                {{ ucfirst($inspeksi->overall_status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-base-content/70 border-1 border-base-200/70">
                            Belum ada data inspeksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        <!-- APAR Akan Expired -->
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="card-title text-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    APAR Akan Expired (30 Hari)
                </h2>
            </div>
            <div class="overflow-x-auto">
            <table class="table table-sm border border-base-200/70">
                <thead class="bg-base-200/40">
                    <tr>
                        <th class="border border-base-200/70">APAR</th>
                        <th class="border border-base-200/70">Lokasi</th>
                        <th class="border border-base-200/70">Expired</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-base-200/70">
                    @forelse($expiringApar as $apar)
                    <tr class="hover:bg-base-200/30 transition">
                        <td class="border border-base-200/70">
                            <div class="font-medium">{{ $apar->id_apar }}</div>
                            <div class="text-xs text-base-content/70">
                                {{ $apar->merk }} - {{ strtoupper($apar->tipe_apar) }}
                            </div>
                        </td>

                        <td class="border border-base-200/70">
                            {{ $apar->lokasi->nama_lokasi ?? '-' }}
                        </td>

                        <td class="border border-base-200/70">
                            <span class="text-warning font-medium">
                                {{ $apar->tanggal_expire->format('d/m/Y') }}
                            </span>
                            <div class="text-xs text-base-content/70">
                                {{ $apar->days_until_expire }} hari lagi
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-base-content/70 border border-base-200/70">
                            Tidak ada APAR yang akan expired
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <!-- Upcoming Maintenance -->
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="card-title text-lg">Jadwal Maintenance</h2>
            <a href="{{ route('maintenance.index') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
        <table class="table table-sm border border-base-200/70">
            <thead class="bg-base-200/40">
                <tr>
                    <th class="border border-base-200/70">No. WO</th>
                    <th class="border border-base-200/70">APAR</th>
                    <th class="border border-base-200/70">Tipe</th>
                    <th class="border border-base-200/70">Teknisi</th>
                    <th class="border border-base-200/70">Jadwal</th>
                    <th class="border border-base-200/70">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-base-200/70">
                @forelse($upcomingMaintenance as $wo)
                <tr class="hover:bg-base-200/30 transition">
                    <td class="font-mono border border-base-200/70">
                        {{ $wo->wo_number }}
                    </td>

                    <td class="border border-base-200/70">
                        <div class="font-medium">{{ $wo->apar->id_apar }}</div>
                        <div class="text-xs text-base-content/70">
                            {{ $wo->apar->lokasi->nama_lokasi ?? '-' }}
                        </div>
                    </td>

                    <td class="border border-base-200/70 text-center">
                        <div class="w-full">
                            <span class="badge badge-outline badge-sm w-full justify-center whitespace-normal leading-tight">
                                {{ $wo->maintenance_type_label }}
                            </span>
                        </div>
                    </td>


                    <td class="border border-base-200/70">
                        {{ $wo->teknisi->name ?? 'Belum ditentukan' }}
                    </td>

                    <td class="border border-base-200/70">
                        {{ $wo->scheduled_date->format('d/m/Y') }}
                    </td>

                    <td class="border border-base-200/70">
                        <span class="badge {{ $wo->status_badge }} badge-sm">
                            {{ ucfirst(str_replace('_', ' ', $wo->status)) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-base-content/70 border border-base-200/70">
                        Tidak ada jadwal maintenance
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status Chart (Donut)
    var statusOptions = {
        series: @json(collect($aparByStatus)->pluck('count')),
        labels: @json(collect($aparByStatus)->pluck('status')),
        colors: @json(collect($aparByStatus)->pluck('color')),
        chart: {
            type: 'donut',
            height: 280,
        },
        stroke: {
        width: 0
        },
        legend: {
            position: 'bottom'
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '60%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total APAR',
                            formatter: function () {
                                return '{{ $totalApar }}'
                            }
                        }
                    }
                }
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { width: 300 },
                legend: { position: 'bottom' }
            }
        }]
    };
    var statusChart = new ApexCharts(document.querySelector("#statusChart"), statusOptions);
    statusChart.render();

    // Tipe Chart (Bar)
    var tipeOptions = {
        series: [{
            name: 'Jumlah',
            data: @json(collect($aparByTipe)->pluck('count'))
        }],
        chart: {
            type: 'bar',
            height: 280,
            toolbar: { show: false }
        },
        colors: ['#dc2626', '#f97316', '#fbbf24', '#22c55e'],
        plotOptions: {
            bar: {
                borderRadius: 8,
                horizontal: false,
                distributed: true,
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: @json(collect($aparByTipe)->pluck('tipe'))
        },
        legend: { show: false }
    };
    var tipeChart = new ApexCharts(document.querySelector("#tipeChart"), tipeOptions);
    tipeChart.render();
});
</script>
@endpush
