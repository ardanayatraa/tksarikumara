<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use Livewire\Component;

class Update extends Component
{
    public $open = false;
    public $id_admin, $username, $email, $notlp;

    protected $listeners = ['editAdmin'];

    protected $rules = [
        'username' => 'required',
        'email' => 'required|email',
        'notlp' => 'required',
    ];

    public function editAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $this->id_admin = $admin->id_admin;
        $this->username = $admin->username;
        $this->email = $admin->email;
        $this->notlp = $admin->notlp;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        Admin::where('id_admin', $this->id_admin)->update([
            'username' => $this->username,
            'email' => $this->email,
            'notlp' => $this->notlp,
        ]);

        $this->reset(['open', 'id_admin', 'username', 'email', 'notlp']);

        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.admin.update');
    }
}
