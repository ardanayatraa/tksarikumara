<?php

namespace App\Livewire\AkunSiswa;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\AkunSiswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Storage;

class Add extends Component
{
    use WithFileUploads;

    public $open = false;
    public $id_kelas;
    public $nisn;
    public $namaSiswa;
    public $namaOrangTua;
    public $tgl_lahir;
    public $jenis_kelamin;
    public $alamat;
    public $email;
    public $username;
    public $password;
    public $foto;
    public $fotoPreviewUrl;

    protected $rules = [
        'id_kelas'      => 'required|exists:kelas,id_kelas',
        'nisn'          => 'required|string',
        'namaSiswa'     => 'required|string',
        'namaOrangTua'  => 'required|string',
        'tgl_lahir'     => 'required|date',
        'jenis_kelamin' => 'required|in:L,P',
        'alamat'        => 'required|string',
        'email'         => 'required|email',
        'username'      => 'required|string',
        'password'      => 'required|string|min:6',
        'foto'          => 'nullable|image|max:1024',
    ];

    public function save()
    {
        $this->validate();

        $path = $this->foto ? $this->foto->store('siswa','public') : null;

        AkunSiswa::create([
            'id_kelas'      => $this->id_kelas,
            'nisn'          => $this->nisn,
            'namaSiswa'     => $this->namaSiswa,
            'namaOrangTua'  => $this->namaOrangTua,
            'tgl_lahir'     => $this->tgl_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat'        => $this->alamat,
            'email'         => $this->email,
            'username'      => $this->username,
            'password'      => bcrypt($this->password),
            'foto'          => $path,
        ]);

        $this->reset([
            'open','id_kelas','nisn','namaSiswa','namaOrangTua',
            'tgl_lahir','jenis_kelamin','alamat','email',
            'username','password','foto','fotoPreviewUrl'
        ]);

        $this->dispatchBrowserEvent('refreshDatatable');
    }

    public function updatedFoto()
    {
        $this->validateOnly('foto');
        $this->fotoPreviewUrl = $this->foto->temporaryUrl();
    }

    public function render()
    {
        return view('livewire.akun-siswa.add', [
            'kelasList' => Kelas::all(),
        ]);
    }
}
