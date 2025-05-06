<?php

namespace App\Livewire\Guru;

use App\Models\Guru;
use Livewire\Component;

class Update extends Component
{
    public $open = false;
    public $id_guru, $namaGuru, $nip, $username, $password, $email, $jenis_kelamin, $notlp;

    protected $listeners = ['editGuru'];

    protected $rules = [
        'namaGuru' => 'required',
        'nip' => 'required',
        'username' => 'required',
        'email' => 'required|email',
        'jenis_kelamin' => 'required',
        'notlp' => 'required',
    ];

    public function editGuru($id)
    {

        $guru = Guru::findOrFail($id);
        $this->id_guru = $guru->id_guru;
        $this->namaGuru = $guru->namaGuru;
        $this->nip = $guru->nip;
        $this->username = $guru->username;
        $this->email = $guru->email;
        $this->jenis_kelamin = $guru->jenis_kelamin;
        $this->notlp = $guru->notlp;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        Guru::where('id_guru', $this->id_guru)->update([
            'namaGuru' => $this->namaGuru,
            'nip' => $this->nip,
            'username' => $this->username,
            'email' => $this->email,
            'jenis_kelamin' => $this->jenis_kelamin,
            'notlp' => $this->notlp,
        ]);

        $this->reset(['open', 'id_guru', 'namaGuru', 'nip', 'username', 'email', 'jenis_kelamin', 'notlp']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.guru.update');
    }
}
