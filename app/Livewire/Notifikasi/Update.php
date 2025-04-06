<?php

namespace App\Livewire\Notifikasi;

use App\Models\Notifikasi;
use Livewire\Component;

class Update extends Component
{
    public $open = false;
    public $id_notifikasi, $id_akunsiswa, $id_penilaian, $id_guru, $tgl_penilaian, $status_pengiriman;

    protected $listeners = ['editNotifikasiModal'];

    protected $rules = [
        'id_akunsiswa' => 'required|exists:akun_siswa,id_akunsiswa',
        'id_penilaian' => 'required|exists:penilaian,id_penilaian',
        'id_guru' => 'required|exists:guru,id_guru',
        'tgl_penilaian' => 'required|date',
        'status_pengiriman' => 'required|string',
    ];

    public function editNotifikasiModal($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $this->id_notifikasi = $notifikasi->id_notifikasi;
        $this->id_akunsiswa = $notifikasi->id_akunsiswa;
        $this->id_penilaian = $notifikasi->id_penilaian;
        $this->id_guru = $notifikasi->id_guru;
        $this->tgl_penilaian = $notifikasi->tgl_penilaian;
        $this->status_pengiriman = $notifikasi->status_pengiriman;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        Notifikasi::where('id_notifikasi', $this->id_notifikasi)->update([
            'id_akunsiswa' => $this->id_akunsiswa,
            'id_penilaian' => $this->id_penilaian,
            'id_guru' => $this->id_guru,
            'tgl_penilaian' => $this->tgl_penilaian,
            'status_pengiriman' => $this->status_pengiriman,
        ]);

        $this->reset(['open', 'id_notifikasi', 'id_akunsiswa', 'id_penilaian', 'id_guru', 'tgl_penilaian', 'status_pengiriman']);
        $this->dispatchBrowserEvent('notify', 'Notifikasi berhasil diupdate');
        $this->emit('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.notifikasi.update');
    }
}
