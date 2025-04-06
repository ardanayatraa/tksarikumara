<?php

namespace App\Livewire\Penilaian;

use App\Models\Penilaian;
use Livewire\Component;

class Delete extends Component
{
    public $open = false;
    public $id_penilaian;

    protected $listeners = ['delete'];

    public function delete($id)
    {
        $this->id_penilaian = $id;
        $this->open = true;
    }

    public function destroy()
    {
        Penilaian::where('id_penilaian', $this->id_penilaian)->delete();
        $this->reset(['open', 'id_penilaian']);
        $this->dispatchBrowserEvent('notify', 'Data penilaian berhasil dihapus');
        $this->emit('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.penilaian.delete');
    }
}
