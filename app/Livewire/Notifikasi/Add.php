<?php

namespace App\Livewire\Notifikasi;

use App\Models\Notifikasi;
use App\Models\AkunSiswa;
use App\Models\Penilaian;
use App\Models\Guru;
use Livewire\Component;

class Add extends Component
{
    public $open = false;
    public $id_akunsiswa, $id_penilaian, $id_guru, $tgl_penilaian, $status_pengiriman;
    public $siswa = [], $penilaians = [], $gurus = [];

    protected $rules = [
        'id_akunsiswa' => 'required|exists:akun_siswa,id_akunsiswa',
        'id_penilaian' => 'required|exists:penilaian,id_penilaian',
        'id_guru' => 'required|exists:guru,id_guru',
        'tgl_penilaian' => 'required|date',
        'status_pengiriman' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->siswa = AkunSiswa::all();
        $this->penilaians = Penilaian::all();
        $this->gurus = Guru::all();
    }

    public function save()
    {
        $this->validate();

        Notifikasi::create([
            'id_akunsiswa' => $this->id_akunsiswa,
            'id_penilaian' => $this->id_penilaian,
            'id_guru' => $this->id_guru,
            'tgl_penilaian' => $this->tgl_penilaian,
            'status_pengiriman' => $this->status_pengiriman,
        ]);

        $this->reset([
            'open', 'id_akunsiswa', 'id_penilaian', 'id_guru', 'tgl_penilaian', 'status_pengiriman'
        ]);

        $this->dispatchBrowserEvent('notify', 'Notifikasi berhasil ditambahkan');
        $this->emit('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.notifikasi.add');
    }
}
