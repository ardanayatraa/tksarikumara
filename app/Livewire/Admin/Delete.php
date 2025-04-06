<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use Livewire\Component;

class Delete extends Component
{
    public $open = false;
    public $id_admin;

    protected $listeners = ['delete'];

    public function delete($id)
    {
        $this->id_admin = $id;
        $this->open = true;
    }

    public function destroy()
    {
        Admin::where('id_admin', $this->id_admin)->delete();
        $this->reset(['open', 'id_admin']);
        $this->dispatchBrowserEvent('notify', 'Admin berhasil dihapus');
        $this->emit('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.admin.delete');
    }
}
