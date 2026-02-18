<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Apar;
use App\Models\Inspeksi;
use App\Models\Maintenance;
use Illuminate\Support\Facades\Cache;

class Dashboard extends Component
{
    public $totalApar;
    public $aparAktif;
    public $aparRusak;
    public $aparExpired;
    public $aparMaintenance;
    public $inspeksiBulanIni;
    public $maintenancePending;
    public $complianceRate;
    public $recentInspeksi;
    public $upcomingMaintenance;
    public $aparByStatus;
    public $aparByTipe;
    public $expiringApar;

    public function mount()
    {
        $this->loadStatistics();
        $this->loadRecentData();
        $this->loadChartData();
    }

    public function loadStatistics()
    {
        // Cache statistik selama 2 menit — satu query aggregat alih-alih 5 query terpisah
        $stats = Cache::remember('dashboard:stats', 120, function () {
            $statusCounts = Apar::selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'aktif' THEN 1 ELSE 0 END) as aktif,
                SUM(CASE WHEN status = 'rusak' THEN 1 ELSE 0 END) as rusak,
                SUM(CASE WHEN status = 'expired' THEN 1 ELSE 0 END) as expired,
                SUM(CASE WHEN status = 'maintenance' THEN 1 ELSE 0 END) as maintenance
            ")->first();

            $inspeksiBulanIni = Inspeksi::whereMonth('tanggal_inspeksi', now()->month)
                ->whereYear('tanggal_inspeksi', now()->year)
                ->count();

            $maintenancePending = Maintenance::whereIn('status', ['pending', 'in_progress'])->count();

            return [
                'total' => (int) $statusCounts->total,
                'aktif' => (int) $statusCounts->aktif,
                'rusak' => (int) $statusCounts->rusak,
                'expired' => (int) $statusCounts->expired,
                'maintenance' => (int) $statusCounts->maintenance,
                'inspeksi_bulan_ini' => $inspeksiBulanIni,
                'maintenance_pending' => $maintenancePending,
            ];
        });

        $this->totalApar = $stats['total'];
        $this->aparAktif = $stats['aktif'];
        $this->aparRusak = $stats['rusak'];
        $this->aparExpired = $stats['expired'];
        $this->aparMaintenance = $stats['maintenance'];
        $this->inspeksiBulanIni = $stats['inspeksi_bulan_ini'];
        $this->maintenancePending = $stats['maintenance_pending'];

        $this->complianceRate = $this->totalApar > 0 
            ? round(($this->inspeksiBulanIni / $this->totalApar) * 100, 1) 
            : 0;
    }

    public function loadRecentData()
    {
        // Cache recent data selama 1 menit
        $recent = Cache::remember('dashboard:recent', 60, function () {
            return [
                'inspeksi' => Inspeksi::with(['apar:id_apar,id_lokasi,tipe_apar', 'apar.lokasi:id_lokasi,nama_lokasi', 'user:id,name'])
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get(),
                'maintenance' => Maintenance::with(['apar:id_apar,id_lokasi,tipe_apar', 'apar.lokasi:id_lokasi,nama_lokasi', 'teknisi:id,name'])
                    ->whereIn('status', ['pending', 'in_progress'])
                    ->orderBy('scheduled_date', 'asc')
                    ->take(5)
                    ->get(),
                'expiring' => Apar::with('lokasi:id_lokasi,nama_lokasi')
                    ->where('status', 'aktif')
                    ->whereBetween('tanggal_expire', [now(), now()->addDays(30)])
                    ->orderBy('tanggal_expire', 'asc')
                    ->take(5)
                    ->get(),
            ];
        });

        $this->recentInspeksi = $recent['inspeksi'];
        $this->upcomingMaintenance = $recent['maintenance'];
        $this->expiringApar = $recent['expiring'];
    }

    public function loadChartData()
    {
        $this->aparByStatus = [
            ['status' => 'Aktif', 'count' => $this->aparAktif, 'color' => '#86EFAC'],
            ['status' => 'Rusak', 'count' => $this->aparRusak, 'color' => '#FDA4AF'],
            ['status' => 'Expired', 'count' => $this->aparExpired, 'color' => '#FDE68A'],
            ['status' => 'Maintenance', 'count' => $this->aparMaintenance, 'color' => '#7DD3FC'],
        ];

        $this->aparByTipe = Cache::remember('dashboard:tipe', 120, function () {
            return Apar::selectRaw('tipe_apar, COUNT(*) as count')
                ->groupBy('tipe_apar')
                ->get()
                ->map(fn ($item) => [
                    'tipe' => strtoupper($item->tipe_apar),
                    'count' => $item->count,
                ])
                ->toArray();
        });
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
