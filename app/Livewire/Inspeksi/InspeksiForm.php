<?php

namespace App\Livewire\Inspeksi;

use Livewire\Component;
use App\Models\Inspeksi;
use App\Models\Apar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InspeksiForm extends Component
{
    public $aparId = '';
    public $tanggal_inspeksi;
    
    // Checklist items
    public $kondisi_tabung = true;   
    public $kondisi_selang = true;   
    public $kondisi_pin = true;      
    public $kondisi_segel = true;    
    public $kondisi_nozzle = true;   
    public $kondisi_label = true;   
    public $kondisi_mounting = true; 
    public $kondisi_pressure = 'hijau'; 
    public $aksesibilitas = true;    
    public $signage = true;
    
    public $catatan = '';
    public $rekomendasi = '';
    
    public $aparList = [];
    public $selectedApar = null;

    protected $rules = [
        'aparId' => 'required|exists:apar,id_apar',
        'tanggal_inspeksi' => 'required|date',
        'kondisi_pressure' => 'required|in:hijau,kuning,merah',
        'kondisi_tabung' => 'boolean',
        'kondisi_selang' => 'boolean',
        'kondisi_pin' => 'boolean',
        'kondisi_segel' => 'boolean',
        'kondisi_nozzle' => 'boolean',
        'kondisi_label' => 'boolean',
        'kondisi_mounting' => 'boolean',
        'aksesibilitas' => 'boolean',
        'signage' => 'boolean',
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

        $overallStatus = 'baik';
        
        if (
            $this->kondisi_pressure === 'merah' || 
            !$this->kondisi_tabung || 
            !$this->kondisi_segel || 
            !$this->kondisi_nozzle ||
            !$this->kondisi_selang
        ) {
            $overallStatus = 'rusak';
        } 
        elseif (
            $this->kondisi_pressure === 'kuning' ||
            !$this->kondisi_pin ||
            !$this->kondisi_label ||
            !$this->kondisi_mounting ||
            !$this->aksesibilitas ||
            !$this->signage
        ) {
            $overallStatus = ($overallStatus === 'rusak') ? 'rusak' : 'kurang';
        }

        DB::beginTransaction();

        try {
            Inspeksi::create([
                'id_apar' => $this->aparId,
                'id_user' => Auth::id(),
                'tanggal_inspeksi' => $this->tanggal_inspeksi,
                'next_inspection' => \Carbon\Carbon::parse($this->tanggal_inspeksi)->addMonth(),
                'pressure_status' => $this->kondisi_pressure,
                'physical_condition' => $this->kondisi_tabung ? 'baik' : 'rusak', 
                'hose_condition' => $this->kondisi_selang ? 'baik' : 'rusak',
                'seal_condition' => $this->kondisi_segel ? 'baik' : 'rusak',
                'nozzle_condition' => $this->kondisi_nozzle ? 'baik' : 'rusak',
                'handle_condition' => $this->kondisi_pin ? 'baik' : 'rusak',
                'label_condition' => $this->kondisi_label ? 'baik' : 'rusak',
                'signage_condition' => $this->signage ? 'baik' : 'rusak',
                'height_position' => $this->kondisi_mounting ? 'baik' : 'rusak', 
                'accessibility' => $this->aksesibilitas ? 'baik' : 'rusak',
                'cleanliness' => true, 
                
                'overall_status' => $overallStatus,
                'catatan' => $this->catatan . ($this->rekomendasi ? "\n\nRekomendasi: " . $this->rekomendasi : ''),
            ]);

            $apar = Apar::find($this->aparId);
            
            if ($overallStatus === 'rusak') {
                $apar->status = 'rusak';
            } elseif ($overallStatus === 'kurang') {
                $apar->status = 'aktif'; 
            } else {
                $apar->status = 'aktif';
            }
            
            if ($apar->tanggal_expire && $apar->tanggal_expire < now()) {
                $apar->status = 'expired';
            }

            $apar->save();

            DB::commit();
            session()->flash('message', 'Inspeksi berhasil disimpan dan status APAR diperbarui.');
            return redirect()->route('inspeksi.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.inspeksi.inspeksi-form')
            ->layout('layouts.app', ['title' => 'Form Inspeksi']);
    }
}