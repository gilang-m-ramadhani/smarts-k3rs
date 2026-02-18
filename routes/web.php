<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Apar\AparIndex;
use App\Livewire\Apar\AparForm;
use App\Livewire\Apar\AparShow;
use App\Livewire\Inspeksi\InspeksiIndex;
use App\Livewire\Inspeksi\InspeksiForm;
use App\Livewire\Lokasi\LokasiIndex;
use App\Livewire\Vendor\VendorIndex;
use App\Livewire\Maintenance\MaintenanceIndex;
use App\Livewire\Laporan\LaporanIndex;
use App\Livewire\User\UserIndex;
use App\Http\Controllers\AuthController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth Routes — rate-limited: 5 percobaan login per menit
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes — rate-limited: 60 request per menit per user
Route::middleware(['auth', 'throttle:web'])->group(function () {
    // Dashboard
    Route::get('/', Dashboard::class)->name('dashboard');

    // APAR
    Route::get('/apar', AparIndex::class)->name('apar.index');
    Route::get('/apar/create', AparForm::class)->name('apar.create');
    Route::get('/apar/{id}/edit', AparForm::class)->name('apar.edit');
    Route::get('/apar/{id}', AparShow::class)->name('apar.show');
    Route::get('/apar/{id}/qr-download', function ($id) {
        $qrCode = QrCode::format('png')
            ->size(300)
            ->margin(2)
            ->generate(route('apar.show', $id));
        
        return response($qrCode)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="qr-' . $id . '.png"');
    })->name('apar.qr.download');

    // Inspeksi
    Route::get('/inspeksi', InspeksiIndex::class)->name('inspeksi.index');
    Route::get('/inspeksi/create', InspeksiForm::class)->name('inspeksi.create');
    Route::get('/inspeksi/create/{apar}', InspeksiForm::class)->name('inspeksi.create.apar');
    Route::get('/inspeksi/{id}', function ($id) {
        return view('inspeksi.show', ['id' => $id]);
    })->name('inspeksi.show');

    // Lokasi
    Route::get('/lokasi', LokasiIndex::class)->name('lokasi.index');

    // Vendor
    Route::get('/vendor', VendorIndex::class)->name('vendor.index');

    // Maintenance
    Route::get('/maintenance', MaintenanceIndex::class)->name('maintenance.index');

    // Laporan
    Route::get('/laporan', LaporanIndex::class)->name('laporan.index');

    // Users (Admin only)
    Route::get('/users', UserIndex::class)->name('users.index')->middleware('can:user.view');
    
    // Profile
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile');
});
