<?php

namespace App\Livewire\AkunSiswa;

use App\Models\AkunSiswa;
use Livewire\Component;

class Update extends Component
{
    public $open = false;
    public $id_akunsiswa, $id_kelas, $nisn, $namaSiswa, $tgl_lahir, $jenis_kelamin, $alamat, $email, $username, $password;

    protected $listeners = ['editSiswa'];

    protected $rules = [
        'id_kelas' => 'required',
        'nisn' => 'required',
        'namaSiswa' => 'required',
        'tgl_lahir' => 'required|date',
        'jenis_kelamin' => 'required',
        'alamat' => 'required',
        'email' => 'required|email',
        'username' => 'required',
        'password' => 'nullable|min:6',
    ];

    public function editSiswa($id)
    {
        $siswa = AkunSiswa::findOrFail($id);
        $this->id_akunsiswa = $siswa->id_akunsiswa;
        $this->id_kelas = $siswa->id_kelas;
        $this->nisn = $siswa->nisn;
        $this->namaSiswa = $siswa->namaSiswa;
        $this->tgl_lahir = $siswa->tgl_lahir;
        $this->jenis_kelamin = $siswa->jenis_kelamin;
        $this->alamat = $siswa->alamat;
        $this->email = $siswa->email;
        $this->username = $siswa->username;
        $this->password = ''; // kosongkan password

        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        $data = [
            'id_kelas' => $this->id_kelas,
            'nisn' => $this->nisn,
            'namaSiswa' => $this->namaSiswa,
            'tgl_lahir' => $this->tgl_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'email' => $this->email,
            'username' => $this->username,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        AkunSiswa::where('id_akunsiswa', $this->id_akunsiswa)->update($data);

        $this->reset(['open', 'id_akunsiswa', 'id_kelas', 'nisn', 'namaSiswa', 'tgl_lahir', 'jenis_kelamin', 'alamat', 'email', 'username', 'password']);
        $this->dispatchBrowserEvent('notify', 'Akun siswa berhasil diupdate');
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.akun-siswa.update');
    }
}
