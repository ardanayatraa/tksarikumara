<?php

namespace App\Livewire\Guru;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Guru;

class Add extends Component
{
    use WithFileUploads;

    public $open = false;
    public $namaGuru;
    public $nip;
    public $username;
    public $password;
    public $email;
    public $jenis_kelamin;
    public $notlp;
    public $foto; // untuk menyimpan upload

    protected $rules = [
        'namaGuru'      => 'required|string|max:255',
        'nip'           => 'required|string|max:50',
        'username'      => 'required|string|max:50',
        'password'      => 'required|string|min:6',
        'email'         => 'required|email',
        'jenis_kelamin' => 'required|in:L,P',
        'notlp'         => 'required|string|max:20',
        'foto'          => 'nullable|image|max:1024', // max 1MB
    ];

    public function save()
    {
        $this->validate();

        // jika ada foto, simpan dulu ke disk 'public'
        $path = null;
        if ($this->foto) {
            $path = $this->foto->store('guru', 'public');
        }

        Guru::create([
            'namaGuru'      => $this->namaGuru,
            'nip'           => $this->nip,
            'username'      => $this->username,
            'password'      => bcrypt($this->password),
            'email'         => $this->email,
            'jenis_kelamin' => $this->jenis_kelamin,
            'notlp'         => $this->notlp,
            'foto'          => $path,
        ]);

        $this->reset([
            'open', 'namaGuru', 'nip', 'username', 'password',
            'email', 'jenis_kelamin', 'notlp', 'foto'
        ]);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.guru.add');
    }
}
