<?php

namespace App\Livewire\KepalaSekolah;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\KepalaSekolah;

class Add extends Component
{
    use WithFileUploads;

    public $open = false;
    public $namaKepalaSekolah;
    public $nip;
    public $email;
    public $notlp;
    public $username;
    public $password;
    public $foto;           // untuk upload
    public $fotoPreviewUrl; // untuk preview

    protected $rules = [
        'namaKepalaSekolah' => 'required|string|max:255',
        'nip'               => 'required|string|max:50',
        'email'             => 'required|email',
        'notlp'             => 'required|string|max:20',
        'username'          => 'required|string|max:50',
        'password'          => 'required|string|min:6',
        'foto'              => 'nullable|image|max:1024', // max 1MB
    ];

    public function updatedFoto()
    {
        // validasi hanya foto saat diupload, lalu simpan temporary URL
        $this->validateOnly('foto');
        $this->fotoPreviewUrl = $this->foto->temporaryUrl();
    }

    public function save()
    {
        $this->validate();

        $path = null;
        if ($this->foto) {
            $path = $this->foto->store('kepala-sekolah','public');
        }

        KepalaSekolah::create([
            'namaKepalaSekolah' => $this->namaKepalaSekolah,
            'nip'               => $this->nip,
            'email'             => $this->email,
            'notlp'             => $this->notlp,
            'username'          => $this->username,
            'password'          => bcrypt($this->password),
            'foto'              => $path,
        ]);

        $this->reset([
            'open','namaKepalaSekolah','nip','email','notlp',
            'username','password','foto','fotoPreviewUrl'
        ]);

        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.kepala-sekolah.add');
    }
}
