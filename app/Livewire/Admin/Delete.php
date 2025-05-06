<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use Livewire\Component;

class Delete extends Component
{
    public $open = false;
    public $id_admin;

    protected $listeners = ['deleteAdmin'];

    public function deleteAdmin($id)
    {
        $this->id_admin = $id;
        $this->open = true;
    }

    public function destroy()
    {
        Admin::where('id_admin', $this->id_admin)->delete();
        $this->reset(['open', 'id_admin']);

        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.admin.delete');
    }
}
