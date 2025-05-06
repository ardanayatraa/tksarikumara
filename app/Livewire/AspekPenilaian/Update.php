<?php

namespace App\Livewire\AspekPenilaian;

use Livewire\Component;
use App\Models\AspekPenilaian;

class Update extends Component
{
    public $open = false;
    public $id_aspek, $kode_aspek, $nama_aspek, $kategori;

    protected $listeners = ['editAspekPenilaian'];

    protected $rules = [
        'kode_aspek' => 'required|string',
        'nama_aspek' => 'required|string',
        'kategori'   => 'required|string',
    ];

    public function editAspekPenilaian($id)
    {
        $aspek = AspekPenilaian::findOrFail($id);
        $this->id_aspek   = $aspek->id_aspek;
        $this->kode_aspek = $aspek->kode_aspek;
        $this->nama_aspek = $aspek->nama_aspek;
        $this->kategori   = $aspek->kategori;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        AspekPenilaian::where('id_aspek', $this->id_aspek)->update([
            'kode_aspek' => $this->kode_aspek,
            'nama_aspek' => $this->nama_aspek,
            'kategori'   => $this->kategori,
        ]);

        $this->reset(['open', 'id_aspek', 'kode_aspek', 'nama_aspek', 'kategori']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.aspek-penilaian.update');
    }
}
