<?php

namespace App\Livewire\Kelas;

use App\Models\Kelas;
use Livewire\Component;

class Delete extends Component
{
    public $open = false;
    public $id_kelas;

    protected $listeners = ['delete'];

    public function delete($id)
    {
        $this->id_kelas = $id;
        $this->open = true;
    }

    public function destroy()
    {
        Kelas::where('id_kelas', $this->id_kelas)->delete();
        $this->reset(['open', 'id_kelas']);
        $this->dispatchBrowserEvent('notify', 'Data kelas berhasil dihapus');
        $this->emit('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.kelas.delete');
    }
}
