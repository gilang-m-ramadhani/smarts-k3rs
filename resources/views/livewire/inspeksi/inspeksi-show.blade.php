<div class="container mx-auto px-4 py-6">

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Detail Inspeksi</h1>
            <p class="text-base-content/60">ID: #{{ $inspeksi->id_inspeksi }}</p>
        </div>
        <a href="{{ route('inspeksi.index') }}" class="btn btn-outline">Kembali</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1 space-y-6">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title text-sm uppercase text-base-content/60 mb-4">Informasi APAR</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <div class="text-xs text-base-content/60">APAR ID</div>
                            <div class="font-mono font-bold">{{ $inspeksi->apar->id_apar }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-base-content/60">Lokasi</div>
                            <div class="font-medium">{{ $inspeksi->apar->lokasi->nama_lokasi ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-base-content/60">Tipe</div>
                            <div class="badge badge-outline">{{ strtoupper($inspeksi->apar->tipe_apar) }}</div>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <h3 class="card-title text-sm uppercase text-base-content/60 mb-4">Hasil Inspeksi</h3>
                    <div class="space-y-3">
                        <div>
                            <div class="text-xs text-base-content/60">Tanggal Inspeksi</div>
                            <div>{{ $inspeksi->tanggal_inspeksi->format('d F Y') }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-base-content/60">Inspektor</div>
                            <div>{{ $inspeksi->user->name }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-base-content/60">Status Akhir</div>
                            <div class="badge {{ $inspeksi->overall_status_badge }}">
                                {{ ucfirst($inspeksi->overall_status) }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-base-content/60">Skor Checklist</div>
                            <div class="font-bold text-lg">{{ $inspeksi->checklist_score }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-6">Rincian Pengecekan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 border rounded-lg {{ $inspeksi->pressure_status == 'hijau' ? 'bg-success/10 border-success' : 'bg-error/10 border-error' }}">
                            <div class="flex items-center gap-3">
                                <span class="pressure-indicator pressure-{{ $inspeksi->pressure_status }}"></span>
                                <span class="font-medium">Tekanan (Pressure)</span>
                            </div>
                            <p class="text-sm mt-1 ml-6 text-base-content/70">
                                Status: {{ ucfirst($inspeksi->pressure_status) }}
                            </p>
                        </div>

                        @php
                            $checklistItems = \App\Models\Inspeksi::getChecklist();
                        @endphp

                        @foreach($checklistItems as $field => $label)
                        <div class="flex items-center justify-between p-3 border rounded-lg hover:bg-base-200 transition">
                            <span class="text-sm">{{ $label }}</span>
                            @if($inspeksi->$field)
                                <span class="badge badge-success gap-1">OK</span>
                            @else
                                <span class="badge badge-error gap-1">Masalah</span>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    @if($inspeksi->catatan)
                    <div class="mt-6">
                        <h4 class="font-bold text-sm mb-2">Catatan Tambahan:</h4>
                        <div class="p-4 bg-base-200 rounded-lg text-sm italic">
                            "{{ $inspeksi->catatan }}"
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>