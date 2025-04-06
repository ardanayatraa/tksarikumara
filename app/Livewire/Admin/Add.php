<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use Livewire\Component;

class Add extends Component
{
    public $open = false;
    public $username, $password, $email, $notlp;

    protected $rules = [
        'username' => 'required',
        'password' => 'required',
        'email' => 'required|email',
        'notlp' => 'required',
    ];

    public function save()
    {
        $this->validate();

        Admin::create([
            'username' => $this->username,
            'password' => bcrypt($this->password),
            'email' => $this->email,
            'notlp' => $this->notlp,
        ]);

        $this->reset(['open', 'username', 'password', 'email', 'notlp']);
        $this->dispatchBrowserEvent('notify', 'Admin berhasil ditambahkan');
        $this->emit('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.admin.add');
    }
}
