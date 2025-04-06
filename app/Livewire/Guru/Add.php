<?php

namespace App\Livewire\Guru;

use App\Models\Guru;
use Livewire\Component;

class Add extends Component
{
    public $open = false;
    public $namaGuru, $nip, $username, $password, $email, $jenis_kelamin, $notlp;

    protected $rules = [
        'namaGuru' => 'required|string|max:255',
        'nip' => 'required|string|max:50',
        'username' => 'required|string|max:50',
        'password' => 'required|string|min:6',
        'email' => 'required|email',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'notlp' => 'required|string|max:20',
    ];

    public function save()
    {
        $this->validate();

        Guru::create([
            'namaGuru' => $this->namaGuru,
            'nip' => $this->nip,
            'username' => $this->username,
            'password' => bcrypt($this->password),
            'email' => $this->email,
            'jenis_kelamin' => $this->jenis_kelamin,
            'notlp' => $this->notlp,
        ]);

        $this->reset(['open', 'namaGuru', 'nip', 'username', 'password', 'email', 'jenis_kelamin', 'notlp']);
        $this->dispatchBrowserEvent('notify', 'Guru berhasil ditambahkan');
        $this->emit('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.guru.add');
    }
}
