<div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Laporan</h1>
            <p class="text-base-content/100">Statistik dan laporan bulanan APAR</p>
        </div>
    </div>

    @if(session()->has('message'))
    <div class="alert alert-success mb-4">{{ session('message') }}</div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="glass-card p-6 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-[#662D91]/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#662D91]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-base-content/100">Total APAR</p>
                <p class="text-3xl font-bold text-[#662D91]">{{ $totalApar }}</p>
            </div>
        </div>

        <div class="glass-card p-6 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-primary/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-base-content/100">Aktif</p>
                <p class="text-3xl font-bold text-primary">{{ $aparByStatus['aktif'] }}</p>
            </div>
        </div>

        <div class="glass-card p-6 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-accent/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-base-content/100">Rusak</p>
                <p class="text-3xl font-bold text-accent">{{ $aparByStatus['rusak'] }}</p>
            </div>
        </div>

        <div class="glass-card p-6 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-secondary/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-base-content/100">Expired</p>
                <p class="text-3xl font-bold text-secondary">{{ $aparByStatus['expired'] }}</p>
            </div>
        </div>
    </div>

    <!-- Compliance Rate -->
    <div class="glass-card p-6 mb-6">
        <h3 class="card-title text-base-content mb-4">Compliance Rate Bulan Ini</h3>
        <div class="flex items-center gap-6">
            <div class="radial-progress text-primary text-3xl font-extrabold drop-shadow-lg"
                style="--value:{{ $complianceRate }}; --size:8rem;">
                {{ $complianceRate }}%
            </div>
            <div>
                <p class="text-lg font-medium text-base-content">{{ $inspeksiThisMonth }} / {{ $totalApar }} APAR</p>
                <p class="text-base-content/100">sudah diinspeksi bulan ini</p>
            </div>
        </div>
    </div>

    <!-- Generate Report -->
    <div class="glass-card p-6 mb-6">
        <h3 class="card-title text-base-content mb-4">Generate Laporan Bulanan</h3>
        <div class="flex flex-wrap gap-4 items-end">
            <div class="form-control">
                <label class="label">
                    <span class="label-text text-base-content/80">Bulan</span>
                </label>
                <select wire:model="selectedMonth" 
                        class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text text-base-content/80">Tahun</span>
                </label>
                <select wire:model="selectedYear" 
                        class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50">
                    @foreach(range(now()->year, now()->year - 2) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <button wire:click="generateReport" class="btn btn-primary">
                Generate Laporan
            </button>
        </div>
    </div>

    <!-- History -->
    <div class="glass-card p-6">
        <h3 class="card-title text-base-content mb-4">Riwayat Laporan</h3>
        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead class="bg-base-200/40">
                    <tr>
                        <th class="border border-base-200/70">Periode</th>
                        <th class="border border-base-200/70">Total APAR</th>
                        <th class="border border-base-200/70">Inspeksi</th>
                        <th class="border border-base-200/70">Compliance</th>
                        <th class="border border-base-200/70">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-base-200/70">
                    @forelse($laporanList as $lap)
                    <tr class="hover:bg-base-200/30 transition">
                        <td class="border border-base-200/70 font-medium">{{ $lap->periode }}</td>
                        <td class="border border-base-200/70">{{ $lap->total_apar }}</td>
                        <td class="border border-base-200/70">{{ $lap->total_inspeksi }}</td>
                        <td class="border border-base-200/70">{{ $lap->compliance_rate }}%</td>
                        <td class="border border-base-200/70">
                            <span class="badge badge-sm {{ $lap->status_laporan === 'published' ? 'badge-success' : 'badge-ghost' }}">
                                {{ ucfirst($lap->status_laporan) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-base-content/100 border border-base-200/70">
                            Belum ada laporan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>