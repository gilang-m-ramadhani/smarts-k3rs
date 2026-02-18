<div x-data="{
    checkItems: {
        seal_condition: @entangle('seal_condition'),
        hose_condition: @entangle('hose_condition'),
        nozzle_condition: @entangle('nozzle_condition'),
        handle_condition: @entangle('handle_condition'),
        label_condition: @entangle('label_condition'),
        signage_condition: @entangle('signage_condition'),
        height_position: @entangle('height_position'),
        accessibility: @entangle('accessibility'),
        cleanliness: @entangle('cleanliness'),
    },
    physicalCondition: @entangle('physical_condition'),
    pressureStatus: @entangle('pressure_status'),
    get score() {
        let s = 0;
        Object.values(this.checkItems).forEach(v => { if (v) s++ });
        if (this.physicalCondition === 'baik') s += 2;
        else if (this.physicalCondition === 'cukup') s += 1;
        if (this.pressureStatus === 'hijau') s += 2;
        else if (this.pressureStatus === 'kuning') s += 1;
        return s;
    },
    get maxScore() { return 13; },
    get percentage() { return Math.round((this.score / this.maxScore) * 100) },
    get gaugeColor() {
        if (this.percentage >= 85) return '#22c55e';
        if (this.percentage >= 60) return '#f59e0b';
        return '#ef4444';
    },
    get statusLabel() {
        if (this.percentage >= 85) return 'Baik';
        if (this.percentage >= 60) return 'Kurang';
        return 'Rusak';
    },
    get statusColorClass() {
        if (this.percentage >= 85) return 'text-success';
        if (this.percentage >= 60) return 'text-warning';
        return 'text-error';
    },
    get physicalDetail() {
        if (this.physicalCondition === 'baik') return { icon: '✅', desc: 'Tabung tidak penyok, tidak berkarat, cat tidak mengelupas, dan tidak ada kerusakan fisik.' };
        if (this.physicalCondition === 'cukup') return { icon: '⚠️', desc: 'Tabung sedikit berkarat atau cat mulai mengelupas, namun masih layak pakai.' };
        return { icon: '❌', desc: 'Tabung penyok, karat parah, bocor, atau kerusakan yang membuat APAR tidak layak pakai.' };
    },
    get pressureDetail() {
        if (this.pressureStatus === 'hijau') return { color: '#22c55e', label: 'Normal', desc: 'Jarum manometer berada di zona hijau — tekanan normal dan siap pakai.' };
        if (this.pressureStatus === 'kuning') return { color: '#f59e0b', label: 'Warning', desc: 'Jarum manometer di zona kuning — tekanan menurun, perlu pengisian ulang segera.' };
        return { color: '#ef4444', label: 'Bahaya', desc: 'Jarum manometer di zona merah — tekanan terlalu rendah/tinggi, APAR tidak dapat digunakan.' };
    }
}">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Form Inspeksi APAR</h1>
            <p class="text-base-content/50 text-sm">Lakukan pemeriksaan kondisi APAR</p>
        </div>
        <a href="{{ route('inspeksi.index') }}" class="btn btn-ghost btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        {{-- Pilih APAR & Tanggal --}}
        <div class="card bg-base-100 shadow-sm border border-base-300/50">
            <div class="card-body">
                <h2 class="card-title text-base font-bold mb-4">Data Inspeksi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Pilih APAR <span class="text-error">*</span></span></div>
                        <select wire:model.live="aparId" class="select select-bordered" required>
                            <option value="">Pilih APAR</option>
                            @foreach($aparList as $apar)
                            <option value="{{ $apar->id_apar }}">{{ $apar->id_apar }} — {{ $apar->lokasi->nama_lokasi ?? '-' }} ({{ strtoupper($apar->tipe_apar) }})</option>
                            @endforeach
                        </select>
                        @error('aparId') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Tanggal Inspeksi <span class="text-error">*</span></span></div>
                        <input type="date" wire:model="tanggal_inspeksi" class="input input-bordered" required />
                        @error('tanggal_inspeksi') <div class="label"><span class="label-text-alt text-error text-xs">{{ $message }}</span></div> @enderror
                    </label>
                </div>

                @if($selectedApar)
                <div class="mt-4 p-4 rounded-xl bg-primary/5 border border-primary/20">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div><span class="text-base-content/50 text-xs">Merk</span><br><strong>{{ $selectedApar->merk }}</strong></div>
                        <div><span class="text-base-content/50 text-xs">Tipe</span><br><strong>{{ strtoupper($selectedApar->tipe_apar) }}</strong></div>
                        <div><span class="text-base-content/50 text-xs">Kapasitas</span><br><strong>{{ $selectedApar->kapasitas }} Kg</strong></div>
                        <div><span class="text-base-content/50 text-xs">Lokasi</span><br><strong>{{ $selectedApar->lokasi->nama_lokasi ?? '-' }}</strong></div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════
            GAUGE + KONDISI FISIK + PRESSURE — TOP SECTION
            ═══════════════════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Gauge Widget --}}
            <div class="card bg-base-100 shadow-sm border border-base-300/50">
                <div class="card-body items-center text-center">
                    <h2 class="card-title text-base font-bold mb-2">Skor Inspeksi</h2>
                    <div class="relative w-44 h-44">
                        <svg viewBox="0 0 120 120" class="w-full h-full -rotate-90">
                            <circle cx="60" cy="60" r="52" fill="none" stroke="currentColor" stroke-width="10"
                                class="text-base-300/50" stroke-dasharray="326.7" stroke-dashoffset="0"
                                stroke-linecap="round" />
                            <circle cx="60" cy="60" r="52" fill="none"
                                :stroke="gaugeColor" stroke-width="10"
                                :stroke-dasharray="326.7"
                                :stroke-dashoffset="326.7 - (326.7 * percentage / 100)"
                                stroke-linecap="round"
                                style="transition: all 0.5s ease" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-4xl font-extrabold" :class="statusColorClass" x-text="percentage + '%'"></span>
                            <span class="text-sm font-bold mt-0.5" :class="statusColorClass" x-text="statusLabel"></span>
                        </div>
                    </div>
                    <p class="text-xs text-base-content/40 mt-2">Skor: <strong x-text="score"></strong> / <span x-text="maxScore"></span> parameter</p>

                    {{-- Mini breakdown --}}
                    <div class="mt-3 w-full space-y-1.5 text-xs">
                        <div class="flex items-center justify-between px-2 py-1 rounded bg-base-200/50">
                            <span class="text-base-content/60">Checklist (9)</span>
                            <span class="font-bold" x-text="Object.values(checkItems).filter(v => v).length + '/9'"></span>
                        </div>
                        <div class="flex items-center justify-between px-2 py-1 rounded bg-base-200/50">
                            <span class="text-base-content/60">Fisik (2)</span>
                            <span class="font-bold" x-text="physicalCondition === 'baik' ? '2/2' : physicalCondition === 'cukup' ? '1/2' : '0/2'"></span>
                        </div>
                        <div class="flex items-center justify-between px-2 py-1 rounded bg-base-200/50">
                            <span class="text-base-content/60">Tekanan (2)</span>
                            <span class="font-bold" x-text="pressureStatus === 'hijau' ? '2/2' : pressureStatus === 'kuning' ? '1/2' : '0/2'"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kondisi Fisik Tabung --}}
            <div class="card bg-base-100 shadow-sm border border-base-300/50">
                <div class="card-body">
                    <h2 class="card-title text-base font-bold mb-3">Kondisi Fisik Tabung</h2>
                    <div class="space-y-2">
                        <label class="cursor-pointer block">
                            <input type="radio" wire:model="physical_condition" x-model="physicalCondition" value="baik" class="hidden peer" />
                            <div class="p-3 rounded-xl border-2 border-base-300/50 peer-checked:border-success peer-checked:bg-success/5 transition-all">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-success"></span>
                                    <span class="font-bold text-sm">Baik</span>
                                </div>
                                <p class="text-xs text-base-content/50 mt-1 ml-5">Tidak penyok, tidak berkarat, cat utuh, tidak ada kerusakan fisik.</p>
                            </div>
                        </label>
                        <label class="cursor-pointer block">
                            <input type="radio" wire:model="physical_condition" x-model="physicalCondition" value="cukup" class="hidden peer" />
                            <div class="p-3 rounded-xl border-2 border-base-300/50 peer-checked:border-warning peer-checked:bg-warning/5 transition-all">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-warning"></span>
                                    <span class="font-bold text-sm">Cukup</span>
                                </div>
                                <p class="text-xs text-base-content/50 mt-1 ml-5">Sedikit karat / cat mengelupas, namun masih layak pakai.</p>
                            </div>
                        </label>
                        <label class="cursor-pointer block">
                            <input type="radio" wire:model="physical_condition" x-model="physicalCondition" value="rusak" class="hidden peer" />
                            <div class="p-3 rounded-xl border-2 border-base-300/50 peer-checked:border-error peer-checked:bg-error/5 transition-all">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-error"></span>
                                    <span class="font-bold text-sm">Rusak</span>
                                </div>
                                <p class="text-xs text-base-content/50 mt-1 ml-5">Penyok / karat parah / bocor — tidak layak pakai.</p>
                            </div>
                        </label>
                    </div>
                    {{-- Active condition detail --}}
                    <div class="mt-3 p-3 rounded-lg bg-base-200/40 border border-base-300/30 text-xs" x-show="physicalCondition" x-transition>
                        <span x-text="physicalDetail.icon" class="mr-1"></span>
                        <span x-text="physicalDetail.desc" class="text-base-content/70"></span>
                    </div>
                    @error('physical_condition') <div class="mt-2"><span class="text-error text-xs">{{ $message }}</span></div> @enderror
                </div>
            </div>

            {{-- Pressure Gauge --}}
            <div class="card bg-base-100 shadow-sm border border-base-300/50">
                <div class="card-body">
                    <h2 class="card-title text-base font-bold mb-3">Tekanan Manometer</h2>
                    <div class="space-y-2">
                        <label class="cursor-pointer block">
                            <input type="radio" wire:model="pressure_status" x-model="pressureStatus" value="hijau" class="hidden peer" />
                            <div class="p-3 rounded-xl border-2 border-base-300/50 peer-checked:border-success peer-checked:bg-success/5 transition-all">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-success"></span>
                                    <span class="font-bold text-sm">Hijau — Normal</span>
                                </div>
                                <p class="text-xs text-base-content/50 mt-1 ml-5">Jarum di zona hijau, tekanan normal, siap pakai.</p>
                            </div>
                        </label>
                        <label class="cursor-pointer block">
                            <input type="radio" wire:model="pressure_status" x-model="pressureStatus" value="kuning" class="hidden peer" />
                            <div class="p-3 rounded-xl border-2 border-base-300/50 peer-checked:border-warning peer-checked:bg-warning/5 transition-all">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-warning"></span>
                                    <span class="font-bold text-sm">Kuning — Warning</span>
                                </div>
                                <p class="text-xs text-base-content/50 mt-1 ml-5">Tekanan menurun, perlu pengisian ulang segera.</p>
                            </div>
                        </label>
                        <label class="cursor-pointer block">
                            <input type="radio" wire:model="pressure_status" x-model="pressureStatus" value="merah" class="hidden peer" />
                            <div class="p-3 rounded-xl border-2 border-base-300/50 peer-checked:border-error peer-checked:bg-error/5 transition-all">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-error"></span>
                                    <span class="font-bold text-sm">Merah — Bahaya</span>
                                </div>
                                <p class="text-xs text-base-content/50 mt-1 ml-5">Tekanan terlalu rendah/tinggi, tidak dapat digunakan.</p>
                            </div>
                        </label>
                    </div>
                    {{-- Active pressure detail --}}
                    <div class="mt-3 p-3 rounded-lg border text-xs flex items-center gap-2" x-show="pressureStatus" x-transition
                         :style="'background-color:' + pressureDetail.color + '10; border-color:' + pressureDetail.color + '30'">
                        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" :style="'background:' + pressureDetail.color"></span>
                        <span class="text-base-content/70" x-text="pressureDetail.desc"></span>
                    </div>
                    @error('pressure_status') <div class="mt-2"><span class="text-error text-xs">{{ $message }}</span></div> @enderror
                </div>
            </div>
        </div>

        {{-- Checklist Pemeriksaan --}}
        <div class="card bg-base-100 shadow-sm border border-base-300/50">
            <div class="card-body">
                <h2 class="card-title text-base font-bold mb-4">Checklist Pemeriksaan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @php
                    $checks = [
                        ['model' => 'seal_condition', 'label' => 'Seal / Pin Pengaman', 'desc' => 'Seal dan pin pengaman masih utuh'],
                        ['model' => 'hose_condition', 'label' => 'Kondisi Selang', 'desc' => 'Tidak retak, pecah, atau tersumbat'],
                        ['model' => 'nozzle_condition', 'label' => 'Nozzle / Corong', 'desc' => 'Tidak tersumbat atau rusak'],
                        ['model' => 'handle_condition', 'label' => 'Handle Operasi', 'desc' => 'Handle berfungsi dengan baik'],
                        ['model' => 'label_condition', 'label' => 'Label Instruksi', 'desc' => 'Terlihat jelas dan terbaca'],
                        ['model' => 'signage_condition', 'label' => 'Signage / Tanda APAR', 'desc' => 'Tanda APAR terpasang dengan benar'],
                        ['model' => 'height_position', 'label' => 'Posisi Ketinggian', 'desc' => 'Jarak dari lantai 1-1.5 meter'],
                        ['model' => 'accessibility', 'label' => 'Aksesibilitas', 'desc' => 'Tidak terhalangi benda apapun (min. 1m)'],
                        ['model' => 'cleanliness', 'label' => 'Kebersihan', 'desc' => 'Alat dan sekitarnya bersih'],
                    ];
                    @endphp

                    @foreach($checks as $check)
                    <div class="flex items-center justify-between p-3 rounded-lg border border-base-300/50 bg-base-200/30">
                        <div>
                            <p class="font-medium text-sm">{{ $check['label'] }}</p>
                            <p class="text-xs text-base-content/50">{{ $check['desc'] }}</p>
                        </div>
                        <input type="checkbox" wire:model="{{ $check['model'] }}" x-model="checkItems.{{ $check['model'] }}" class="toggle toggle-primary toggle-sm" />
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Catatan --}}
        <div class="card bg-base-100 shadow-sm border border-base-300/50">
            <div class="card-body">
                <h2 class="card-title text-base font-bold mb-4">Catatan</h2>
                <label class="form-control w-full">
                    <div class="label"><span class="label-text font-medium">Catatan Inspeksi</span></div>
                    <textarea wire:model="catatan" class="textarea textarea-bordered min-h-24" placeholder="Tuliskan catatan inspeksi..."></textarea>
                </label>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('inspeksi.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary shadow-sm shadow-primary/20">
                <span wire:loading.remove wire:target="save">Simpan Inspeksi</span>
                <span wire:loading wire:target="save" class="loading loading-spinner loading-sm"></span>
            </button>
        </div>
    </form>
</div>