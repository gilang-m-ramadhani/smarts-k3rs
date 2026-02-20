<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Form Inspeksi APAR</h1>
            <p class="text-base-content/100">Isi checklist inspeksi bulanan</p>
        </div>
        <a href="{{ route('inspeksi.index') }}" class="btn btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- WRAPPER UTAMA DENGAN LOGIKA ALPINE JS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" 
         x-data="{
            checklist: {
                kondisi_tabung: @entangle('kondisi_tabung'),
                kondisi_selang: @entangle('kondisi_selang'),
                kondisi_pin: @entangle('kondisi_pin'),
                kondisi_segel: @entangle('kondisi_segel'),
                kondisi_nozzle: @entangle('kondisi_nozzle'),
                kondisi_label: @entangle('kondisi_label'),
                kondisi_mounting: @entangle('kondisi_mounting'),
                aksesibilitas: @entangle('aksesibilitas'),
                signage: @entangle('signage')
            },
            get passedCount() {
                return Object.values(this.checklist).filter(v => v == true).length;
            },
            get totalCount() {
                return Object.keys(this.checklist).length;
            },
            get percentage() {
                return this.totalCount > 0 ? Math.round((this.passedCount / this.totalCount) * 100) : 0;
            }
         }">

        <div class="lg:col-span-2 space-y-6">
            <div class="glass-card p-6">
                <h3 class="font-semibold text-lg mb-4 text-base-content">Pilih APAR</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">APAR *</span>
                        </label>
                        <select wire:model.live="aparId" 
                                class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50 @error('aparId') border-secondary @enderror">
                            <option value="">Pilih APAR...</option>
                            @foreach($aparList as $apar)
                                <option value="{{ $apar->id_apar }}">
                                    {{ $apar->id_apar }} - {{ $apar->lokasi->nama_lokasi ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('aparId') <span class="label-text-alt text-secondary">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Tanggal Inspeksi *</span>
                        </label>
                        <input type="date" wire:model="tanggal_inspeksi" 
                               class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50 @error('tanggal_inspeksi') border-secondary @enderror" />
                        @error('tanggal_inspeksi') <span class="label-text-alt text-secondary">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <h3 class="font-semibold text-lg mb-4 text-base-content">Checklist Inspeksi</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $checklistFields = [
                            'kondisi_tabung' => ['Kondisi Tabung', 'Tidak berkarat, penyok, atau bocor'],
                            'kondisi_selang' => ['Kondisi Selang', 'Tidak retak, sobek, atau tersumbat'],
                            'kondisi_pin' => ['Kondisi Pin Pengaman', 'Pin terpasang dengan benar'],
                            'kondisi_segel' => ['Kondisi Segel', 'Segel masih utuh'],
                            'kondisi_nozzle' => ['Kondisi Nozzle', 'Tidak tersumbat atau rusak'],
                            'kondisi_label' => ['Label Terbaca', 'Instruksi penggunaan terbaca jelas'],
                            'kondisi_mounting' => ['Mounting Bracket', 'Bracket terpasang kuat'],
                            'aksesibilitas' => ['Aksesibilitas', 'Mudah dijangkau, tidak terhalang'],
                            'signage' => ['Signage', 'Tanda lokasi APAR terlihat jelas'],
                        ];
                    @endphp

                    @foreach($checklistFields as $field => $label)
                    <div class="checklist-item cursor-pointer p-3 rounded-xl border transition-all duration-200"
                         :class="checklist.{{ $field }} ? 'bg-primary bg-opacity-10 border-primary' : 'bg-secondary bg-opacity-10 border-secondary'"
                         @click="checklist.{{ $field }} = !checklist.{{ $field }}">
                        
                        <div class="flex items-center gap-3">
                            <input type="checkbox" 
                                   x-model="checklist.{{ $field }}"
                                   class="checkbox transition-colors duration-200" 
                                   :class="checklist.{{ $field }} ? 'checkbox-primary' : 'checkbox-secondary'"
                                   @click.stop />
                            
                            <div class="select-none">
                                <p class="font-medium text-base-content">{{ $label[0] }}</p>
                                <p class="text-xs text-base-content/100">{{ $label[1] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 p-4 glass-card p-4">
                    <p class="font-medium text-base mb-3 text-base-content">Kondisi Pressure Gauge *</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        @foreach(['hijau' => 'Normal', 'kuning' => 'Perlu Perhatian', 'merah' => 'Kritis'] as $value => $desc)
                        <div class="p-4 rounded-xl cursor-pointer transition-all duration-200 
                                    {{ $kondisi_pressure === $value ? 'bg-' . ($value === 'hijau' ? 'primary' : ($value === 'kuning' ? 'accent' : 'secondary')) . '/20 ring-2 ring-' . ($value === 'hijau' ? 'primary' : ($value === 'kuning' ? 'accent' : 'secondary')) 
                                       : 'bg-white/30 backdrop-blur-sm border border-white/30 hover:bg-white/40' }}"
                             wire:click="$set('kondisi_pressure', '{{ $value }}')">
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-{{ $value === 'hijau' ? 'primary' : ($value === 'kuning' ? 'accent' : 'secondary') }} flex items-center justify-center">
                                    @if($kondisi_pressure === $value)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium text-base-content">{{ ucfirst($value) }}</p>
                                    <p class="text-xs text-base-content/100">{{ $desc }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <h3 class="font-semibold text-lg mb-4 text-base-content">Catatan & Rekomendasi</h3>
                
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text text-base-content/80">Catatan</span>
                    </label>
                    <textarea wire:model="catatan" 
                              class="textarea w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 h-24" 
                              placeholder="Catatan tambahan hasil inspeksi..."></textarea>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-base-content/80">Rekomendasi</span>
                    </label>
                    <textarea wire:model="rekomendasi" 
                              class="textarea w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content placeholder:text-base-content/70 focus:bg-white/50 h-24" 
                              placeholder="Rekomendasi tindak lanjut jika ada..."></textarea>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            @if($selectedApar)
            <div class="glass-card p-6">
                <h3 class="font-semibold text-lg mb-4 text-base-content">Info APAR</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-base-content/100">ID APAR:</span>
                        <span class="font-mono font-medium text-base-content">{{ $selectedApar->id_apar }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/100">Tipe:</span>
                        <span class="badge badge-outline">{{ $selectedApar->tipe_apar_label }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/100">Merk:</span>
                        <span class="text-base-content">{{ $selectedApar->merk }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/100">Kapasitas:</span>
                        <span class="text-base-content">{{ $selectedApar->kapasitas }} Kg</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/100">Lokasi:</span>
                        <span class="text-base-content">{{ $selectedApar->lokasi->nama_lokasi ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/100">Status:</span>
                        <span class="badge badge-primary badge-sm">{{ $selectedApar->status }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/100">Expire:</span>
                        <span class="{{ $selectedApar->is_expired ? 'text-secondary' : 'text-base-content' }}">{{ $selectedApar->tanggal_expire?->format('d/m/Y') ?? '-' }}</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="glass-card p-6">
                <h3 class="font-semibold text-lg mb-4 text-base-content">Ringkasan</h3>
                
                <div class="text-center mb-4">
                    <div class="radial-progress transition-all duration-500 ease-out" 
                         :class="percentage >= 80 ? 'text-primary' : (percentage >= 50 ? 'text-accent' : 'text-secondary')" 
                         :style="'--value:' + percentage + '; --size:6rem;'">
                        <span x-text="percentage + '%'"></span>
                    </div>
                </div>
                
                <p class="text-center text-sm text-base-content/100">
                    <span x-text="passedCount"></span>/<span x-text="totalCount"></span> checklist terpenuhi
                </p>
                
                <div class="mt-3 flex items-center justify-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-{{ $kondisi_pressure === 'hijau' ? 'primary' : ($kondisi_pressure === 'kuning' ? 'accent' : 'secondary') }}"></span>
                    <span class="text-sm text-base-content">Pressure: {{ ucfirst($kondisi_pressure) }}</span>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary to-secondary text-white shadow-2xl overflow-hidden rounded-3xl p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Simpan Inspeksi</h3>
                        <p class="text-sm opacity-80">Data akan tersimpan</p>
                    </div>
                </div>
                <p class="text-sm opacity-70 mb-4">Pastikan semua data sudah benar sebelum menyimpan.</p>
                <button wire:click="save" class="btn btn-lg w-full bg-white text-primary hover:bg-white/90 border-0 shadow-lg" wire:loading.attr="disabled">
                    <span wire:loading.remove class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="font-semibold">Simpan Inspeksi</span>
                    </span>
                    <span wire:loading class="flex items-center gap-2">
                        <span class="loading loading-spinner"></span>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>