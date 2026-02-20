<div>
    @if (session()->has('error'))
        <div class="alert alert-error mb-6 shadow-lg text-white font-bold rounded-xl flex items-center gap-2 p-4 bg-error">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-error mb-6 shadow-lg text-white font-bold rounded-xl flex flex-col items-start gap-1 p-4 bg-error">
            <div class="flex items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <span>Validasi Gagal:</span>
            </div>
            <ul class="list-disc list-inside ml-2 font-normal text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-card p-6">
                <h3 class="font-semibold text-lg mb-4 text-base-content">Pilih APAR</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">APAR *</span>
                        </label>
                        <select wire:model.live="aparId" 
                                class="select w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50 @error('aparId') border-error @enderror">
                            <option value="">Pilih APAR...</option>
                            @foreach($aparList as $apar)
                                <option value="{{ $apar->id_apar }}">
                                    {{ $apar->id_apar }} - {{ $apar->lokasi->nama_lokasi ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('aparId') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base-content/80">Tanggal Inspeksi *</span>
                        </label>
                        <input type="date" wire:model="tanggal_inspeksi" 
                               class="input w-full bg-white/50 backdrop-blur-md border-white/30 text-base-content focus:bg-white/50 @error('tanggal_inspeksi') border-error @enderror" />
                        @error('tanggal_inspeksi') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
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
                    <div class="checklist-item cursor-pointer p-3 rounded-xl backdrop-blur-sm border transition
                                {{ $$field ? 'bg-success/10 border-success' : 'bg-error/10 border-error' }}">

                        <div class="flex items-center gap-3">
                            <input type="checkbox" 
                                wire:model.live="{{ $field }}" 
                                class="checkbox {{ $$field ? 'checkbox-success' : 'checkbox-error' }}" />

                            <div>
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
                        @php
                            $pressureStyles = [
                                'hijau' => ['bg' => 'bg-success/20 ring-2 ring-success', 'dot' => 'bg-success'],
                                'kuning' => ['bg' => 'bg-warning/20 ring-2 ring-warning', 'dot' => 'bg-warning'],
                                'merah' => ['bg' => 'bg-error/20 ring-2 ring-error', 'dot' => 'bg-error'],
                            ];
                        @endphp

                        @foreach(['hijau' => 'Normal', 'kuning' => 'Perlu Perhatian', 'merah' => 'Kritis'] as $value => $desc)
                        <div class="p-4 rounded-xl cursor-pointer transition-all duration-200 
                                    {{ $kondisi_pressure === $value ? $pressureStyles[$value]['bg'] : 'bg-white/30 backdrop-blur-sm border border-white/30 hover:bg-white/40' }}"
                             wire:click="$set('kondisi_pressure', '{{ $value }}')">
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full {{ $pressureStyles[$value]['dot'] }} flex items-center justify-center">
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
                        <span class="badge {{ $selectedApar->status_badge_class ?? 'badge-info' }} badge-sm">{{ $selectedApar->status }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/100">Expire:</span>
                        <span class="{{ $selectedApar->is_expired ? 'text-error' : 'text-base-content' }}">{{ $selectedApar->tanggal_expire?->format('d/m/Y') ?? '-' }}</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="glass-card p-6">
                <h3 class="font-semibold text-lg mb-4 text-base-content">Ringkasan</h3>
                @php
                    $checklistItems = [$kondisi_tabung, $kondisi_selang, $kondisi_pin, $kondisi_segel,
                                      $kondisi_nozzle, $kondisi_label, $kondisi_mounting, $aksesibilitas, $signage];
                    $passed = collect($checklistItems)->filter()->count();
                    $total = count($checklistItems);
                    $percentage = $total > 0 ? round(($passed / $total) * 100) : 0;
                    
                    $summaryColors = [
                        'hijau' => 'bg-success',
                        'kuning' => 'bg-warning',
                        'merah' => 'bg-error',
                    ];
                @endphp
                <div class="text-center mb-4">
                    <div class="radial-progress text-{{ $percentage >= 80 ? 'success' : ($percentage >= 50 ? 'warning' : 'error') }}" style="--value:{{ $percentage }}; --size:6rem;">
                        {{ $percentage }}%
                    </div>
                </div>
                <p class="text-center text-sm text-base-content/100">
                    {{ $passed }}/{{ $total }} checklist terpenuhi
                </p>
                <div class="mt-3 flex items-center justify-center gap-2">
                    <span class="w-3 h-3 rounded-full {{ $summaryColors[$kondisi_pressure] ?? 'bg-success' }}"></span>
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
                
                {{-- KOTAK CHECKBOX DRY POWDER (HANYA MUNCUL JIKA APAR POWDER) --}}
                @if($selectedApar && $selectedApar->tipe_apar === 'powder')
                <div class="bg-white/20 p-4 rounded-xl mb-4 border border-white/30 transition-all">
                    <label class="cursor-pointer flex items-start gap-3">
                        <input type="checkbox" wire:model.live="is_reversed" class="checkbox mt-1 bg-white/80 border-white" />
                        <div>
                            <span class="font-bold text-white block text-sm">Tindakan Wajib (Dry Powder)</span>
                            <span class="text-xs opacity-90 leading-tight">Saya telah membalikkan tabung APAR secara perlahan sebanyak 3–5 kali untuk memastikan serbuk tidak menggumpal.</span>
                        </div>
                    </label>
                </div>
                @endif
                
                {{-- TOMBOL SIMPAN YANG STATUSNYA HANYA PATUH PADA is_reversed --}}
                <button wire:click="save" 
                        class="btn btn-lg w-full border-0 shadow-lg transition-colors {{ ($selectedApar && $selectedApar->tipe_apar === 'powder' && !$is_reversed) ? 'bg-gray-400 text-gray-200 cursor-not-allowed opacity-80 hover:bg-gray-400' : 'bg-white text-primary hover:bg-white/90' }}" 
                        wire:loading.attr="disabled"
                        @if($selectedApar && $selectedApar->tipe_apar === 'powder' && !$is_reversed) disabled @endif>
                    
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