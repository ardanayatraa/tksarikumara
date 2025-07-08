<?php
namespace App\Livewire\AspekPenilaian;

use App\Models\AspekPenilaian;
use Livewire\Component;

class UpdateAspek extends Component
{
    public $open = false;
    public $id_aspek, $kode_aspek, $nama_aspek, $kategori;

    protected $listeners = ['editAspek'];

    protected $rules = [
        'kode_aspek' => 'required|string|max:10',
        'nama_aspek' => 'required|string|max:100',
        'kategori' => 'required|string|max:50',
    ];

    public function editAspek($id)
    {
        $aspek = AspekPenilaian::findOrFail($id);
        $this->id_aspek = $aspek->id_aspek;
        $this->kode_aspek = $aspek->kode_aspek;
        $this->nama_aspek = $aspek->nama_aspek;
        $this->kategori = $aspek->kategori;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        AspekPenilaian::where('id_aspek', $this->id_aspek)->update([
            'kode_aspek' => $this->kode_aspek,
            'nama_aspek' => $this->nama_aspek,
            'kategori' => $this->kategori,
        ]);

        $this->reset(['open', 'id_aspek', 'kode_aspek', 'nama_aspek', 'kategori']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.aspek-penilaian.update-aspek');
    }
}
