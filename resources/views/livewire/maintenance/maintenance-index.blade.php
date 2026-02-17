<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Maintenance / Work Order</h1>
            <p class="text-base-content/50 text-sm">Kelola jadwal perawatan dan perbaikan APAR</p>
        </div>
        <button wire:click="openModal" class="btn btn-primary btn-sm shadow-sm shadow-primary/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Work Order
        </button>
    </div>

    @if(session('message'))
    <div class="alert alert-success mb-4 text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('message') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-3 mb-4">
        <div class="card bg-warning/5 border border-warning/20 p-4">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Pending</p>
            <p class="text-2xl font-bold text-warning">{{ $stats['pending'] }}</p>
        </div>
        <div class="card bg-info/5 border border-info/20 p-4">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">In Progress</p>
            <p class="text-2xl font-bold text-info">{{ $stats['in_progress'] }}</p>
        </div>
        <div class="card bg-success/5 border border-success/20 p-4">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Selesai</p>
            <p class="text-2xl font-bold text-success">{{ $stats['completed'] }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card bg-base-100 shadow-sm border border-base-300/50 mb-4">
        <div class="card-body p-4">
            <div class="flex flex-wrap gap-3">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari WO / APAR..." class="input input-bordered input-sm w-full md:w-64" />
                <select wire:model.live="filterStatus" class="select select-bordered select-sm">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
                <select wire:model.live="filterType" class="select select-bordered select-sm">
                    <option value="">Semua Tipe</option>
                    <option value="ringan">Ringan</option>
                    <option value="sedang">Sedang</option>
                    <option value="berat">Berat</option>
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
                        <tr><th>WO Number</th><th>APAR</th><th>Tipe</th><th>Prioritas</th><th>Jadwal</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($maintenanceList as $wo)
                        <tr class="hover">
                            <td class="font-mono text-sm font-medium">{{ $wo->wo_number }}</td>
                            <td>
                                <div class="text-sm font-medium">{{ $wo->apar->id_apar ?? '-' }}</div>
                                <div class="text-xs text-base-content/50">{{ $wo->apar->lokasi->nama_lokasi ?? '-' }}</div>
                            </td>
                            <td><span class="badge badge-outline badge-sm">{{ ucfirst($wo->maintenance_type) }}</span></td>
                            <td>
                                <span class="badge badge-sm
                                    {{ $wo->priority === 'urgent' ? 'badge-error' : '' }}
                                    {{ $wo->priority === 'high' ? 'badge-warning' : '' }}
                                    {{ $wo->priority === 'normal' ? 'badge-info' : '' }}
                                    {{ $wo->priority === 'low' ? 'badge-ghost' : '' }}
                                ">{{ ucfirst($wo->priority) }}</span>
                            </td>
                            <td class="text-sm">{{ \Carbon\Carbon::parse($wo->scheduled_date)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge badge-sm
                                    {{ $wo->status === 'pending' ? 'badge-warning' : '' }}
                                    {{ $wo->status === 'in_progress' ? 'badge-info' : '' }}
                                    {{ $wo->status === 'completed' ? 'badge-success' : '' }}
                                ">{{ ucfirst(str_replace('_', ' ', $wo->status)) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-8 text-base-content/40">Tidak ada work order</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($maintenanceList->hasPages())
            <div class="p-4 border-t border-base-300/50">{{ $maintenanceList->links() }}</div>
            @endif
        </div>
    </div>

    {{-- Create Modal --}}
    @if($showModal)
    <div class="modal modal-open">
        <div class="modal-box max-w-lg">
            <h3 class="font-bold text-lg mb-4">Buat Work Order</h3>
            <form wire:submit.prevent="save" class="space-y-4">
                <label class="form-control w-full">
                    <div class="label"><span class="label-text font-medium">APAR <span class="text-error">*</span></span></div>
                    <select wire:model="id_apar" class="select select-bordered" required>
                        <option value="">Pilih APAR</option>
                        @foreach($aparList as $apar)
                        <option value="{{ $apar->id_apar }}">{{ $apar->id_apar }}</option>
                        @endforeach
                    </select>
                    @error('id_apar') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                </label>

                <label class="form-control w-full">
                    <div class="label"><span class="label-text font-medium">Tipe Maintenance <span class="text-error">*</span></span></div>
                    <select wire:model="maintenance_type" class="select select-bordered">
                        <option value="ringan">Ringan</option>
                        <option value="sedang">Sedang</option>
                        <option value="berat">Berat</option>
                    </select>
                </label>

                <label class="form-control w-full">
                    <div class="label"><span class="label-text font-medium">Deskripsi <span class="text-error">*</span></span></div>
                    <textarea wire:model="description" class="textarea textarea-bordered min-h-20" placeholder="Jelaskan detail masalah..." required></textarea>
                    @error('description') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                </label>

                <div class="grid grid-cols-2 gap-4">
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Jadwal <span class="text-error">*</span></span></div>
                        <input type="date" wire:model="scheduled_date" class="input input-bordered" required />
                        @error('scheduled_date') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Prioritas</span></div>
                        <select wire:model="priority" class="select select-bordered">
                            <option value="low">Low</option>
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </label>
                </div>

                <div class="modal-action">
                    <button type="button" wire:click="closeModal" class="btn btn-ghost">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="save">Simpan</span>
                        <span wire:loading wire:target="save" class="loading loading-spinner loading-xs"></span>
                    </button>
                </div>
            </form>
        </div>
        <div class="modal-backdrop" wire:click="closeModal"></div>
    </div>
    @endif
</div>
