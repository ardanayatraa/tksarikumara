<?php

namespace App\Livewire\KepalaSekolah;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\KepalaSekolah;
use Illuminate\Support\Facades\Storage;

class Update extends Component
{
    use WithFileUploads;

    public $open         = false;
    public $id_kepalasekolah;
    public $namaKepalaSekolah;
    public $nip;
    public $email;
    public $notlp;
    public $username;

    // Foto handling
    public $foto;          // new upload
    public $fotoPreview;   // existing path

    protected $listeners = ['editKepsek'];

    protected function rules()
    {
        return [
            'namaKepalaSekolah' => 'required|string|max:255',
            'nip'               => 'required|string|max:50',
            'email'             => 'required|email',
            'notlp'             => 'required|string|max:20',
            'username'          => 'required|string|max:50',
            'foto'              => 'nullable|image|max:1024',
        ];
    }

    public function editKepsek($id)
    {
        $kepsek = KepalaSekolah::findOrFail($id);

        $this->id_kepalasekolah   = $kepsek->id_kepalasekolah;
        $this->namaKepalaSekolah  = $kepsek->namaKepalaSekolah;
        $this->nip                = $kepsek->nip;
        $this->email              = $kepsek->email;
        $this->notlp              = $kepsek->notlp;
        $this->username           = $kepsek->username;
        $this->fotoPreview        = $kepsek->foto;   // existing file path

        $this->open = true;
    }

    public function updatedFoto()
    {
        // validate only foto on upload & enable preview
        $this->validateOnly('foto');
    }

    public function update()
    {
        $this->validate();

        $data = [
            'namaKepalaSekolah' => $this->namaKepalaSekolah,
            'nip'               => $this->nip,
            'email'             => $this->email,
            'notlp'             => $this->notlp,
            'username'          => $this->username,
        ];

        if ($this->foto) {
            // delete old if exists
            if ($this->fotoPreview && Storage::disk('public')->exists($this->fotoPreview)) {
                Storage::disk('public')->delete($this->fotoPreview);
            }
            // store new
            $data['foto'] = $this->foto->store('kepala-sekolah','public');
        }

        KepalaSekolah::where('id_kepalasekolah', $this->id_kepalasekolah)
            ->update($data);

        // reset all
        $this->reset([
            'open','id_kepalasekolah','namaKepalaSekolah','nip',
            'email','notlp','username','foto','fotoPreview'
        ]);

        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.kepala-sekolah.update');
    }
}
