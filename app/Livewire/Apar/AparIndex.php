<?php

namespace App\Livewire\Apar;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Apar;
use App\Models\Lokasi;

class AparIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterTipe = '';
    public $filterLokasi = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $showDeleteModal = false;
    public $deleteId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterTipe' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterTipe()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->deleteId) {
            $apar = Apar::find($this->deleteId);
            if ($apar) {
                $apar->delete();
                session()->flash('message', 'APAR berhasil dihapus.');
            }
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $query = Apar::with(['lokasi', 'vendor', 'latestInspeksi']);

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('id_apar', 'like', "%{$this->search}%")
                  ->orWhere('merk', 'like', "%{$this->search}%")
                  ->orWhere('no_seri', 'like', "%{$this->search}%")
                  ->orWhereHas('lokasi', function ($lq) {
                      $lq->where('nama_lokasi', 'like', "%{$this->search}%")
                         ->orWhere('gedung', 'like', "%{$this->search}%");
                  });
            });
        }

        // Filters
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterTipe) {
            $query->where('tipe_apar', $this->filterTipe);
        }

        if ($this->filterLokasi) {
            $query->where('id_lokasi', $this->filterLokasi);
        }

        // Sort
        $query->orderBy($this->sortField, $this->sortDirection);

        $aparList = $query->paginate(10);
        $lokasiList = Lokasi::orderBy('nama_lokasi')->get();

        return view('livewire.apar.apar-index', [
            'aparList' => $aparList,
            'lokasiList' => $lokasiList,
            'totalApar' => Apar::count(),
            'aparAktif' => Apar::where('status', 'aktif')->count(),
            'aparRusak' => Apar::where('status', 'rusak')->count(),
            'aparExpired' => Apar::where('tanggal_expire', '<', now())->count(),
        ])->layout('layouts.app', ['title' => 'Data APAR']);
    }
}
