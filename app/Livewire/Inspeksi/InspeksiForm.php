<?php

namespace App\Livewire\Inspeksi;

use Livewire\Component;
use App\Models\Inspeksi;
use App\Models\Apar;
use Illuminate\Support\Facades\Auth;

class InspeksiForm extends Component
{
    public $aparId = '';
    public $tanggal_inspeksi;
    
    // Checklist items — MUST match DB column names
    public $physical_condition = 'baik';
    public $pressure_status = 'hijau';
    public $seal_condition = true;
    public $hose_condition = true;
    public $nozzle_condition = true;
    public $handle_condition = true;
    public $label_condition = true;
    public $signage_condition = true;
    public $height_position = true;
    public $accessibility = true;
    public $cleanliness = true;
    
    public $catatan = '';
    
    public $aparList = [];
    public $selectedApar = null;

    protected $rules = [
        'aparId' => 'required|exists:apar,id_apar',
        'tanggal_inspeksi' => 'required|date',
        'physical_condition' => 'required|in:baik,cukup,rusak',
        'pressure_status' => 'required|in:hijau,kuning,merah',
        'seal_condition' => 'boolean',
        'hose_condition' => 'boolean',
        'nozzle_condition' => 'boolean',
        'handle_condition' => 'boolean',
        'label_condition' => 'boolean',
        'signage_condition' => 'boolean',
        'height_position' => 'boolean',
        'accessibility' => 'boolean',
        'cleanliness' => 'boolean',
    ];

    public function mount($apar = null)
    {
        $this->tanggal_inspeksi = now()->format('Y-m-d');
        $this->aparList = Apar::with('lokasi')->orderBy('id_apar')->get();
        
        if ($apar) {
            $this->aparId = $apar;
            $this->loadApar();
        }
    }

    public function updatedAparId()
    {
        $this->loadApar();
    }

    public function loadApar()
    {
        if ($this->aparId) {
            $this->selectedApar = Apar::with('lokasi', 'vendor')->find($this->aparId);
        }
    }

    public function save()
    {
        $this->validate();

        // Calculate overall status based on checklist score
        $score = 0;
        $boolChecks = [
            'seal_condition', 'hose_condition', 'nozzle_condition',
            'handle_condition', 'label_condition', 'signage_condition',
            'height_position', 'accessibility', 'cleanliness'
        ];
        foreach ($boolChecks as $check) {
            if ($this->$check) $score++;
        }
        if ($this->pressure_status === 'hijau') $score++;
        if ($this->physical_condition === 'baik') $score++;

        if ($score >= 10) {
            $overallStatus = 'baik';
        } elseif ($score >= 7) {
            $overallStatus = 'kurang';
        } else {
            $overallStatus = 'rusak';
        }

        Inspeksi::create([
            'id_apar' => $this->aparId,
            'id_user' => Auth::id(),
            'tanggal_inspeksi' => $this->tanggal_inspeksi,
            'pressure_status' => $this->pressure_status,
            'physical_condition' => $this->physical_condition,
            'seal_condition' => $this->seal_condition,
            'hose_condition' => $this->hose_condition,
            'nozzle_condition' => $this->nozzle_condition,
            'handle_condition' => $this->handle_condition,
            'label_condition' => $this->label_condition,
            'signage_condition' => $this->signage_condition,
            'height_position' => $this->height_position,
            'accessibility' => $this->accessibility,
            'cleanliness' => $this->cleanliness,
            'overall_status' => $overallStatus,
            'catatan' => $this->catatan,
        ]);

        session()->flash('message', 'Inspeksi berhasil disimpan.');
        return redirect()->route('inspeksi.index');
    }

    public function render()
    {
        return view('livewire.inspeksi.inspeksi-form')
            ->layout('layouts.app', ['title' => 'Form Inspeksi']);
    }
}
