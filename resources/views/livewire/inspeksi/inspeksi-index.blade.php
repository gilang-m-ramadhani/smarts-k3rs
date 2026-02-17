<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Inspeksi APAR</h1>
            <p class="text-base-content/50 text-sm">Riwayat inspeksi bulanan — {{ now()->locale('id')->isoFormat('MMMM Y') }}</p>
        </div>
        <a href="{{ route('inspeksi.create') }}" class="btn btn-primary btn-sm shadow-sm shadow-primary/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Inspeksi
        </a>
    </div>

    {{-- Filters --}}
    <div class="card bg-base-100 shadow-sm border border-base-300/50 mb-4">
        <div class="card-body p-4">
            <div class="flex flex-wrap gap-3">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari APAR / lokasi..." class="input input-bordered input-sm w-full md:w-64" />
                <select wire:model.live="filterStatus" class="select select-bordered select-sm">
                    <option value="">Semua Status</option>
                    <option value="baik">Baik</option>
                    <option value="kurang">Kurang</option>
                    <option value="rusak">Rusak</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card bg-base-100 shadow-sm border border-base-300/50">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>APAR</th>
                            <th>Tanggal</th>
                            <th>Inspektor</th>
                            <th>Tekanan</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inspeksiList as $inspeksi)
                        <tr class="hover">
                            <td>
                                <div class="font-mono font-medium text-sm">{{ $inspeksi->apar->id_apar ?? '-' }}</div>
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
                            <td class="text-sm max-w-xs truncate">{{ $inspeksi->catatan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-8 text-base-content/40">Tidak ada data inspeksi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($inspeksiList->hasPages())
            <div class="p-4 border-t border-base-300/50">{{ $inspeksiList->links() }}</div>
            @endif
        </div>
    </div>
</div>
