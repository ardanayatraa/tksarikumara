<?php

namespace App\Livewire\KepalaSekolah;

use App\Models\KepalaSekolah;
use Livewire\Component;

class Update extends Component
{
    public $open = false;
    public $id_kepalasekolah, $namaKepalaSekolah, $nip, $email, $notlp, $username;

    protected $listeners = ['editKepalaSekolahModal'];

    protected $rules = [
        'namaKepalaSekolah' => 'required',
        'nip' => 'required',
        'email' => 'required|email',
        'notlp' => 'required',
        'username' => 'required',
    ];

    public function editKepalaSekolahModal($id)
    {
        $kepsek = KepalaSekolah::findOrFail($id);
        $this->id_kepalasekolah = $kepsek->id_kepalasekolah;
        $this->namaKepalaSekolah = $kepsek->namaKepalaSekolah;
        $this->nip = $kepsek->nip;
        $this->email = $kepsek->email;
        $this->notlp = $kepsek->notlp;
        $this->username = $kepsek->username;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        KepalaSekolah::where('id_kepalasekolah', $this->id_kepalasekolah)->update([
            'namaKepalaSekolah' => $this->namaKepalaSekolah,
            'nip' => $this->nip,
            'email' => $this->email,
            'notlp' => $this->notlp,
            'username' => $this->username,
        ]);

        $this->reset(['open', 'id_kepalasekolah', 'namaKepalaSekolah', 'nip', 'email', 'notlp', 'username']);
        $this->dispatchBrowserEvent('notify', 'Data kepala sekolah berhasil diupdate');
        $this->emit('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.kepala-sekolah.update');
    }
}
