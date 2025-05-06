<?php

namespace App\Livewire\Guru;

use App\Models\Guru;
use Livewire\Component;

class Delete extends Component
{
    public $open = false;
    public $id_guru;

    protected $listeners = ['deleteGuru'];

    public function deleteGuru($id)
    {
        $this->id_guru = $id;
        $this->open = true;
    }

    public function destroy()
    {
        Guru::where('id_guru', $this->id_guru)->delete();
        $this->reset(['open', 'id_guru']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.guru.delete');
    }
}
