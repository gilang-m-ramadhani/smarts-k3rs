<div>
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

                {{-- Info APAR terpilih --}}
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

        {{-- Kondisi Fisik --}}
        <div class="card bg-base-100 shadow-sm border border-base-300/50">
            <div class="card-body">
                <h2 class="card-title text-base font-bold mb-4">Kondisi Fisik Tabung</h2>
                <div class="flex flex-wrap gap-3">
                    @foreach(['baik' => ['Baik', 'badge-success'], 'cukup' => ['Cukup', 'badge-warning'], 'rusak' => ['Rusak', 'badge-error']] as $val => [$lbl, $cls])
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="physical_condition" value="{{ $val }}" class="hidden peer" />
                        <span class="badge badge-lg badge-outline peer-checked:{{ $cls }} peer-checked:font-bold transition-all px-4 py-3">
                            {{ $lbl }}
                        </span>
                    </label>
                    @endforeach
                </div>
                @error('physical_condition') <div class="mt-2"><span class="text-error text-xs">{{ $message }}</span></div> @enderror
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
                        <input type="checkbox" wire:model="{{ $check['model'] }}" class="toggle toggle-primary toggle-sm" />
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Pressure Gauge --}}
        <div class="card bg-base-100 shadow-sm border border-base-300/50">
            <div class="card-body">
                <h2 class="card-title text-base font-bold mb-4">Tekanan / Pressure Gauge</h2>
                <div class="flex flex-wrap gap-3">
                    @foreach(['hijau' => ['Hijau (Normal)', 'badge-success'], 'kuning' => ['Kuning (Warning)', 'badge-warning'], 'merah' => ['Merah (Bahaya)', 'badge-error']] as $val => [$lbl, $cls])
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="pressure_status" value="{{ $val }}" class="hidden peer" />
                        <span class="badge badge-lg badge-outline peer-checked:{{ $cls }} peer-checked:font-bold transition-all px-4 py-3">
                            {{ $lbl }}
                        </span>
                    </label>
                    @endforeach
                </div>
                @error('pressure_status') <div class="mt-2"><span class="text-error text-xs">{{ $message }}</span></div> @enderror
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
                <span wire:loading.remove wire:target="save">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Inspeksi
                </span>
                <span wire:loading wire:target="save" class="loading loading-spinner loading-sm"></span>
            </button>
        </div>
    </form>
</div>