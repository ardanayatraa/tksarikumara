<?php

namespace App\Livewire\KepalaSekolah;

use App\Models\KepalaSekolah;
use Livewire\Component;

class Add extends Component
{
    public $open = false;
    public $namaKepalaSekolah, $nip, $email, $notlp, $username, $password;

    protected $rules = [
        'namaKepalaSekolah' => 'required|string|max:255',
        'nip' => 'required|string|max:50',
        'email' => 'required|email',
        'notlp' => 'required|string|max:20',
        'username' => 'required|string|max:50',
        'password' => 'required|string|min:6',
    ];

    public function save()
    {
        $this->validate();

        KepalaSekolah::create([
            'namaKepalaSekolah' => $this->namaKepalaSekolah,
            'nip' => $this->nip,
            'email' => $this->email,
            'notlp' => $this->notlp,
            'username' => $this->username,
            'password' => bcrypt($this->password),
        ]);

        $this->reset([
            'open', 'namaKepalaSekolah', 'nip', 'email', 'notlp', 'username', 'password'
        ]);

        $this->dispatchBrowserEvent('notify', 'Kepala Sekolah berhasil ditambahkan');
        $this->emit('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.kepala-sekolah.add');
    }
}
