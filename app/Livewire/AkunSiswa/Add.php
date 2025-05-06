<?php

namespace App\Livewire\AkunSiswa;

use App\Models\AkunSiswa;
use App\Models\Kelas;
use Livewire\Component;

class Add extends Component
{
    public $open = false;
    public $id_kelas, $nisn, $namaSiswa, $tgl_lahir, $jenis_kelamin, $alamat, $email, $username, $password;

    protected $rules = [
        'id_kelas' => 'required|exists:kelas,id_kelas',
        'nisn' => 'required',
        'namaSiswa' => 'required',
        'tgl_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:L,P',
        'alamat' => 'required',
        'email' => 'required|email',
        'username' => 'required',
        'password' => 'required',
    ];

    public function save()
    {
        $this->validate();

        AkunSiswa::create([
            'id_kelas' => $this->id_kelas,
            'nisn' => $this->nisn,
            'namaSiswa' => $this->namaSiswa,
            'tgl_lahir' => $this->tgl_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'email' => $this->email,
            'username' => $this->username,
            'password' => bcrypt($this->password),
        ]);

        $this->reset(['open', 'id_kelas', 'nisn', 'namaSiswa', 'tgl_lahir', 'jenis_kelamin', 'alamat', 'email', 'username', 'password']);

        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.akun-siswa.add', [
            'kelasList' => Kelas::all(),
        ]);
    }
}
