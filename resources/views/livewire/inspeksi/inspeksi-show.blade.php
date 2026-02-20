<div class="container mx-auto px-4 py-6">

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Detail Inspeksi</h1>
            <p class="text-base-content/100">ID: #{{ $inspeksi->id_inspeksi }}</p>
        </div>
        <a href="{{ route('inspeksi.index') }}" class="btn btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1 space-y-6">
            <div class="glass-card p-6">
                <h3 class="card-title text-sm uppercase text-base-content/100 mb-4">Informasi APAR</h3>
                
                <div class="space-y-3">
                    <div>
                        <div class="text-xs text-base-content/100">APAR ID</div>
                        <div class="font-mono font-bold text-primary">{{ $inspeksi->apar->id_apar }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-base-content/100">Lokasi</div>
                        <div class="font-medium text-base-content">{{ $inspeksi->apar->lokasi->nama_lokasi ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-base-content/100">Tipe</div>
                        <div class="badge badge-primary badge-outline">{{ strtoupper($inspeksi->apar->tipe_apar) }}</div>
                    </div>
                </div>

                <div class="divider"></div>

                <h3 class="card-title text-sm uppercase text-base-content/100 mb-4">Hasil Inspeksi</h3>
                <div class="space-y-3">
                    <div>
                        <div class="text-xs text-base-content/100">Tanggal Inspeksi</div>
                        <div class="text-base-content">{{ $inspeksi->tanggal_inspeksi->format('d F Y') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-base-content/100">Inspektor</div>
                        <div class="text-base-content">{{ $inspeksi->user->name }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-base-content/100">Status Akhir</div>
                        {{-- Logika agar 'rusak' dipaksa menjadi merah (error) --}}
                        @php
                            $statusBadge = match($inspeksi->overall_status) {
                                'baik' => 'badge-primary text-white border-primary',
                                'kurang' => 'badge-accent text-white border-accent',
                                'rusak' => 'badge-error text-white border-error',
                                default => 'badge-ghost'
                            };
                        @endphp
                        <div class="badge {{ $statusBadge }}">
                            {{ ucfirst($inspeksi->overall_status) }}
                        </div>
                    </div>
                    <div>
                        <div class="text-xs text-base-content/100">Skor Checklist</div>
                        <div class="font-bold text-lg text-base-content">{{ $inspeksi->checklist_score }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="glass-card p-6">
                <h3 class="card-title mb-6 text-base-content">Rincian Pengecekan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Logic Background box pressure --}}
                    @php
                        $pressureBg = match($inspeksi->pressure_status) {
                            'hijau' => 'bg-primary/10 border-primary/30',
                            'kuning' => 'bg-accent/10 border-accent/30',
                            'merah' => 'bg-error/10 border-error/30',
                            default => 'bg-base-200 border-white/30'
                        };
                    @endphp
                    <div class="p-4 border rounded-lg {{ $pressureBg }} backdrop-blur-sm">
                        <div class="flex items-center gap-3">
                            <span class="pressure-indicator pressure-{{ $inspeksi->pressure_status }}"></span>
                            <span class="font-medium text-base-content">Tekanan (Pressure)</span>
                        </div>
                        <p class="text-sm mt-1 ml-6 text-base-content/70">
                            Status: {{ ucfirst($inspeksi->pressure_status) }}
                        </p>
                    </div>

                    @php
                        $checklistItems = \App\Models\Inspeksi::getChecklist();
                    @endphp

                    @foreach($checklistItems as $field => $label)
                    <div class="flex items-center justify-between p-3 border border-white/30 rounded-lg hover:bg-base-200/30 transition backdrop-blur-sm">
                        <span class="text-sm text-base-content">{{ $label }}</span>
                        @if($inspeksi->$field)
                            <span class="badge badge-primary text-white gap-1">OK</span>
                        @else
                            <span class="badge badge-error text-white gap-1">Masalah</span>
                        @endif
                    </div>
                    @endforeach
                </div>

                @if($inspeksi->catatan)
                <div class="mt-6">
                    <h4 class="font-bold text-sm mb-2 text-base-content">Catatan Tambahan:</h4>
                    <div class="p-4 bg-white/30 backdrop-blur-sm border border-white/30 rounded-lg text-sm italic text-base-content">
                        "{{ $inspeksi->catatan }}"
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>