<?php

namespace App\Livewire\AspekPenilaian;

use Livewire\Component;
use App\Models\AspekPenilaian;

class Delete extends Component
{
    public $open = false;
    public $id_aspek;

    protected $listeners = ['deleteAspekPenilaian'];

    public function deleteAspekPenilaian($id)
    {
        $this->id_aspek = $id;
        $this->open     = true;
    }

    public function destroy()
    {
        AspekPenilaian::where('id_aspek', $this->id_aspek)->delete();
        $this->reset(['open', 'id_aspek']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.aspek-penilaian.delete');
    }
}
