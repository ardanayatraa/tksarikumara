<?php

namespace App\Livewire\NilaiSiswa;

use App\Models\NilaiSiswa;
use Livewire\Component;

class Delete extends Component
{
    public $open = false;
    public $id_nilai;

    protected $listeners = ['delete'];

    public function delete($id)
    {
        $this->id_nilai = $id;
        $this->open = true;
    }

    public function destroy()
    {
        NilaiSiswa::where('id_nilai', $this->id_nilai)->delete();
        $this->reset(['open', 'id_nilai']);
        $this->dispatchBrowserEvent('notify', 'Nilai siswa berhasil dihapus');
        $this->emit('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.nilai-siswa.delete');
    }
}
