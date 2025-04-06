<?php

namespace App\Livewire\NilaiSiswa;

use App\Models\NilaiSiswa;
use App\Models\Penilaian;
use Livewire\Component;

class Add extends Component
{
    public $open = false;
    public $id_penilaian, $aspek_penilaian, $kategori, $skor;
    public $penilaians = [];

    protected $rules = [
        'id_penilaian' => 'required|exists:penilaian,id_penilaian',
        'aspek_penilaian' => 'required|string|max:255',
        'kategori' => 'required|string|max:100',
        'skor' => 'required|numeric|min:0|max:100',
    ];

    public function mount()
    {
        $this->penilaians = Penilaian::all();
    }

    public function save()
    {
        $this->validate();

        NilaiSiswa::create([
            'id_penilaian' => $this->id_penilaian,
            'aspek_penilaian' => $this->aspek_penilaian,
            'kategori' => $this->kategori,
            'skor' => $this->skor,
        ]);

        $this->reset([
            'open', 'id_penilaian', 'aspek_penilaian', 'kategori', 'skor'
        ]);

        $this->dispatchBrowserEvent('notify', 'Nilai siswa berhasil ditambahkan');
        $this->emit('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.nilai-siswa.add');
    }
}
