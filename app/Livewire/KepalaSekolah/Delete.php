<?php

namespace App\Livewire\KepalaSekolah;

use App\Models\KepalaSekolah;
use Livewire\Component;

class Delete extends Component
{
    public $open = false;
    public $id_kepalasekolah;

    protected $listeners = ['deleteKepsek'];

    public function deleteKepsek($id)
    {
        $this->id_kepalasekolah = $id;
        $this->open = true;
    }

    public function destroy()
    {
        KepalaSekolah::where('id_kepalasekolah', $this->id_kepalasekolah)->delete();
        $this->reset(['open', 'id_kepalasekolah']);

        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.kepala-sekolah.delete');
    }
}
