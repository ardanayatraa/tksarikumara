<?php

namespace App\Livewire\AspekPenilaian;

use Livewire\Component;
use App\Models\IndikatorAspek;

class Delete extends Component
{
    public $open = false;
    public $id;

    protected $listeners = [
        'deleteIndikatorAspek' // dari table
    ];

    public function deleteIndikatorAspek($id)
    {
        $this->id   = $id;
        $this->open = true;
    }

    public function confirm()
    {
        IndikatorAspek::destroy($this->id);
        $this->open = false;
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.aspek-penilaian.delete');
    }
}
