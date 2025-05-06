<?php

namespace App\Livewire\Semester;

use Livewire\Component;
use App\Models\Semester;

class Delete extends Component
{
    public $open = false;
    public $id_semester;

    protected $listeners = ['deleteSemester'];

    public function deleteSemester($id)
    {
        $this->id_semester = $id;
        $this->open = true;
    }

    public function destroy()
    {
        Semester::where('id_semester', $this->id_semester)->delete();
        $this->reset(['open', 'id_semester']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.semester.delete');
    }
}
