<div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Work Order Maintenance</h1>
            <p class="text-base-content/100">Kelola work order pemeliharaan APAR</p>
        </div>
        <button wire:click="openModal" class="btn btn-primary mt-4 md:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Buat Work Order
        </button>
    </div>

    @if(session('message'))
    <div class="alert alert-success mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('message') }}</span>
    </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="glass-card p-6 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-success/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-base-content/100">Completed</p>
                <p class="text-3xl font-bold text-success">{{ $stats['completed'] }}</p>
            </div>
        </div>
        <div class="glass-card p-6 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-warning/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-base-content/100">Pending</p>
                <p class="text-3xl font-bold text-warning">{{ $stats['pending'] }}</p>
            </div>
        </div>
        <div class="glass-card p-6 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-info/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-base-content/100">In Progress</p>
                <p class="text-3xl font-bold text-info">{{ $stats['in_progress'] }}</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="glass-card p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" 
                   wire:model.live.debounce.300ms="search" 
                   placeholder="Cari WO atau APAR..." 
                   class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50" />
            <select wire:model.live="filterStatus" 
                    class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <select wire:model.live="filterType" 
                    class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50">
                <option value="">Semua Tipe</option>
                <option value="ringan">Ringan</option>
                <option value="sedang">Sedang</option>
                <option value="berat">Berat</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="glass-card p-6">
        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead class="bg-base-200/40">
                    <tr>
                        <th class="border border-base-200/70">No. WO</th>
                        <th class="border border-base-200/70">APAR</th>
                        <th class="border border-base-200/70">Tipe</th>
                        <th class="border border-base-200/70">Teknisi</th>
                        <th class="border border-base-200/70">Jadwal</th>
                        <th class="border border-base-200/70">Status</th>
                        <th class="border border-base-200/70">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-base-200/70">
                    @forelse($maintenanceList as $wo)
                    <tr class="hover:bg-base-200/30 transition">
                        <td class="border border-base-200/70 font-mono">{{ $wo->wo_number }}</td>
                        <td class="border border-base-200/70">
                            <div class="font-medium text-base-content">{{ $wo->apar->id_apar ?? '-' }}</div>
                            <div class="text-xs text-base-content/100">{{ $wo->apar->lokasi->nama_lokasi ?? '-' }}</div>
                        </td>
                        <td class="border border-base-200/70">
                            <span class="badge badge-outline badge-sm">{{ ucfirst($wo->maintenance_type) }}</span>
                        </td>
                        <td class="border border-base-200/70">{{ $wo->teknisi->name ?? 'Belum assign' }}</td>
                        <td class="border border-base-200/70">{{ $wo->scheduled_date?->format('d/m/Y') ?? '-' }}</td>
                        <td class="border border-base-200/70">
                            <span class="badge {{ $wo->status_badge ?? 'badge-info' }} badge-sm">
                                {{ ucfirst(str_replace('_', ' ', $wo->status)) }}
                            </span>
                        </td>
                        <td class="border border-base-200/70">
                            <button class="btn btn-ghost btn-sm btn-square">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-base-content/100 border border-base-200/70">
                            Tidak ada data work order
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($maintenanceList->hasPages())
        <div class="mt-4 border-t border-base-200/70 pt-4">
            {{ $maintenanceList->links() }}
        </div>
        @endif
    </div>

    <!-- Create Modal -->
    @if($showModal)
    <div class="modal modal-open">
        <div class="modal-box glass-card p-8 max-w-2xl">
            <h3 class="font-bold text-lg mb-4 text-base-content">Buat Work Order Baru</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control md:col-span-2">
                    <label class="label">
                        <span class="label-text text-base-content/80">APAR *</span>
                    </label>
                    <select wire:model="id_apar" 
                            class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50 @error('id_apar') border-error @enderror">
                        <option value="">Pilih APAR...</option>
                        @foreach($aparList as $apar)
                        <option value="{{ $apar->id_apar }}">{{ $apar->id_apar }} - {{ $apar->lokasi->nama_lokasi ?? '-' }}</option>
                        @endforeach
                    </select>
                    @error('id_apar') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-base-content/80">Tipe Maintenance *</span>
                    </label>
                    <select wire:model="maintenance_type" 
                            class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50">
                        <option value="ringan">Ringan</option>
                        <option value="sedang">Sedang</option>
                        <option value="berat">Berat</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-base-content/80">Prioritas</span>
                    </label>
                    <select wire:model="priority" 
                            class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50">
                        <option value="low">Low</option>
                        <option value="normal">Normal</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-base-content/80">Tanggal Jadwal *</span>
                    </label>
                    <input type="date" wire:model="scheduled_date" 
                           class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50 @error('scheduled_date') border-error @enderror" />
                    @error('scheduled_date') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-base-content/80">Assign Teknisi</span>
                    </label>
                    <select wire:model="assigned_to" 
                            class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50">
                        <option value="">Belum di-assign</option>
                        @foreach($teknisiList as $teknisi)
                        <option value="{{ $teknisi->id }}">{{ $teknisi->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control md:col-span-2">
                    <label class="label">
                        <span class="label-text text-base-content/80">Deskripsi *</span>
                    </label>
                    <textarea wire:model="description" 
                              class="textarea w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 h-24 @error('description') border-error @enderror" 
                              placeholder="Jelaskan pekerjaan yang perlu dilakukan..."></textarea>
                    @error('description') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="modal-action">
                <button wire:click="closeModal" class="btn btn-ghost">Batal</button>
                <button wire:click="save" class="btn btn-primary">
                    <span wire:loading.remove wire:target="save">Simpan</span>
                    <span wire:loading wire:target="save" class="loading loading-spinner loading-sm"></span>
                </button>
            </div>
        </div>
        <div class="modal-backdrop" wire:click="closeModal"></div>
    </div>
    @endif
</div>