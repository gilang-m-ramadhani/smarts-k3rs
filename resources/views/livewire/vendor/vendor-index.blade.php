<div>
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Vendor</h1>
            <p class="text-base-content/100">Kelola data vendor/supplier APAR</p>
        </div>
        <button wire:click="openModal" class="btn btn-primary mt-4 md:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Vendor
        </button>
    </div>

    @if(session()->has('message'))
    <div class="alert alert-success mb-4">{{ session('message') }}</div>
    @endif

    <!-- Search Card -->
    <div class="glass-card p-4 mb-6">
        <input type="text" 
               wire:model.live.debounce.300ms="search" 
               placeholder="Cari vendor..." 
               class="input w-full md:w-1/3 bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50" />
    </div>

    <!-- Table Card -->
    <div class="glass-card p-6">
        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead class="bg-base-200/40">
                    <tr>
                        <th class="border border-base-200/70">Nama Vendor</th>
                        <th class="border border-base-200/70">Contact Person</th>
                        <th class="border border-base-200/70">Phone</th>
                        <th class="border border-base-200/70">Email</th>
                        <th class="border border-base-200/70">APAR</th>
                        <th class="border border-base-200/70">Status</th>
                        <th class="border border-base-200/70">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-base-200/70">
                    @forelse($vendorList as $vendor)
                    <tr class="hover:bg-base-200/30 transition">
                        <td class="border border-base-200/70 font-medium">{{ $vendor->nama_vendor }}</td>
                        <td class="border border-base-200/70">{{ $vendor->contact_person }}</td>
                        <td class="border border-base-200/70">{{ $vendor->phone }}</td>
                        <td class="border border-base-200/70">{{ $vendor->email ?? '-' }}</td>
                        <td class="border border-base-200/70 text-center">{{ $vendor->apar_count }}</td>
                        <td class="border border-base-200/70 text-center">
                            <span class="badge {{ $vendor->is_active ? 'badge-success' : 'badge-ghost' }} badge-sm">
                                {{ $vendor->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="border border-base-200/70">
                            <button wire:click="openModal({{ $vendor->id_vendor }})" class="btn btn-ghost btn-sm btn-square">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button wire:click="delete({{ $vendor->id_vendor }})" wire:confirm="Yakin hapus vendor ini?" class="btn btn-ghost btn-sm btn-square text-error">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-base-content/100 border border-base-200/70">Tidak ada data vendor</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($vendorList->hasPages())
        <div class="mt-4 border-t border-base-200/70 pt-4">
            {{ $vendorList->links() }}
        </div>
        @endif
    </div>

    @if($showModal)
    <div class="modal modal-open">
        <div class="modal-box glass-card p-8 max-w-lg">
            <h3 class="font-bold text-lg mb-4 text-base-content">{{ $editMode ? 'Edit Vendor' : 'Tambah Vendor' }}</h3>
            <form wire:submit.prevent="save" class="space-y-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-base-content/80">Nama Vendor *</span>
                    </label>
                    <input type="text" wire:model="nama_vendor" 
                           class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 @error('nama_vendor') border-error @enderror" />
                    @error('nama_vendor') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-base-content/80">Alamat</span>
                    </label>
                    <textarea wire:model="alamat" 
                              class="textarea w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50" 
                              rows="2"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Contact Person *</span>
                        </label>
                        <input type="text" wire:model="contact_person" 
                               class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Phone *</span>
                        </label>
                        <input type="text" wire:model="phone" 
                               class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-base-content/80">Email</span>
                    </label>
                    <input type="email" wire:model="email" 
                           class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50" />
                </div>
                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-4">
                        <input type="checkbox" wire:model="is_active" class="toggle toggle-success" />
                        <span class="label-text text-base-content/80">Vendor Aktif</span>
                    </label>
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