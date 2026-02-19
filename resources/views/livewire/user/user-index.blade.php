<div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Manajemen User</h1>
            <p class="text-base-content/100">Kelola akun pengguna sistem</p>
        </div>
        <button wire:click="openModal" class="btn btn-primary mt-4 md:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah User
        </button>
    </div>

    @if(session()->has('message'))
    <div class="alert alert-success mb-4">{{ session('message') }}</div>
    @endif

    <!-- Search Card -->
    <div class="glass-card p-4 mb-6">
        <input type="text" 
               wire:model.live.debounce.300ms="search" 
               placeholder="Cari user..." 
               class="input w-full md:w-1/3 bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50" />
    </div>

    <!-- Table Card -->
    <div class="glass-card p-6">
        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead class="bg-base-200/40">
                    <tr>
                        <th class="border border-base-200/70">Nama</th>
                        <th class="border border-base-200/70">Email</th>
                        <th class="border border-base-200/70">Department</th>
                        <th class="border border-base-200/70">Role</th>
                        <th class="border border-base-200/70">Status</th>
                        <th class="border border-base-200/70">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-base-200/70">
                    @forelse($users as $user)
                    <tr class="hover:bg-base-200/30 transition">
                        <td class="border border-base-200/70">
                            <div class="flex items-center gap-3">
                                <div class="avatar placeholder">
                                    <div class="bg-primary text-primary-content rounded-full w-10">
                                        <span class="text-white">{{ $user->initials }}</span>
                                    </div>
                                </div>
                                <div class="font-medium text-base-content">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td class="border border-base-200/70">{{ $user->email }}</td>
                        <td class="border border-base-200/70">{{ $user->department ?? '-' }}</td>
                        <td class="border border-base-200/70">
                            <span class="badge badge-outline badge-sm">{{ $user->roles->first()?->name ?? '-' }}</span>
                        </td>
                        <td class="border border-base-200/70">
                            <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-ghost' }} badge-sm">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="border border-base-200/70">
                            <button wire:click="openModal({{ $user->id }})" class="btn btn-ghost btn-sm btn-square">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-base-content/100 border border-base-200/70">
                            Tidak ada data user
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="mt-4 border-t border-base-200/70 pt-4">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="modal modal-open">
        <div class="modal-box glass-card p-8 max-w-lg">
            <h3 class="font-bold text-lg mb-4 text-base-content">{{ $editMode ? 'Edit User' : 'Tambah User' }}</h3>
            <form wire:submit.prevent="save" class="space-y-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-base-content/80">Nama *</span>
                    </label>
                    <input type="text" wire:model="name" 
                           class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 @error('name') border-error @enderror" />
                    @error('name') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-base-content/80">Email *</span>
                    </label>
                    <input type="email" wire:model="email" 
                           class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 @error('email') border-error @enderror" />
                    @error('email') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-base-content/80">Password {{ $editMode ? '(kosongkan jika tidak diubah)' : '*' }}</span>
                    </label>
                    <input type="password" wire:model="password" 
                           class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 @error('password') border-error @enderror" />
                    @error('password') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Phone</span>
                        </label>
                        <input type="text" wire:model="phone" 
                               class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Department</span>
                        </label>
                        <input type="text" wire:model="department" 
                               class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-base-content/80">Role *</span>
                    </label>
                    <select wire:model="role" 
                            class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50 @error('role') border-error @enderror">
                        <option value="">Pilih Role</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                        @endforeach
                    </select>
                    @error('role') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-4">
                        <input type="checkbox" wire:model="is_active" class="toggle toggle-success" />
                        <span class="label-text text-base-content/80">User Aktif</span>
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