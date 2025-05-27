<?php

namespace App\Livewire\Kelas;

use App\Models\Kelas;
use Livewire\Component;

class Add extends Component
{
    public $open = false;
    public $namaKelas, $tahunAjaran, $jumlahSiswa;

    protected $rules = [
        'namaKelas' => 'required|string|max:255',
        'tahunAjaran' => 'required|string|max:9', // contoh: 2024/2025
        'jumlahSiswa' => 'required|numeric|min:1',
    ];

    public function save()
    {
        $this->validate();

        Kelas::create([
            'namaKelas' => $this->namaKelas,
            'tahunAjaran' => $this->tahunAjaran,
            'jumlahSiswa' => $this->jumlahSiswa,
        ]);

        $this->reset(['open', 'namaKelas', 'tahunAjaran', 'jumlahSiswa']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.kelas.add');
    }
}
