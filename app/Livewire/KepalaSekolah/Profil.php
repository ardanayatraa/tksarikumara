<?php

namespace App\Livewire\KepalaSekolah;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\KepalaSekolah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Profil extends Component
{
    use WithFileUploads;

    public $id_kepalasekolah;
    public $namaKepalaSekolah;
    public $nip;
    public $email;
    public $notlp;
    public $username;
    public $password;
    public $foto;
    public $fotoPreview;

    public function mount()
    {
        $kepala = Auth::guard('kepsek')->user();
        if (!$kepala) abort(403);

        $this->id_kepalasekolah    = $kepala->id_kepalasekolah;
        $this->namaKepalaSekolah   = $kepala->namaKepalaSekolah;
        $this->nip                 = $kepala->nip;
        $this->email               = $kepala->email;
        $this->notlp               = $kepala->notlp;
        $this->username            = $kepala->username;
        $this->password            = '';
        $this->fotoPreview         = $kepala->foto;
    }

    protected function rules()
    {
        return [
            'namaKepalaSekolah' => 'required|string',
            'nip'               => 'nullable|string',
            'email'             => 'required|email',
            'notlp'             => 'nullable|string',
            'username'          => 'required|string',
            'password'          => 'nullable|string|min:6',
            'foto'              => 'nullable|image|max:1024',
        ];
    }

    public function updatedFoto()
    {
        $this->validateOnly('foto');
    }

    public function updateProfil()
    {
        $this->validate();

        $data = [
            'namaKepalaSekolah' => $this->namaKepalaSekolah,
            'nip'               => $this->nip,
            'email'             => $this->email,
            'notlp'             => $this->notlp,
            'username'          => $this->username,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        if ($this->foto) {
            if ($this->fotoPreview && Storage::disk('public')->exists($this->fotoPreview)) {
                Storage::disk('public')->delete($this->fotoPreview);
            }
            $data['foto'] = $this->foto->store('kepala-sekolah', 'public');
        }

        KepalaSekolah::where('id_kepalasekolah', $this->id_kepalasekolah)->update($data);

        if (isset($data['foto'])) {
            $this->fotoPreview = $data['foto'];
            $this->foto = null;
        }

        session()->flash('message', 'Profil berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.kepala-sekolah.profil');
    }
}
