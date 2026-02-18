<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">{{ $mode === 'create' ? 'Tambah APAR Baru' : 'Edit APAR' }}</h1>
            <p class="text-base-content/50 text-sm">{{ $mode === 'create' ? 'Registrasi APAR baru ke dalam sistem' : 'Perbarui informasi APAR' }}</p>
        </div>
        <a href="{{ route('apar.index') }}" class="btn btn-ghost btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        {{-- Identitas APAR --}}
        <div class="card bg-base-100 shadow-sm border border-base-300/50">
            <div class="card-body">
                <h2 class="card-title text-base font-bold mb-4">Identitas APAR</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Kode APAR <span class="text-error">*</span></span></div>
                        <input type="text" wire:model="id_apar" class="input input-bordered font-mono" {{ $mode === 'edit' ? 'readonly' : '' }} required />
                        @if($mode === 'create')
                        <div class="label"><button type="button" wire:click="generateNewId" class="label-text-alt link link-primary text-xs">Generate ID</button></div>
                        @endif
                        @error('id_apar') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Merk <span class="text-error">*</span></span></div>
                        <input type="text" wire:model="merk" class="input input-bordered" required />
                        @error('merk') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">No. Seri</span></div>
                        <input type="text" wire:model="no_seri" class="input input-bordered" />
                        @error('no_seri') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Tipe APAR <span class="text-error">*</span></span></div>
                        <select wire:model="tipe_apar" class="select select-bordered" required>
                            <option value="">Pilih Tipe</option>
                            <option value="powder">Powder</option>
                            <option value="co2">CO2</option>
                            <option value="foam">Foam</option>
                            <option value="liquid">Liquid Gas</option>
                        </select>
                        @error('tipe_apar') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Kapasitas (Kg) <span class="text-error">*</span></span></div>
                        <input type="number" wire:model="kapasitas" class="input input-bordered" step="0.5" min="0.1" required />
                        @error('kapasitas') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                </div>
            </div>
        </div>

        {{-- Lokasi & Vendor --}}
        <div class="card bg-base-100 shadow-sm border border-base-300/50">
            <div class="card-body">
                <h2 class="card-title text-base font-bold mb-4">Lokasi & Vendor</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Lokasi <span class="text-error">*</span></span></div>
                        <select wire:model="id_lokasi" class="select select-bordered" required>
                            <option value="">Pilih Lokasi</option>
                            @foreach($lokasiList as $lokasi)
                            <option value="{{ $lokasi->id_lokasi }}">{{ $lokasi->nama_lokasi }} - {{ $lokasi->gedung ?? '' }}</option>
                            @endforeach
                        </select>
                        @error('id_lokasi') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Vendor</span></div>
                        <select wire:model="id_vendor" class="select select-bordered">
                            <option value="">Pilih Vendor</option>
                            @foreach($vendorList as $vendor)
                            <option value="{{ $vendor->id_vendor }}">{{ $vendor->nama_vendor }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div>
        </div>

        {{-- Tanggal & Status --}}
        <div class="card bg-base-100 shadow-sm border border-base-300/50">
            <div class="card-body">
                <h2 class="card-title text-base font-bold mb-4">Tanggal & Status</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Tanggal Produksi <span class="text-error">*</span></span></div>
                        <input type="date" wire:model.live="tanggal_produksi" class="input input-bordered" required />
                        @error('tanggal_produksi') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Tanggal Pengisian</span></div>
                        <input type="date" wire:model="tanggal_pengisian" class="input input-bordered" />
                    </label>
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Tanggal Expired <span class="text-error">*</span></span></div>
                        <input type="date" wire:model="tanggal_expire" class="input input-bordered" required />
                        @error('tanggal_expire') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                </div>
                <div class="mt-4">
                    <span class="label-text font-medium">Status</span>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach(['aktif' => 'Aktif', 'rusak' => 'Rusak', 'expired' => 'Expired', 'maintenance' => 'Maintenance', 'disposed' => 'Disposed'] as $val => $label)
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="status" value="{{ $val }}" class="hidden peer" />
                            <span class="badge badge-lg peer-checked:badge-primary peer-checked:font-semibold badge-outline transition-all">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Photo --}}
        <div class="card bg-base-100 shadow-sm border border-base-300/50">
            <div class="card-body">
                <h2 class="card-title text-base font-bold mb-4">Foto APAR</h2>
                <input type="file" wire:model="foto" class="file-input file-input-bordered w-full" accept="image/*" />
                @if($foto)
                <div class="mt-3">
                    <img src="{{ $foto->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-xl border" />
                </div>
                @elseif($existingFoto)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $existingFoto) }}" class="w-32 h-32 object-cover rounded-xl border" />
                </div>
                @endif
                @error('foto') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('apar.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary shadow-sm shadow-primary/20">
                <span wire:loading.remove wire:target="save">Simpan</span>
                <span wire:loading wire:target="save" class="loading loading-spinner loading-sm"></span>
            </button>
        </div>
    </form>
</div>
