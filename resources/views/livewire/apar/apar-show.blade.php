<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Detail APAR</h1>
            <p class="text-base-content/50 text-sm font-mono">{{ $apar->id_apar }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('apar.edit', $apar->id_apar) }}" class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <a href="{{ route('apar.index') }}" class="btn btn-ghost btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Info --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="card bg-base-100 shadow-sm border border-base-300/50">
                <div class="card-body">
                    <h2 class="card-title text-base font-bold mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Informasi APAR
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-xs text-base-content/50 uppercase tracking-wider">Kode APAR</p>
                            <p class="font-mono font-semibold">{{ $apar->id_apar }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/50 uppercase tracking-wider">Tipe</p>
                            <p class="font-semibold">{{ strtoupper($apar->tipe_apar) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/50 uppercase tracking-wider">Merk</p>
                            <p class="font-semibold">{{ $apar->merk }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/50 uppercase tracking-wider">Kapasitas</p>
                            <p class="font-semibold">{{ $apar->kapasitas }} Kg</p>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/50 uppercase tracking-wider">Status</p>
                            <span class="badge badge-sm mt-1
                                {{ $apar->status === 'aktif' ? 'badge-success' : '' }}
                                {{ $apar->status === 'rusak' ? 'badge-error' : '' }}
                                {{ $apar->status === 'expired' ? 'badge-warning' : '' }}
                                {{ $apar->status === 'maintenance' ? 'badge-info' : '' }}
                            ">{{ ucfirst($apar->status) }}</span>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/50 uppercase tracking-wider">Expired</p>
                            <p class="font-semibold">{{ $apar->tanggal_expire?->format('d/m/Y') ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm border border-base-300/50">
                <div class="card-body">
                    <h2 class="card-title text-base font-bold mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        Lokasi & Vendor
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-base-content/50 uppercase tracking-wider">Lokasi</p>
                            <p class="font-semibold">{{ $apar->lokasi->nama_lokasi ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/50 uppercase tracking-wider">Gedung</p>
                            <p class="font-semibold">{{ $apar->lokasi->gedung ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/50 uppercase tracking-wider">Vendor</p>
                            <p class="font-semibold">{{ $apar->vendor->nama_vendor ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/50 uppercase tracking-wider">Tanggal Produksi</p>
                            <p class="font-semibold">{{ $apar->tanggal_produksi?->format('d/m/Y') ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            {{-- QR Code --}}
            <div class="card bg-base-100 shadow-sm border border-base-300/50">
                <div class="card-body items-center text-center">
                    <h2 class="card-title text-base font-bold mb-2">QR Code</h2>
                    <div class="bg-white p-4 rounded-xl" id="qr-container">
                        {!! QrCode::size(160)->generate(route('apar.show', $apar->id_apar)) !!}
                    </div>
                    <button onclick="printQR()" class="btn btn-outline btn-sm mt-3 w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Print QR Code
                    </button>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="card bg-base-100 shadow-sm border border-base-300/50">
                <div class="card-body">
                    <h2 class="card-title text-base font-bold mb-2">Aksi Cepat</h2>
                    <div class="space-y-2">
                        <a href="{{ route('inspeksi.create') }}?apar={{ $apar->id_apar }}" class="btn btn-outline btn-sm w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            Buat Inspeksi
                        </a>
                        <a href="{{ route('apar.edit', $apar->id_apar) }}" class="btn btn-outline btn-sm w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit APAR
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function printQR() {
    const qr = document.getElementById('qr-container').innerHTML;
    const w = window.open('', '_blank');
    w.document.write('<html><body style="display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0;flex-direction:column"><h2>{{ $apar->id_apar }}</h2>' + qr + '</body></html>');
    w.document.close();
    w.print();
}
</script>
@endpush
