<div>
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-base-content">{{ $mode === 'create' ? 'Tambah APAR Baru' : 'Edit APAR' }}</h1>
            <p class="text-base-content/100">{{ $mode === 'create' ? 'Registrasi APAR baru ke dalam sistem' : 'Perbarui informasi APAR' }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('apar.index') }}" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <form wire:submit.prevent="save" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Identitas APAR -->
            <div class="glass-card p-6">
                <h2 class="form-section-title text-base-content mb-4">Identitas APAR</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- ID APAR -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Kode APAR <span class="text-error">*</span></span>
                        </label>
                        <div class="join w-full">
                            <input type="text" 
                                   wire:model="id_apar" 
                                   class="input join-item w-full font-mono bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 @error('id_apar') border-error @enderror"
                                   {{ $mode === 'edit' ? 'readonly' : '' }} />
                            @if($mode === 'create')
                            <button type="button" wire:click="generateNewId" class="btn btn-ghost join-item bg-white/50 backdrop-blur-md border-white/30 hover:bg-white/70" title="Generate ID Baru">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                            @endif
                        </div>
                        @error('id_apar') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nomor Seri -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Nomor Seri</span>
                        </label>
                        <input type="text" 
                               wire:model="no_seri" 
                               placeholder="SN-XXXXXXXX"
                               class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 @error('no_seri') border-error @enderror" />
                        @error('no_seri') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tipe APAR -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Tipe APAR <span class="text-error">*</span></span>
                        </label>
                        <select wire:model="tipe_apar" 
                                class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50 @error('tipe_apar') border-error @enderror">
                            <option value="powder">Dry Chemical Powder</option>
                            <option value="co2">Carbon Dioxide (CO2)</option>
                            <option value="foam">Foam / Busa</option>
                            <option value="liquid">Liquid / Cairan</option>
                        </select>
                        @error('tipe_apar') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kapasitas -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Kapasitas (kg) <span class="text-error">*</span></span>
                        </label>
                        <input type="number" 
                               wire:model="kapasitas" 
                               step="0.5"
                               min="0.1"
                               class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 @error('kapasitas') border-error @enderror" />
                        @error('kapasitas') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Merk -->
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text text-base-content/80">Merk / Produsen <span class="text-error">*</span></span>
                        </label>
                        <input type="text" 
                               wire:model="merk" 
                               placeholder="Contoh: YAMATO, GUNNEBO, CHUBB"
                               class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 @error('merk') border-error @enderror" />
                        @error('merk') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Tanggal & Status -->
            <div class="glass-card p-6">
                <h2 class="form-section-title text-base-content mb-4">Tanggal & Status</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Tanggal Produksi -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Tanggal Produksi <span class="text-error">*</span></span>
                        </label>
                        <input type="date" 
                               wire:model.live="tanggal_produksi" 
                               class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 @error('tanggal_produksi') border-error @enderror" />
                        @error('tanggal_produksi') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tanggal Pengisian -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Tanggal Pengisian Terakhir</span>
                        </label>
                        <input type="date" 
                               wire:model="tanggal_pengisian" 
                               class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 @error('tanggal_pengisian') border-error @enderror" />
                        @error('tanggal_pengisian') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tanggal Expire -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Tanggal Expire <span class="text-error">*</span></span>
                        </label>
                        <input type="date" 
                               wire:model="tanggal_expire" 
                               class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 @error('tanggal_expire') border-error @enderror" />
                        @error('tanggal_expire') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <!-- Status -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Status <span class="text-error">*</span></span>
                        </label>
                        <div class="flex flex-wrap gap-2">
                        @foreach(['aktif' => 'success', 'rusak' => 'error', 'expired' => 'warning', 'maintenance' => 'info', 'disposed' => 'ungu'] as $s => $color)
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="status" value="{{ $s }}" class="hidden peer" />
                            <span class="badge badge-lg badge-{{ $color }} badge-outline peer-checked:badge-{{ $color }} peer-checked:text-{{ $color === 'ungu' ? 'white' : $color }}-content peer-checked:shadow-md transition-all">
                                {{ ucfirst($s) }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                        @error('status') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Lokasi & Vendor -->
            <div class="glass-card p-6">
                <h2 class="form-section-title text-base-content mb-4">Lokasi & Vendor</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Lokasi -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Lokasi Penempatan <span class="text-error">*</span></span>
                        </label>
                        <select wire:model="id_lokasi" 
                                class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50 @error('id_lokasi') border-error @enderror">
                            <option value="">Pilih Lokasi</option>
                            @foreach($lokasiList as $lokasi)
                                <option value="{{ $lokasi->id_lokasi }}">{{ $lokasi->full_lokasi }}</option>
                            @endforeach
                        </select>
                        @error('id_lokasi') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Vendor -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Vendor / Supplier</span>
                        </label>
                        <select wire:model="id_vendor" 
                                class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50 @error('id_vendor') border-error @enderror">
                            <option value="">Pilih Vendor</option>
                            @foreach($vendorList as $vendor)
                                <option value="{{ $vendor->id_vendor }}">{{ $vendor->nama_vendor }}</option>
                            @endforeach
                        </select>
                        @error('id_vendor') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Foto -->
            <div class="glass-card p-6">
                <h2 class="form-section-title text-base-content mb-4">Dokumentasi</h2>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-base-content/80">Foto APAR</span>
                    </label>
                    <input type="file" 
                           wire:model="foto" 
                           accept="image/*"
                           class="file-input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content file:bg-white/20 file:border-0 file:text-base-content hover:file:bg-white/30 @error('foto') border-error @enderror" />
                    @error('foto') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                    
                    <div class="mt-4 flex gap-4">
                        @if($foto)
                        <div class="relative">
                            <img src="{{ $foto->temporaryUrl() }}" alt="Preview" class="w-32 h-32 object-cover rounded-lg" />
                            <span class="badge badge-sm badge-info absolute top-1 left-1">Preview</span>
                        </div>
                        @endif
                        
                        @if($existingFoto)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $existingFoto) }}" alt="Current" class="w-32 h-32 object-cover rounded-lg" />
                            <span class="badge badge-sm badge-ghost absolute top-1 left-1">Current</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- QR Code Preview -->
            <div class="glass-card p-6 text-center">
                <h3 class="card-title text-sm text-base-content mb-4">QR Code</h3>
                <div class="qr-container my-4 flex justify-center">
                    <div class="w-32 h-32 bg-base-200/50 backdrop-blur-md rounded flex items-center justify-center">
                        @if($kode_qr)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        @endif
                    </div>
                </div>
                <p class="text-xs text-base-content/100 font-mono">{{ $kode_qr ?? 'QR akan di-generate' }}</p>
                <p class="text-xs text-base-content/40">QR Code akan tersedia setelah data disimpan</p>
            </div>

            <!-- Summary -->
            <div class="glass-card p-6">
                <h3 class="card-title text-sm text-base-content mb-4">Ringkasan</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-base-content/100">Kode:</span>
                        <span class="font-mono font-medium text-base-content">{{ $id_apar ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/100">Tipe:</span>
                        <span class="text-base-content">{{ strtoupper($tipe_apar) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/100">Kapasitas:</span>
                        <span class="text-base-content">{{ $kapasitas }} kg</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/100">Merk:</span>
                        <span class="text-base-content">{{ $merk ?: '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <button type="submit" class="btn btn-primary w-full" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">
                        {{ $mode === 'create' ? 'Simpan APAR' : 'Update APAR' }}
                    </span>
                    <span wire:loading wire:target="save" class="loading loading-spinner"></span>
                </button>
                <a href="{{ route('apar.index') }}" class="btn btn-ghost w-full">Batal</a>
            </div>
        </div>
    </form>
</div>