<?php

namespace App\Livewire\Semester;

use Livewire\Component;
use App\Models\Semester;

class Add extends Component
{
    public $open = false;
    public $nama_semester, $tahun_awal, $tahun_akhir;

    protected $rules = [
        'nama_semester' => 'required|string',
        'tahun_awal'    => 'required|integer',
        'tahun_akhir'   => 'required|integer|gte:tahun_awal',
    ];

    public function save()
    {
        $this->validate();

        Semester::create([
            'nama_semester' => $this->nama_semester,
            'tahun_awal'    => $this->tahun_awal,
            'tahun_akhir'   => $this->tahun_akhir,
        ]);

        // reset form & close modal
        $this->reset(['open', 'nama_semester', 'tahun_awal', 'tahun_akhir']);

        // trigger refresh di tabel/listing
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.semester.add');
    }
}
