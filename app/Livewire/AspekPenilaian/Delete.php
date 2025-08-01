<?php

namespace App\Livewire\AspekPenilaian;

use Livewire\Component;
use App\Models\Indikator;

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
        Indikator::destroy($this->id);
        $this->open = false;
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.aspek-penilaian.delete');
    }
}
