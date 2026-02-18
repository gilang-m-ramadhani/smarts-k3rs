<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Lokasi APAR</h1>
            <p class="text-base-content/50 text-sm">Kelola lokasi penempatan APAR</p>
        </div>
        <button wire:click="openCreateModal" class="btn btn-primary btn-sm shadow-sm shadow-primary/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Lokasi
        </button>
    </div>

    {{-- Filters --}}
    <div class="card bg-base-100 shadow-sm border border-base-300/50 mb-4">
        <div class="card-body p-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari lokasi..." class="input input-bordered input-sm w-full md:w-64" />
        </div>
    </div>

    {{-- Table --}}
    <div class="card bg-base-100 shadow-sm border border-base-300/50">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Lokasi</th>
                            <th>Gedung</th>
                            <th>Lantai</th>
                            <th>Ruangan</th>
                            <th>Jumlah APAR</th>
                            <th>Risiko</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lokasiList as $lokasi)
                        <tr class="hover">
                            <td class="font-medium">{{ $lokasi->nama_lokasi }}</td>
                            <td class="text-sm">{{ $lokasi->gedung ?? '-' }}</td>
                            <td class="text-sm">{{ $lokasi->lantai ?? '-' }}</td>
                            <td class="text-sm">{{ $lokasi->ruangan ?? '-' }}</td>
                            <td><span class="badge badge-primary badge-sm">{{ $lokasi->apar_count ?? 0 }} APAR</span></td>
                            <td>
                                @php
                                    $riskBadge = match($lokasi->kategori_risiko) {
                                        'rendah' => 'badge-success',
                                        'sedang' => 'badge-warning',
                                        'tinggi' => 'badge-error',
                                        default => 'badge-ghost',
                                    };
                                @endphp
                                <span class="badge badge-sm {{ $riskBadge }}">
                                    {{ ucfirst($lokasi->kategori_risiko ?? 'sedang') }}
                                </span>
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    <button wire:click="openEditModal({{ $lokasi->id_lokasi }})" class="btn btn-ghost btn-xs btn-square">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="delete({{ $lokasi->id_lokasi }})" wire:confirm="Yakin hapus lokasi ini?" class="btn btn-ghost btn-xs btn-square text-error">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-8 text-base-content/40">Tidak ada data lokasi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($lokasiList->hasPages())
            <div class="p-4 border-t border-base-300/50">{{ $lokasiList->links() }}</div>
            @endif
        </div>
    </div>

    {{-- Modal --}}
    @if($showModal)
    <div class="modal modal-open">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">{{ $editMode ? 'Edit Lokasi' : 'Tambah Lokasi' }}</h3>
            <form wire:submit.prevent="save" class="space-y-4">
                <label class="form-control w-full">
                    <div class="label"><span class="label-text font-medium">Nama Lokasi <span class="text-error">*</span></span></div>
                    <input type="text" wire:model="nama_lokasi" class="input input-bordered" required />
                    @error('nama_lokasi') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Gedung <span class="text-error">*</span></span></div>
                        <input type="text" wire:model="gedung" class="input input-bordered" required />
                        @error('gedung') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Lantai <span class="text-error">*</span></span></div>
                        <input type="text" wire:model="lantai" class="input input-bordered" required />
                        @error('lantai') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                </div>
                <label class="form-control w-full">
                    <div class="label"><span class="label-text font-medium">Ruangan <span class="text-error">*</span></span></div>
                    <input type="text" wire:model="ruangan" class="input input-bordered" required />
                    @error('ruangan') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                </label>
                <label class="form-control w-full">
                    <div class="label"><span class="label-text font-medium">Koordinat</span></div>
                    <input type="text" wire:model="koordinat" class="input input-bordered" placeholder="contoh: -6.9175, 107.6191" />
                </label>
                <label class="form-control w-full">
                    <div class="label"><span class="label-text font-medium">Kategori Risiko</span></div>
                    <select wire:model="kategori_risiko" class="select select-bordered">
                        <option value="rendah">Rendah</option>
                        <option value="sedang">Sedang</option>
                        <option value="tinggi">Tinggi</option>
                    </select>
                </label>
                <label class="form-control w-full">
                    <div class="label"><span class="label-text font-medium">Deskripsi</span></div>
                    <textarea wire:model="deskripsi" class="textarea textarea-bordered" placeholder="Keterangan tambahan..."></textarea>
                </label>
                <div class="modal-action">
                    <button type="button" wire:click="closeModal" class="btn btn-ghost">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="save">Simpan</span>
                        <span wire:loading wire:target="save" class="loading loading-spinner loading-sm"></span>
                    </button>
                </div>
            </form>
        </div>
        <div class="modal-backdrop" wire:click="closeModal"></div>
    </div>
    @endif
</div>
