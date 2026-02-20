<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Detail APAR</h1>
            <p class="text-base-content/100">{{ $apar->id_apar }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('apar.edit', $apar->id_apar) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('apar.index') }}" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-card p-6">
                <h3 class="font-semibold text-lg mb-4 flex items-center gap-2 text-base-content">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informasi APAR
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-base-content/100">ID APAR</p>
                            <p class="font-mono font-semibold text-lg text-base-content">{{ $apar->id_apar }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/100">Tipe</p>
                            <p class="badge badge-primary">{{ $apar->tipe_apar_label ?? $apar->tipe_apar }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/100">Merk</p>
                            <p class="font-medium text-base-content">{{ $apar->merk ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/100">Model</p>
                            <p class="font-medium text-base-content">{{ $apar->model ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-base-content/100">Kapasitas</p>
                            <p class="font-medium text-base-content">{{ $apar->kapasitas }} Kg</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/100">Status</p>
                            @php
                                $statusStyles = [
                                    'aktif'       => ['bg' => '#00A651', 'text' => '#ffffff', 'label' => 'Aktif'],       // Hijau
                                    'rusak'       => ['bg' => '#EF4444', 'text' => '#ffffff', 'label' => 'Rusak'],       // Merah
                                    'expired'     => ['bg' => '#F7931D', 'text' => '#ffffff', 'label' => 'Expired'],     // Oranye
                                    'maintenance' => ['bg' => '#E6F7EE', 'text' => '#004D26', 'label' => 'Maintenance'], // Mint
                                    'disposed'    => ['bg' => '#004D26', 'text' => '#ffffff', 'label' => 'Disposed'],    // Hijau Gelap
                                ];
                                $currentStyle = $statusStyles[$apar->status] ?? ['bg' => '#9CA3AF', 'text' => '#ffffff', 'label' => ucfirst($apar->status)];
                            @endphp
                            <span class="badge border-0 font-bold shadow-sm px-4 py-3" 
                                  style="background-color: {{ $currentStyle['bg'] }}; color: {{ $currentStyle['text'] }};">
                                {{ $currentStyle['label'] }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/100">Tanggal Pembelian</p>
                            <p class="font-medium text-base-content">{{ $apar->tanggal_pembelian?->format('d/m/Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/100">Tanggal Expire</p>
                            <p class="font-medium {{ $apar->is_expired ? 'text-error' : 'text-base-content' }}">
                                {{ $apar->tanggal_expire?->format('d/m/Y') ?? '-' }}
                                @if($apar->is_expired)
                                <span class="badge badge-error text-white badge-sm ml-2">Expired</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="glass-card p-6">
                    <h3 class="font-semibold text-lg mb-4 flex items-center gap-2 text-base-content">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Lokasi
                    </h3>
                    @if($apar->lokasi)
                    <div class="space-y-2">
                        <p class="font-medium text-base-content">{{ $apar->lokasi->nama_lokasi }}</p>
                        <p class="text-sm text-base-content/100">{{ $apar->lokasi->gedung ?? '' }} {{ $apar->lokasi->lantai ? '- Lantai ' . $apar->lokasi->lantai : '' }}</p>
                        <p class="text-sm text-base-content/100">{{ $apar->lokasi->ruangan ?? '' }}</p>
                    </div>
                    @else
                    <p class="text-base-content/100">Tidak ada data lokasi</p>
                    @endif
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-semibold text-lg mb-4 flex items-center gap-2 text-base-content">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Vendor
                    </h3>
                    @if($apar->vendor)
                    <div class="space-y-2">
                        <p class="font-medium text-base-content">{{ $apar->vendor->nama_vendor }}</p>
                        <p class="text-sm text-base-content/100">{{ $apar->vendor->telepon ?? '' }}</p>
                        <p class="text-sm text-base-content/100">{{ $apar->vendor->email ?? '' }}</p>
                    </div>
                    @else
                    <p class="text-base-content/100">Tidak ada data vendor</p>
                    @endif
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-4">
                    <h3 class="font-semibold text-lg flex items-center gap-2 text-base-content">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Riwayat Inspeksi
                    </h3>
                    <a href="{{ route('inspeksi.create.apar', $apar->id_apar) }}" class="btn btn-sm btn-primary">
                        + Inspeksi Baru
                    </a>
                </div>

                @if($apar->inspeksi->count() > 0)
                <div class="overflow-x-auto border border-base-200/70 rounded-lg">
                    <table class="table table-xs md:table-sm">
                        <thead class="bg-base-200/40">
                            <tr>
                                <th class="whitespace-nowrap z-10 sticky left-0 bg-base-200/40 border border-base-200/70">Tanggal & Petugas</th>
                                <th class="text-center border border-base-200/70">Status Akhir</th>
                                <th class="text-center border border-base-200/70" title="Pressure Gauge">Press.</th>
                                <th class="text-center border border-base-200/70" title="Kondisi Fisik Tabung">Fisik</th>
                                <th class="text-center border border-base-200/70" title="Segel Pengaman">Segel</th>
                                <th class="text-center border border-base-200/70" title="Kondisi Selang">Selang</th>
                                <th class="text-center border border-base-200/70" title="Kondisi Nozzle">Nozzle</th>
                                <th class="text-center border border-base-200/70" title="Handle Operasi">Handle</th>
                                <th class="text-center border border-base-200/70" title="Label Instruksi">Label</th>
                                <th class="text-center border border-base-200/70" title="Signage APAR">Sign</th>
                                <th class="text-center border border-base-200/70" title="Posisi Ketinggian">Posisi</th>
                                <th class="text-center border border-base-200/70" title="Aksesibilitas">Akses</th>
                                <th class="text-center border border-base-200/70" title="Kebersihan">Bersih</th>
                                <th class="min-w-[150px] border border-base-200/70">Catatan & Bukti</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-base-200/70">
                            @foreach($apar->inspeksi as $inspeksi)
                            <tr class="hover:bg-base-200/30 transition">
                                <td class="whitespace-nowrap sticky left-0 bg-base-100/40 backdrop-blur-md border border-white/30">
                                    <div class="font-bold text-base-content">{{ $inspeksi->tanggal_inspeksi?->format('d/m/Y') ?? '-' }}</div>
                                    <div class="text-xs text-base-content/100">{{ $inspeksi->user?->name ?? 'System' }}</div>
                                </td>

                                <td class="text-center border border-base-200/70">
                                    @php
                                        $badgeClass = match($inspeksi->overall_status) {
                                            'baik' => 'bg-primary text-white border-primary', // Hijau
                                            'kurang' => 'bg-accent text-white border-accent', // Oranye
                                            'rusak' => 'bg-error text-white border-error',    // MERAH
                                            default => 'badge-ghost'
                                        };
                                    @endphp
                                    <span class="badge badge-sm {{ $badgeClass }} font-semibold border">
                                        {{ strtoupper($inspeksi->overall_status ?? 'N/A') }}
                                    </span>
                                </td>

                                <td class="text-center border border-base-200/70">
                                    <div class="tooltip" data-tip="Pressure: {{ ucfirst($inspeksi->pressure_status) }}">
                                        <div class="w-4 h-4 rounded-full mx-auto border {{ 
                                            $inspeksi->pressure_status === 'hijau' ? 'bg-primary' : 
                                            ($inspeksi->pressure_status === 'kuning' ? 'bg-accent' : 'bg-error') 
                                        }}"></div>
                                    </div>
                                </td>

                                <td class="text-center border border-base-200/70">
                                    <div class="tooltip" data-tip="Fisik: {{ ucfirst($inspeksi->physical_condition) }}">
                                        @if($inspeksi->physical_condition === 'baik')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mx-auto" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-error mx-auto" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                                        @endif
                                    </div>
                                </td>

                                @foreach([
                                    'seal_condition', 'hose_condition', 'nozzle_condition', 
                                    'handle_condition', 'label_condition', 'signage_condition',
                                    'height_position', 'accessibility', 'cleanliness'
                                ] as $check)
                                <td class="text-center border border-base-200/70">
                                    <div class="tooltip"
                                        data-tip="{{ ucwords(str_replace('_', ' ', $check)) }}: {{ $inspeksi->$check ? 'Baik' : 'Rusak' }}">
                                        
                                        @if($inspeksi->$check)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-error mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        @endif

                                    </div>
                                </td>
                                @endforeach

                                <td class="border border-base-200/70">
                                    <div class="flex flex-col gap-1">
                                        @if($inspeksi->catatan)
                                            <span class="text-xs italic text-base-content/70">"{{ Str::limit($inspeksi->catatan, 30) }}"</span>
                                        @else
                                            <span class="text-xs text-base-content/30">-</span>
                                        @endif

                                        @if($inspeksi->photo_path)
                                            <button onclick="window.open('{{ Storage::url($inspeksi->photo_path) }}', '_blank')" class="btn btn-xs btn-outline btn-ghost gap-1 w-max">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Foto
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-8 text-base-content/50 border-2 border-dashed border-base-200/70 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p>Belum ada data inspeksi</p>
                </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="glass-card p-6 text-center">
                <h3 class="font-semibold text-lg mb-4 text-base-content">QR Code</h3>
                <div class="bg-white p-4 rounded-xl shadow-inner inline-block" id="qr-container">
                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(180)->generate(route('apar.show', $apar->id_apar)) !!}
                </div>
                <p class="text-xs text-base-content/100 mt-2">{{ $apar->id_apar }}</p>
                <div class="flex gap-2 mt-4 w-full">
                    <button onclick="printQr()" class="btn btn-primary flex-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print
                    </button>
                    <a href="{{ route('apar.qr.download', $apar->id_apar) }}" class="btn btn-secondary flex-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download
                    </a>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary to-secondary text-white shadow-lg rounded-3xl p-6">
                <h3 class="font-semibold text-lg mb-4">Aksi Cepat</h3>
                <div class="space-y-2">
                    <a href="{{ route('inspeksi.create.apar', $apar->id_apar) }}" class="btn btn-ghost bg-white/10 w-full justify-start hover:bg-white/20 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Buat Inspeksi
                    </a>
                    <a href="{{ route('maintenance.index') }}?apar={{ $apar->id_apar }}" class="btn btn-ghost bg-white/10 w-full justify-start hover:bg-white/20 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Buat Work Order
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printQr() {
            const qrContainer = document.getElementById('qr-container');
            const printWindow = window.open('', '', 'width=400,height=500');
            printWindow.document.write(`
                <html>
                <head>
                    <title>QR Code - {{ $apar->id_apar }}</title>
                    <style>
                        body { 
                            display: flex; 
                            flex-direction: column;
                            align-items: center; 
                            justify-content: center; 
                            height: 100vh; 
                            margin: 0;
                            font-family: Arial, sans-serif;
                        }
                        .qr-wrapper {
                            text-align: center;
                            padding: 20px;
                            border: 2px solid #333;
                            border-radius: 10px;
                        }
                        h2 { margin: 0 0 10px; font-size: 18px; }
                        p { margin: 10px 0 0; font-size: 14px; color: #666; }
                    </style>
                </head>
                <body>
                    <div class="qr-wrapper">
                        <h2>APAR - {{ $apar->id_apar }}</h2>
                        ${qrContainer.innerHTML}
                        <p>{{ $apar->lokasi?->nama_lokasi ?? 'SMART K3' }}</p>
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>
</div>