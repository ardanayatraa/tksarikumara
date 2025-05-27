<?php

namespace App\Livewire\AkunSiswa;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\AkunSiswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Storage;

class Update extends Component
{
    use WithFileUploads;

    public $open = false;
    public $id_akunsiswa;
    public $id_kelas;
    public $nisn;
    public $namaSiswa;
    public $namaOrangTua;
    public $tgl_lahir;
    public $jenis_kelamin;
    public $alamat;
    public $email;
    public $username;
    public $password;      // optional
    public $foto;          // upload file baru
    public $fotoPreview;   // path foto lama

    protected $listeners = ['editSiswa'];

    protected function rules()
    {
        return [
            'id_kelas'      => 'required|exists:kelas,id_kelas',
            'nisn'          => 'required|string',
            'namaSiswa'     => 'required|string',
            'namaOrangTua'  => 'required|string',
            'tgl_lahir'     => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',
            'email'         => 'required|email',
            'username'      => 'required|string',
            'password'      => 'nullable|string|min:6',
            'foto'          => 'nullable|image|max:1024',
        ];
    }

    public function editSiswa($id)
    {
        $s = AkunSiswa::findOrFail($id);

        $this->id_akunsiswa  = $s->id_akunsiswa;
        $this->id_kelas      = $s->id_kelas;
        $this->nisn          = $s->nisn;
        $this->namaSiswa     = $s->namaSiswa;
        $this->namaOrangTua  = $s->namaOrangTua;
        $this->tgl_lahir     = $s->tgl_lahir;
        $this->jenis_kelamin = $s->jenis_kelamin;
        $this->alamat        = $s->alamat;
        $this->email         = $s->email;
        $this->username      = $s->username;
        $this->password      = '';
        $this->fotoPreview   = $s->foto;  // simpan path lama

        $this->open = true;
    }

    public function updatedFoto()
    {
        $this->validateOnly('foto');
    }

    public function update()
    {
        $this->validate();

        $data = [
            'id_kelas'      => $this->id_kelas,
            'nisn'          => $this->nisn,
            'namaSiswa'     => $this->namaSiswa,
            'namaOrangTua'  => $this->namaOrangTua,
            'tgl_lahir'     => $this->tgl_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat'        => $this->alamat,
            'email'         => $this->email,
            'username'      => $this->username,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        if ($this->foto) {
            // hapus file lama jika ada
            if ($this->fotoPreview && Storage::disk('public')->exists($this->fotoPreview)) {
                Storage::disk('public')->delete($this->fotoPreview);
            }
            $data['foto'] = $this->foto->store('siswa','public');
        }

        AkunSiswa::where('id_akunsiswa', $this->id_akunsiswa)->update($data);

        $this->reset([
            'open','id_akunsiswa','id_kelas','nisn','namaSiswa',
            'namaOrangTua','tgl_lahir','jenis_kelamin','alamat',
            'email','username','password','foto','fotoPreview'
        ]);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.akun-siswa.update', [
            'kelasList' => Kelas::all(),
        ]);
    }
}
