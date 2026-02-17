<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Data APAR</h1>
            <p class="text-base-content/50 text-sm">Kelola seluruh data APAR rumah sakit</p>
        </div>
        <a href="{{ route('apar.create') }}" class="btn btn-primary btn-sm shadow-sm shadow-primary/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah APAR
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <div class="card bg-base-100 shadow-sm border border-base-300/50 p-4">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Total</p>
            <p class="text-2xl font-bold text-primary">{{ $totalApar }}</p>
        </div>
        <div class="card bg-success/5 border border-success/20 p-4">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Aktif</p>
            <p class="text-2xl font-bold text-success">{{ $aparAktif }}</p>
        </div>
        <div class="card bg-error/5 border border-error/20 p-4">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Rusak</p>
            <p class="text-2xl font-bold text-error">{{ $aparRusak }}</p>
        </div>
        <div class="card bg-warning/5 border border-warning/20 p-4">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Expired</p>
            <p class="text-2xl font-bold text-warning">{{ $aparExpired }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card bg-base-100 shadow-sm border border-base-300/50 mb-4">
        <div class="card-body p-4">
            <div class="flex flex-wrap gap-3">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari APAR..." class="input input-bordered input-sm w-full md:w-64" />
                <select wire:model.live="filterStatus" class="select select-bordered select-sm">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="rusak">Rusak</option>
                    <option value="expired">Expired</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                <select wire:model.live="filterTipe" class="select select-bordered select-sm">
                    <option value="">Semua Tipe</option>
                    <option value="powder">Powder</option>
                    <option value="co2">CO2</option>
                    <option value="foam">Foam</option>
                    <option value="liquid">Liquid Gas</option>
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
                            <th>ID APAR</th>
                            <th>Lokasi</th>
                            <th>Tipe</th>
                            <th>Kapasitas</th>
                            <th>Expired</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aparList as $apar)
                        <tr class="hover">
                            <td class="font-mono font-medium text-sm">{{ $apar->id_apar }}</td>
                            <td>
                                <div class="text-sm">{{ $apar->lokasi->nama_lokasi ?? '-' }}</div>
                                <div class="text-xs text-base-content/50">{{ $apar->lokasi->gedung ?? '' }}</div>
                            </td>
                            <td>
                                @php
                                    $tipeColors = [
                                        'powder' => 'bg-[#09637E] text-white',
                                        'co2'    => 'bg-[#088395] text-white',
                                        'foam'   => 'bg-[#7AB2B2] text-white',
                                        'liquid' => 'bg-[#EBF4F6] text-[#09637E]',
                                    ];
                                    $tipeClass = $tipeColors[$apar->tipe_apar] ?? 'bg-base-200';
                                @endphp
                                <span class="badge badge-sm {{ $tipeClass }} border-0 font-semibold">{{ strtoupper($apar->tipe_apar) }}</span>
                            </td>
                            <td class="text-sm font-semibold">{{ $apar->kapasitas }} Kg</td>
                            <td class="text-sm">{{ $apar->tanggal_expire?->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                <span class="badge badge-sm
                                    {{ $apar->status === 'aktif' ? 'badge-success' : '' }}
                                    {{ $apar->status === 'rusak' ? 'badge-error' : '' }}
                                    {{ $apar->status === 'expired' ? 'badge-warning' : '' }}
                                    {{ $apar->status === 'maintenance' ? 'badge-info' : '' }}
                                ">{{ ucfirst($apar->status) }}</span>
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="{{ route('apar.show', $apar->id_apar) }}" class="btn btn-ghost btn-xs btn-square" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('apar.edit', $apar->id_apar) }}" class="btn btn-ghost btn-xs btn-square" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button wire:click="confirmDelete('{{ $apar->id_apar }}')" class="btn btn-ghost btn-xs btn-square text-error" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-8 text-base-content/40">Tidak ada data APAR</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($aparList->hasPages())
            <div class="p-4 border-t border-base-300/50">{{ $aparList->links() }}</div>
            @endif
        </div>
    </div>

    {{-- Delete Modal --}}
    @if($showDeleteModal)
    <div class="modal modal-open">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
            <p class="py-4">Apakah Anda yakin ingin menghapus APAR ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="modal-action">
                <button wire:click="$set('showDeleteModal', false)" class="btn btn-ghost">Batal</button>
                <button wire:click="delete" class="btn btn-error">Hapus</button>
            </div>
        </div>
        <div class="modal-backdrop" wire:click="$set('showDeleteModal', false)"></div>
    </div>
    @endif
</div>
