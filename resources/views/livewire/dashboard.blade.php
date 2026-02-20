<div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Dashboard</h1>
            <p class="text-base-content/100">Selamat datang di SMART K3 - Sistem Manajemen APAR</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 mt-4 md:mt-0">
        <span class="badge badge-lg bg-primary text-white border-0 shadow-sm">
            {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </span>
            <div class="divider divider-horizontal mx-0 hidden md:flex"></div>
            <a href="{{ route('inspeksi.create') }}" class="btn btn-sm btn-primary gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Buat Inspeksi
            </a>
            <a href="{{ route('apar.create') }}" class="btn btn-sm btn-secondary text-white gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah APAR
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
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
                <span class="badge bg-primary text-white border-none badge-sm">{{ $aparAktif }} Aktif</span>
                <span class="badge bg-error text-white border-none badge-sm">{{ $aparRusak }} Rusak</span>
            </div>
        </a>

        <a href="{{ route('inspeksi.index') }}" class="glass-card p-6 group hover:scale-[1.02] transition-all duration-200 cursor-pointer hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-base-content/100 text-sm">Inspeksi Bulan Ini</p>
                    <p class="text-3xl font-bold text-secondary">{{ $inspeksiBulanIni }}</p>
                </div>
                <div class="w-14 h-14 rounded-full bg-secondary/10 flex items-center justify-center group-hover:bg-secondary group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-secondary group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between text-sm mb-1 text-secondary">
                    <span class="font-medium">Progress</span>
                    <span class="font-bold">{{ $complianceRate }}%</span>
                </div>
                <progress class="progress [&::-webkit-progress-value]:bg-secondary [&::-moz-progress-bar]:bg-secondary w-full bg-secondary/20" value="{{ $complianceRate }}" max="100"></progress>
            </div>
        </a>

        <a href="{{ route('maintenance.index') }}" class="glass-card p-6 group hover:scale-[1.02] transition-all duration-200 cursor-pointer hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-base-content/80 text-sm">Maintenance Pending</p>
                    <p class="text-3xl font-bold text-accent">{{ $maintenancePending }}</p>
                </div>
                <div class="w-14 h-14 rounded-full bg-accent/10 flex items-center justify-center group-hover:bg-accent group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-accent group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm text-accent font-medium group-hover:underline">
                <span>Lihat Detail</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>
        </a>

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
            <div class="mt-4 flex items-center gap-2 text-sm text-error font-medium group-hover:underline">
                <span>Perlu Tindakan</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="glass-card p-6">
            <h2 class="card-title text-lg mb-4 text-base-content">Status APAR</h2>
            <div id="statusChart" class="h-72"></div>
        </div>

        <div class="glass-card p-6">
            <h2 class="card-title text-lg mb-4 text-base-content">APAR Berdasarkan Tipe</h2>
            <div id="tipeChart" class="h-72"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="card-title text-lg text-base-content">Inspeksi Terbaru</h2>
                <a href="{{ route('inspeksi.index') }}" class="btn btn-ghost btn-sm text-primary">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
            <table class="table table-sm border border-base-200/70">
                <thead class="bg-base-200/40">
                    <tr>
                        <th class="border border-base-200/70">APAR</th>
                        <th class="border border-base-200/70">Tanggal</th>
                        <th class="border border-base-200/70">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-base-200/70">
                    @forelse($recentInspeksi as $inspeksi)
                    <tr class="hover:bg-base-200/30 transition">
                        <td class="border border-base-200/70">
                            <div class="font-medium font-mono text-primary">{{ $inspeksi->apar->id_apar }}</div>
                            <div class="text-xs text-base-content/70">
                                {{ $inspeksi->apar->lokasi->nama_lokasi ?? '-' }}
                            </div>
                        </td>

                        <td class="border border-base-200/70 font-medium">
                            {{ $inspeksi->tanggal_inspeksi->format('d/m/Y') }}
                        </td>

                        <td class="border border-base-200/70">
                            @php
                                $inspeksiBadge = match($inspeksi->overall_status) {
                                    'baik' => 'bg-primary text-white border-primary',
                                    'rusak' => 'bg-error text-white border-error',
                                    'kurang' => 'bg-accent text-white border-accent',
                                    default => 'badge-ghost'
                                };
                            @endphp
                            <span class="badge {{ $inspeksiBadge }} border badge-sm font-semibold">
                                {{ ucfirst($inspeksi->overall_status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-base-content/70 py-4 border border-base-200/70">
                            Belum ada data inspeksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="card-title text-lg text-base-content">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                            <div class="font-medium font-mono text-primary">{{ $apar->id_apar }}</div>
                            <div class="text-xs text-base-content/70">
                                {{ $apar->merk }} - <span class="uppercase">{{ $apar->tipe_apar }}</span>
                            </div>
                        </td>

                        <td class="border border-base-200/70 font-medium">
                            {{ $apar->lokasi->nama_lokasi ?? '-' }}
                        </td>

                        <td class="border border-base-200/70">
                            <span class="text-accent font-bold">
                                {{ $apar->tanggal_expire->format('d/m/Y') }}
                            </span>
                            <div class="text-xs text-error font-medium mt-1">
                                {{ $apar->days_until_expire }} hari lagi
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-base-content/70 border border-base-200/70">
                            Tidak ada APAR yang akan expired dalam 30 hari ke depan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="card-title text-lg text-base-content">Jadwal Maintenance</h2>
            <a href="{{ route('maintenance.index') }}" class="btn btn-ghost btn-sm text-primary">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
        <table class="table table-sm border border-base-200/70">
            <thead class="bg-base-200/40">
                <tr>
                    <th class="border border-base-200/70">No. WO</th>
                    <th class="border border-base-200/70">APAR</th>
                    <th class="border border-base-200/70 text-center">Tipe</th>
                    <th class="border border-base-200/70">Teknisi</th>
                    <th class="border border-base-200/70">Jadwal</th>
                    <th class="border border-base-200/70">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-base-200/70">
                @forelse($upcomingMaintenance as $wo)
                <tr class="hover:bg-base-200/30 transition">
                    <td class="font-mono font-bold text-primary border border-base-200/70">
                        {{ $wo->wo_number }}
                    </td>

                    <td class="border border-base-200/70">
                        <div class="font-medium font-mono">{{ $wo->apar->id_apar }}</div>
                        <div class="text-xs text-base-content/70">
                            {{ $wo->apar->lokasi->nama_lokasi ?? '-' }}
                        </div>
                    </td>

                    <td class="border border-base-200/70 text-center">
                        <div class="w-full">
                            <span class="badge border-primary text-primary badge-outline badge-sm w-full justify-center whitespace-normal leading-tight">
                                {{ $wo->maintenance_type_label }}
                            </span>
                        </div>
                    </td>

                    <td class="border border-base-200/70 font-medium">
                        {{ $wo->teknisi->name ?? 'Belum ditentukan' }}
                    </td>

                    <td class="border border-base-200/70 font-medium">
                        {{ $wo->scheduled_date->format('d/m/Y') }}
                    </td>

                    <td class="border border-base-200/70">
                        @php
                            $woBadge = match($wo->status) {
                                'pending' => 'bg-accent text-white border-accent',
                                'in_progress' => 'bg-info text-secondary border-info',
                                'completed' => 'bg-primary text-white border-primary',
                                'cancelled' => 'bg-error text-white border-error',
                                default => 'badge-ghost'
                            };
                        @endphp
                        <span class="badge {{ $woBadge }} border badge-sm font-semibold">
                            {{ ucfirst(str_replace('_', ' ', $wo->status)) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-base-content/70 border border-base-200/70">
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
    const themeColors = {
        primary: '#00A651',   
        secondary: '#004D26',  
        accent: '#F7931D',     
        error: '#EF4444',      
        info: '#E6F7EE'        
    };

    // --- Status Chart (Donut) ---
    const statusLabels = @json(collect($aparByStatus)->pluck('status'));
    
    const mappedStatusColors = statusLabels.map(status => {
        let s = status.toLowerCase();
        if(s.includes('aktif')) return themeColors.primary;
        if(s.includes('rusak')) return themeColors.error;
        if(s.includes('expired')) return themeColors.accent;
        if(s.includes('disposed') || s.includes('maintenance')) return themeColors.secondary;
        return themeColors.info;
    });

    var statusOptions = {
        series: @json(collect($aparByStatus)->pluck('count')),
        labels: statusLabels,
        colors: mappedStatusColors.length > 0 ? mappedStatusColors : [themeColors.primary, themeColors.error, themeColors.accent, themeColors.secondary], 
        chart: {
            type: 'donut',
            height: 280,
            fontFamily: 'Inter, sans-serif'
        },
        stroke: { width: 2, colors: ['#ffffff'] },
        legend: { position: 'bottom' },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        name: { show: true },
                        value: { show: true, fontSize: '24px', fontWeight: 700 },
                        total: {
                            show: true,
                            label: 'Total APAR',
                            formatter: function () { return '{{ $totalApar }}' }
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

    // --- Tipe Chart (Bar) ---
    var tipeOptions = {
        series: [{
            name: 'Jumlah',
            data: @json(collect($aparByTipe)->pluck('count'))
        }],
        chart: {
            type: 'bar',
            height: 280,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif'
        },
        colors: [themeColors.primary, themeColors.accent, themeColors.secondary, themeColors.info],
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: false,
                distributed: true,
                columnWidth: '55%'
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: @json(collect($aparByTipe)->pluck('tipe')),
            labels: {
                style: { fontWeight: 600 }
            }
        },
        yaxis: {
            labels: { formatter: function(val) { return Math.floor(val); } } // Bulatkan angka y-axis
        },
        tooltip: {
            theme: 'light',
            y: { formatter: function(val) { return val + " Unit" } }
        },
        legend: { show: false }
    };
    var tipeChart = new ApexCharts(document.querySelector("#tipeChart"), tipeOptions);
    tipeChart.render();
});
</script>
@endpush