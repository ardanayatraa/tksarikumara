<?php

namespace App\Livewire\Guru;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Guru;
use Illuminate\Support\Facades\Storage;

class Update extends Component
{
    use WithFileUploads;

    public $open = false;
    public $id_guru;
    public $namaGuru;
    public $nip;
    public $username;
    public $email;
    public $jenis_kelamin;
    public $notlp;

    // foto baru (UploadedFile) dan preview foto lama
    public $foto;
    public $fotoPreview;

    protected $listeners = ['editGuru'];

    protected function rules()
    {
        return [
            'namaGuru'      => 'required|string|max:255',
            'nip'           => 'required|string|max:50',
            'username'      => 'required|string|max:50',
            'email'         => 'required|email',
            'jenis_kelamin' => 'required|in:L,P',
            'notlp'         => 'required|string|max:20',
            'foto'          => 'nullable|image|max:1024',
        ];
    }

    public function editGuru($id)
    {
        $guru = Guru::findOrFail($id);

        $this->id_guru       = $guru->id_guru;
        $this->namaGuru      = $guru->namaGuru;
        $this->nip           = $guru->nip;
        $this->username      = $guru->username;
        $this->email         = $guru->email;
        $this->jenis_kelamin = $guru->jenis_kelamin;
        $this->notlp         = $guru->notlp;

        // simpan path lama untuk preview
        $this->fotoPreview = $guru->foto;

        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        $data = [
            'namaGuru'      => $this->namaGuru,
            'nip'           => $this->nip,
            'username'      => $this->username,
            'email'         => $this->email,
            'jenis_kelamin' => $this->jenis_kelamin,
            'notlp'         => $this->notlp,
        ];

        // jika ada upload baru, simpan dan hapus lama
        if ($this->foto) {
            // hapus file lama jika ada
            if ($this->fotoPreview && Storage::disk('public')->exists($this->fotoPreview)) {
                Storage::disk('public')->delete($this->fotoPreview);
            }
            $path = $this->foto->store('guru','public');
            $data['foto'] = $path;
        }

        Guru::where('id_guru', $this->id_guru)->update($data);

        $this->reset([
            'open','id_guru','namaGuru','nip','username',
            'email','jenis_kelamin','notlp','foto','fotoPreview'
        ]);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.guru.update');
    }
}
