<?php

namespace App\Livewire\Guru;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Profil extends Component
{
    use WithFileUploads;

    public $id_guru;
    public $namaGuru;
    public $nip;
    public $email;
    public $username;
    public $password;
    public $jenis_kelamin;
    public $notlp;
    public $foto;        // Untuk upload baru
    public $fotoPreview; // Path foto lama

    public function mount()
    {
        $guru = Auth::guard('guru')->user();
        if (!$guru) abort(403);

        $this->id_guru      = $guru->id_guru;
        $this->namaGuru     = $guru->namaGuru;
        $this->nip          = $guru->nip;
        $this->email        = $guru->email;
        $this->username     = $guru->username;
        $this->jenis_kelamin= $guru->jenis_kelamin;
        $this->notlp        = $guru->notlp;
        $this->password     = '';
        $this->fotoPreview  = $guru->foto;
    }

    protected function rules()
    {
        return [
            'namaGuru'      => 'required|string',
            'nip'           => 'nullable|string',
            'email'         => 'required|email',
            'username'      => 'required|string',
            'password'      => 'nullable|string|min:6',
            'jenis_kelamin' => 'required|in:L,P',
            'notlp'         => 'nullable|string',
            'foto'          => 'nullable|image|max:1024',
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
            'namaGuru'      => $this->namaGuru,
            'nip'           => $this->nip,
            'email'         => $this->email,
            'username'      => $this->username,
            'jenis_kelamin' => $this->jenis_kelamin,
            'notlp'         => $this->notlp,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        if ($this->foto) {
            if ($this->fotoPreview && Storage::disk('public')->exists($this->fotoPreview)) {
                Storage::disk('public')->delete($this->fotoPreview);
            }
            $data['foto'] = $this->foto->store('guru', 'public');
        }

        Guru::where('id_guru', $this->id_guru)->update($data);

        if (isset($data['foto'])) {
            $this->fotoPreview = $data['foto'];
            $this->foto = null;
        }

        session()->flash('message', 'Profil berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.guru.profil');
    }
}
