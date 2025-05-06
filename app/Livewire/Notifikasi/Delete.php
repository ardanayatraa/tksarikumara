<?php

namespace App\Livewire\Notifikasi;

use App\Models\Notifikasi;
use Livewire\Component;

class Delete extends Component
{
    public $open = false;
    public $id_notifikasi;

    protected $listeners = ['delete'];

    public function delete($id)
    {
        $this->id_notifikasi = $id;
        $this->open = true;
    }

    public function destroy()
    {
        Notifikasi::where('id_notifikasi', $this->id_notifikasi)->delete();
        $this->reset(['open', 'id_notifikasi']);
        $this->dispatchBrowserEvent('notify', 'Notifikasi berhasil dihapus');
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.notifikasi.delete');
    }
}
