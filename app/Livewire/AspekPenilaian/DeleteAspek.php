<?php

namespace App\Livewire\AspekPenilaian;

use App\Models\AspekPenilaian;
use Livewire\Component;

class DeleteAspek extends Component
{
    public $open = false;
    public $id_aspek;

    protected $listeners = ['deleteAspek'];

    public function deleteAspek($id)
    {
        $this->id_aspek = $id;
        $this->open = true;
    }

    public function destroy()
    {
        AspekPenilaian::where('id_aspek', $this->id_aspek)->delete();
        $this->reset(['open', 'id_aspek']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.aspek-penilaian.delete-aspek');
    }
}
