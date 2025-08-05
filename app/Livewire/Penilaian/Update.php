<?php

namespace App\Livewire\Penilaian;

use App\Models\Penilaian;
use Livewire\Component;

class Add extends Component
{
    public $open = false;
    public $id_akunsiswa, $id_guru, $tgl_penilaian;

    // Initialize with authenticated user's ID
    public function mount()
    {
        $this->id_guru = auth()->user()->guru->id_guru;
    }

    protected $rules = [
        'id_akunsiswa' => 'required',
        'id_guru' => 'required',
        'tgl_penilaian' => 'required|date',
    ];

    public function save()
    {
        $this->validate();

        Penilaian::create([
            'id_akunsiswa' => $this->id_akunsiswa,
            'id_guru' => $this->id_guru,
            'tgl_penilaian' => $this->tgl_penilaian,
        ]);

        $this->reset(['open', 'id_akunsiswa', 'id_guru', 'tgl_penilaian']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.penilaian.add');
    }
}
