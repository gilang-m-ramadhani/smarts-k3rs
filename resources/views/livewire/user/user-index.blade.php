<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Manajemen User</h1>
            <p class="text-base-content/50 text-sm">Kelola akun pengguna sistem</p>
        </div>
        <button wire:click="openModal" class="btn btn-primary btn-sm shadow-sm shadow-primary/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah User
        </button>
    </div>

    @if(session('message'))
    <div class="alert alert-success mb-4 text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('message') }}
    </div>
    @endif

    {{-- Search --}}
    <div class="card bg-base-100 shadow-sm border border-base-300/50 mb-4">
        <div class="card-body p-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau email..." class="input input-bordered input-sm w-full md:w-64" />
        </div>
    </div>

    {{-- Table --}}
    <div class="card bg-base-100 shadow-sm border border-base-300/50">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr><th>User</th><th>Email</th><th>Role</th><th>Department</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="hover">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-primary/10 text-primary rounded-lg w-9">
                                            <span class="text-sm font-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                        </div>
                                    </div>
                                    <span class="font-medium text-sm">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="text-sm">{{ $user->email }}</td>
                            <td><span class="badge badge-primary badge-outline badge-sm">{{ $user->roles->first()?->name ?? '-' }}</span></td>
                            <td class="text-sm">{{ $user->department ?? '-' }}</td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-success badge-sm">Aktif</span>
                                @else
                                    <span class="badge badge-ghost badge-sm">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <button wire:click="openModal({{ $user->id }})" class="btn btn-ghost btn-xs">Edit</button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-8 text-base-content/40">Tidak ada user</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
            <div class="p-4 border-t border-base-300/50">{{ $users->links() }}</div>
            @endif
        </div>
    </div>

    {{-- User Modal --}}
    @if($showModal)
    <div class="modal modal-open">
        <div class="modal-box max-w-lg">
            <h3 class="font-bold text-lg mb-4">{{ $editMode ? 'Edit User' : 'Tambah User' }}</h3>
            <form wire:submit.prevent="save" class="space-y-4">
                <label class="form-control w-full">
                    <div class="label"><span class="label-text font-medium">Nama <span class="text-error">*</span></span></div>
                    <input type="text" wire:model="name" class="input input-bordered" placeholder="Nama lengkap" required />
                    @error('name') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                </label>

                <label class="form-control w-full">
                    <div class="label"><span class="label-text font-medium">Email <span class="text-error">*</span></span></div>
                    <input type="email" wire:model="email" class="input input-bordered" placeholder="email@example.com" required />
                    @error('email') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                </label>

                <label class="form-control w-full">
                    <div class="label"><span class="label-text font-medium">Password {{ $editMode ? '(kosongkan jika tidak diubah)' : '' }} <span class="text-error">{{ $editMode ? '' : '*' }}</span></span></div>
                    <input type="password" wire:model="password" class="input input-bordered" placeholder="******" {{ $editMode ? '' : 'required' }} />
                    @error('password') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                </label>

                <div class="grid grid-cols-2 gap-4">
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Role <span class="text-error">*</span></span></div>
                        <select wire:model="role" class="select select-bordered" required>
                            <option value="">Pilih Role</option>
                            @foreach($roles as $r)
                            <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                            @endforeach
                        </select>
                        @error('role') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Department</span></div>
                        <input type="text" wire:model="department" class="input input-bordered" placeholder="Departemen" />
                    </label>
                </div>

                <label class="form-control w-full">
                    <div class="label"><span class="label-text font-medium">Telepon</span></div>
                    <input type="text" wire:model="phone" class="input input-bordered" placeholder="No. telepon" />
                </label>

                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input type="checkbox" wire:model="is_active" class="toggle toggle-primary toggle-sm" />
                        <span class="label-text">Aktif</span>
                    </label>
                </div>

                <div class="modal-action">
                    <button type="button" wire:click="$set('showModal', false)" class="btn btn-ghost">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="save">{{ $editMode ? 'Update' : 'Simpan' }}</span>
                        <span wire:loading wire:target="save" class="loading loading-spinner loading-xs"></span>
                    </button>
                </div>
            </form>
        </div>
        <div class="modal-backdrop" wire:click="$set('showModal', false)"></div>
    </div>
    @endif
</div>
