<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Maintenance;
use App\Models\Apar;
use App\Models\User;

class MaintenanceIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterType = '';

    // Modal state
    public $showModal = false;
    public $editId = null;

    // Form fields
    public $id_apar = '';
    public $maintenance_type = 'ringan';
    public $description = '';
    public $scheduled_date = '';
    public $assigned_to = '';
    public $priority = 'normal';

    protected $rules = [
        'id_apar' => 'required|exists:apar,id_apar',
        'maintenance_type' => 'required|in:ringan,sedang,berat',
        'description' => 'required|min:10',
        'scheduled_date' => 'required|date|after_or_equal:today',
        'priority' => 'required|in:low,normal,high,urgent',
    ];

    public function openModal()
    {
        $this->reset(['editId', 'id_apar', 'maintenance_type', 'description', 'scheduled_date', 'assigned_to', 'priority']);
        $this->scheduled_date = now()->format('Y-m-d');
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $woNumber = 'WO-' . date('Ymd') . '-' . str_pad(Maintenance::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

        Maintenance::create([
            'wo_number' => $woNumber,
            'id_apar' => $this->id_apar,
            'maintenance_type' => $this->maintenance_type,
            'work_description' => $this->description,
            'scheduled_date' => $this->scheduled_date,
            'assigned_to' => $this->assigned_to ?: null,
            'priority' => $this->priority,
            'status' => 'pending',
            'created_by' => auth()->id(),
        ]);

        session()->flash('message', 'Work Order berhasil dibuat.');
        $this->dispatch('notify', type: 'success', title: 'Berhasil', message: 'Work Order berhasil dibuat.');
        $this->closeModal();
    }

    public function render()
    {
        $query = Maintenance::with(['apar.lokasi', 'teknisi'])
            ->orderBy('scheduled_date', 'desc');

        if ($this->search) {
            $query->where('wo_number', 'like', "%{$this->search}%")
                ->orWhereHas('apar', fn($q) => $q->where('id_apar', 'like', "%{$this->search}%"));
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterType) {
            $query->where('maintenance_type', $this->filterType);
        }

        $maintenanceList = $query->paginate(10);

        $stats = [
            'pending' => Maintenance::where('status', 'pending')->count(),
            'in_progress' => Maintenance::where('status', 'in_progress')->count(),
            'completed' => Maintenance::where('status', 'completed')->count(),
        ];

        return view('livewire.maintenance.maintenance-index', [
            'maintenanceList' => $maintenanceList,
            'stats' => $stats,
            'aparList' => Apar::orderBy('id_apar')->get(),
            'teknisiList' => User::role('teknisi')->get(),
        ])->layout('layouts.app', ['title' => 'Maintenance']);
    }
}
