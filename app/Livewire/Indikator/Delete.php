<?php

// File: app/Livewire/Indikator/Delete.php
namespace App\Livewire\Indikator;

use Livewire\Component;
use App\Models\Indikator;
use App\Models\NilaiSiswa;

class Delete extends Component
{
    public $open = false;
    public $id;
    public $indikatorData = null;

    protected $listeners = ['deleteIndikator'];

    public function deleteIndikator($id)
    {
        $this->id = $id;
        $this->indikatorData = Indikator::with(['aspekPenilaian', 'subAspek'])->find($id);
        $this->open = true;
    }

    public function confirm()
    {
        if (!$this->indikatorData) {
            session()->flash('error', 'Indikator tidak ditemukan.');
            $this->open = false;
            return;
        }

        // Cek apakah indikator sudah digunakan dalam penilaian
        $isUsed = NilaiSiswa::where('indikator_id', $this->id)->exists();

        if ($isUsed) {
            session()->flash('error', 'Indikator tidak dapat dihapus karena sudah digunakan dalam penilaian siswa.');
            $this->open = false;
            $this->dispatch('refreshDatatable');
            return;
        }

        try {
            Indikator::destroy($this->id);
            session()->flash('message', 'Indikator berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus indikator: ' . $e->getMessage());
        }

        $this->reset(['open', 'id', 'indikatorData']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.indikator.delete');
    }
}
