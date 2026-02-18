<?php

namespace App\Livewire\Lokasi;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Lokasi;

class LokasiIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $lokasiId = null;

    // Form
    public $nama_lokasi = '';
    public $gedung = '';
    public $lantai = '';
    public $ruangan = '';
    public $koordinat = '';
    public $kategori_risiko = 'sedang';
    public $deskripsi = '';

    protected $rules = [
        'nama_lokasi' => 'required|string|max:100',
        'gedung' => 'required|string|max:100',
        'lantai' => 'required|string|max:20',
        'ruangan' => 'required|string|max:100',
        'koordinat' => 'nullable|string|max:50',
        'kategori_risiko' => 'required|in:rendah,sedang,tinggi',
        'deskripsi' => 'nullable|string',
    ];

    public function openModal($id = null)
    {
        $this->resetForm();
        if ($id) {
            $this->editMode = true;
            $this->lokasiId = $id;
            $lokasi = Lokasi::findOrFail($id);
            $this->nama_lokasi = $lokasi->nama_lokasi;
            $this->gedung = $lokasi->gedung;
            $this->lantai = $lokasi->lantai;
            $this->ruangan = $lokasi->ruangan;
            $this->koordinat = $lokasi->koordinat;
            $this->kategori_risiko = $lokasi->kategori_risiko;
            $this->deskripsi = $lokasi->deskripsi;
        }
        $this->showModal = true;
    }

    public function openCreateModal()
    {
        $this->openModal();
    }

    public function openEditModal($id)
    {
        $this->openModal($id);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editMode = false;
        $this->lokasiId = null;
        $this->nama_lokasi = '';
        $this->gedung = '';
        $this->lantai = '';
        $this->ruangan = '';
        $this->koordinat = '';
        $this->kategori_risiko = 'sedang';
        $this->deskripsi = '';
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama_lokasi' => $this->nama_lokasi,
            'gedung' => $this->gedung,
            'lantai' => $this->lantai,
            'ruangan' => $this->ruangan,
            'koordinat' => $this->koordinat,
            'kategori_risiko' => $this->kategori_risiko,
            'deskripsi' => $this->deskripsi,
        ];

        if ($this->editMode) {
            Lokasi::findOrFail($this->lokasiId)->update($data);
            session()->flash('message', 'Lokasi berhasil diperbarui.');
        } else {
            Lokasi::create($data);
            session()->flash('message', 'Lokasi berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function delete($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        if ($lokasi->apar()->count() > 0) {
            session()->flash('error', 'Lokasi tidak dapat dihapus karena masih memiliki APAR.');
            return;
        }
        $lokasi->delete();
        session()->flash('message', 'Lokasi berhasil dihapus.');
    }

    public function render()
    {
        $lokasiList = Lokasi::withCount('apar')
            ->when($this->search, function ($q) {
                $q->where('nama_lokasi', 'like', "%{$this->search}%")
                  ->orWhere('gedung', 'like', "%{$this->search}%");
            })
            ->orderBy('gedung')
            ->orderBy('lantai')
            ->paginate(10);

        return view('livewire.lokasi.lokasi-index', [
            'lokasiList' => $lokasiList,
        ])->layout('layouts.app', ['title' => 'Lokasi']);
    }
}
