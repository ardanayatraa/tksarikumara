<?php

namespace App\Livewire\AkunSiswa;

use App\Models\AkunSiswa;
use Livewire\Component;

class Delete extends Component
{
    public $open = false;
    public $id_akunsiswa;

    protected $listeners = ['deleteSiswa'];

    public function deleteSiswa($id)
    {
        $this->id_akunsiswa = $id;
        $this->open = true;
    }

    public function destroy()
    {
        AkunSiswa::where('id_akunsiswa', $this->id_akunsiswa)->delete();
        $this->reset(['open', 'id_akunsiswa']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.akun-siswa.delete');
    }
}
