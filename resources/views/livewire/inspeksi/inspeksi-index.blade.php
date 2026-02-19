<div>
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Inspeksi APAR</h1>
            <p class="text-base-content/100">Kelola inspeksi bulanan APAR</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('inspeksi.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Inspeksi Baru
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="glass-card p-6 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-info/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-base-content/100">Inspeksi Bulan Ini</p>
                <p class="text-3xl font-bold text-info">{{ $totalThisMonth }}</p>
            </div>
        </div>
        <div class="glass-card p-6 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-warning/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-base-content/100">Perlu Inspeksi</p>
                <p class="text-3xl font-bold text-warning">{{ $aparNeedInspection }}</p>
                <p class="text-xs text-base-content/100">APAR belum diinspeksi bulan ini</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="glass-card p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="form-control">
                <input type="text" wire:model.live.debounce.300ms="search" 
                       placeholder="Cari APAR atau Lokasi..." 
                       class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50" />
            </div>
            <div class="form-control">
                <select wire:model.live="filterStatus" 
                        class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50">
                    <option value="">Semua Status</option>
                    <option value="baik">Baik</option>
                    <option value="kurang">Kurang</option>
                    <option value="rusak">Rusak</option>
                </select>
            </div>
            <div class="form-control">
                <select wire:model.live="filterMonth" 
                        class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control">
                <select wire:model.live="filterYear" 
                        class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50">
                    @foreach(range(now()->year, now()->year - 2) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="glass-card p-6">
        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead class="bg-base-200/40">
                    <tr>
                        <th class="border border-base-200/70">APAR</th>
                        <th class="border border-base-200/70">Lokasi</th>
                        <th class="border border-base-200/70">Tanggal</th>
                        <th class="border border-base-200/70">Inspector</th>
                        <th class="border border-base-200/70">Pressure</th>
                        <th class="border border-base-200/70">Status</th>
                        <th class="border border-base-200/70">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-base-200/70">
                    @forelse($inspeksiList as $inspeksi)
                    <tr class="hover:bg-base-200/30 transition">
                        <td class="border border-base-200/70 font-mono font-medium">{{ $inspeksi->apar->id_apar }}</td>
                        <td class="border border-base-200/70">{{ $inspeksi->apar->lokasi->nama_lokasi ?? '-' }}</td>
                        <td class="border border-base-200/70">{{ $inspeksi->tanggal_inspeksi->format('d/m/Y') }}</td>
                        <td class="border border-base-200/70">{{ $inspeksi->user->name }}</td>
                        <td class="border border-base-200/70 text-center">
                            <span class="pressure-indicator pressure-{{ $inspeksi->pressure_status }}"></span>
                        </td>
                        <td class="border border-base-200/70">
                            <span class="badge {{ $inspeksi->overall_status_badge }} badge-sm">
                                {{ ucfirst($inspeksi->overall_status) }}
                            </span>
                        </td>
                        <td class="border border-base-200/70">
                            <a href="{{ route('inspeksi.show', $inspeksi->id_inspeksi) }}" class="btn btn-ghost btn-sm btn-square">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-base-content/100 border border-base-200/70">
                            Tidak ada data inspeksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($inspeksiList->hasPages())
        <div class="mt-4 border-t border-base-200/70 pt-4">
            {{ $inspeksiList->links() }}
        </div>
        @endif
    </div>
</div>