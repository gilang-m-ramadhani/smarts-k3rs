<div>
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Lokasi APAR</h1>
            <p class="text-base-content/80">Kelola lokasi penempatan APAR</p>
        </div>
        <button wire:click="openModal" class="btn btn-primary mt-4 md:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Lokasi
        </button>
    </div>

    @if(session()->has('message'))
    <div class="alert alert-success mb-4">{{ session('message') }}</div>
    @endif
    @if(session()->has('error'))
    <div class="alert alert-error mb-4">{{ session('error') }}</div>
    @endif

    <!-- Search Card -->
    <div class="glass-card p-4 mb-6">
    <input type="text"
    wire:model.live.debounce.300ms="search"
    placeholder="Cari lokasi..."
    class="input input-modern w-full md:w-1/3 
           bg-white/50 backdrop-blur-md border-white/30 
           text-base-content 
           placeholder:text-base-content/70
           focus:bg-white/50" />

    </div>

    <!-- Table Card -->
    <div class="glass-card p-6">
        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead class="bg-base-200/40">
                    <tr>
                        <th class="border border-base-200/70">Nama Lokasi</th>
                        <th class="border border-base-200/70">Gedung</th>
                        <th class="border border-base-200/70">Lantai</th>
                        <th class="border border-base-200/70">Ruangan</th>
                        <th class="border border-base-200/70">Risiko</th>
                        <th class="border border-base-200/70">Jumlah APAR</th>
                        <th class="border border-base-200/70">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-base-200/70">
                    @forelse($lokasiList as $lokasi)
                    <tr class="hover:bg-base-200/30 transition">
                        <td class="border border-base-200/100 font-medium">{{ $lokasi->nama_lokasi }}</td>
                        <td class="border border-base-200/100">{{ $lokasi->gedung }}</td>
                        <td class="border border-base-200/100 text-center">{{ $lokasi->lantai }}</td>
                        <td class="border border-base-200/100">{{ $lokasi->ruangan }}</td>
                        <td class="border border-base-200/100">
                            <span @class([
                                'badge badge-sm',
                                'badge-error' => $lokasi->kategori_risiko === 'tinggi',
                                'badge-warning' => $lokasi->kategori_risiko === 'sedang',
                                'badge-success' => $lokasi->kategori_risiko === 'rendah',
                            ])>
                                {{ ucfirst($lokasi->kategori_risiko) }}
                            </span>
                        </td>
                        <td class="border border-base-200/100 text-center">{{ $lokasi->apar_count }}</td>
                        <td class="border border-base-200/100">
                            <button wire:click="openModal({{ $lokasi->id_lokasi }})" class="btn btn-ghost btn-sm btn-square">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button wire:click="delete({{ $lokasi->id_lokasi }})" wire:confirm="Yakin hapus lokasi ini?" class="btn btn-ghost btn-sm btn-square text-error">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-base-content/80 border border-base-200/70">Tidak ada data lokasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($lokasiList->hasPages())
        <div class="mt-4 border-t border-base-200/70 pt-4">{{ $lokasiList->links() }}</div>
        @endif
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="modal modal-open">
        <div class="modal-box glass-card p-8 max-w-lg">
            <h3 class="font-bold text-lg mb-4 text-base-content">{{ $editMode ? 'Edit Lokasi' : 'Tambah Lokasi' }}</h3>
            <form wire:submit.prevent="save" class="space-y-4">
                <div class="form-control">
                    <label class="label"><span class="label-text text-base-content/80">Nama Lokasi *</span></label>
                    <input type="text" wire:model="nama_lokasi" class="input input-bordered w-full @error('nama_lokasi') input-error @enderror" />
                    @error('nama_lokasi') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text text-base-content/80">Gedung *</span></label>
                        <input type="text" wire:model="gedung" class="input input-bordered w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text text-base-content/80">Lantai *</span></label>
                        <input type="text" wire:model="lantai" class="input input-bordered w-full" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text text-base-content/80">Ruangan *</span></label>
                        <input type="text" wire:model="ruangan" class="input input-bordered w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text text-base-content/80">Koordinat</span></label>
                        <input type="text" wire:model="koordinat" placeholder="A1-ICU-01" class="input input-bordered w-full" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-base-content/80">Kategori Risiko</span></label>
                    <select wire:model="kategori_risiko" class="select select-bordered w-full">
                        <option value="rendah">Rendah</option>
                        <option value="sedang">Sedang</option>
                        <option value="tinggi">Tinggi</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-base-content/80">Deskripsi</span></label>
                    <textarea wire:model="deskripsi" class="textarea textarea-bordered w-full" rows="2"></textarea>
                </div>
                <div class="modal-action">
                    <button type="button" wire:click="$set('showModal', false)" class="btn btn-ghost">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
        <div class="modal-backdrop" wire:click="$set('showModal', false)"></div>
    </div>
    @endif
</div>