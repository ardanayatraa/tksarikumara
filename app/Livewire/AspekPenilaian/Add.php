<?php

namespace App\Livewire\AspekPenilaian;

use Livewire\Component;
use App\Models\AspekPenilaian;

class Add extends Component
{
    public $open = false;
    public $kode_aspek, $nama_aspek, $kategori;

    protected $rules = [
        'kode_aspek'  => 'required|string',
        'nama_aspek'  => 'required|string',
        'kategori'    => 'required|string',
    ];

    public function save()
    {
        $this->validate();

        AspekPenilaian::create([
            'kode_aspek' => $this->kode_aspek,
            'nama_aspek' => $this->nama_aspek,
            'kategori'   => $this->kategori,
        ]);

        $this->reset(['open', 'kode_aspek', 'nama_aspek', 'kategori']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.aspek-penilaian.add');
    }
}
