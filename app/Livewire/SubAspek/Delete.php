<?php

namespace App\Livewire\SubAspek;

use Livewire\Component;
use App\Models\SubAspek;
use App\Models\Indikator;

class Delete extends Component
{
    public $open = false;
    public $id;

    protected $listeners = ['deleteSubAspek'];

    public function deleteSubAspek($id)
    {
        $this->id = $id;
        $this->open = true;
    }

    public function confirm()
    {
        // Cek apakah sub aspek memiliki indikator
        $hasIndikator = Indikator::where('sub_aspek_id', $this->id)->exists();

        if ($hasIndikator) {
            session()->flash('error', 'Sub aspek tidak dapat dihapus karena masih memiliki indikator.');
            $this->open = false;
            $this->dispatch('refreshDatatable');
            return;
        }

        SubAspek::destroy($this->id);
        $this->open = false;
        $this->dispatch('refreshDatatable');

        session()->flash('message', 'Sub aspek berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.sub-aspek.delete');
    }
}
