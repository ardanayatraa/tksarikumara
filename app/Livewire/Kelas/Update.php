<?php

namespace App\Livewire\Kelas;

use App\Models\Kelas;
use Livewire\Component;

class Update extends Component
{
    public $open = false;
    public $id_kelas, $namaKelas, $tahunAjaran, $jumlahSiswa;

    protected $listeners = ['editKelasModal'];

    protected $rules = [
        'namaKelas' => 'required',
        'tahunAjaran' => 'required',
        'jumlahSiswa' => 'required|integer',
    ];

    public function editKelasModal($id)
    {
        $kelas = Kelas::findOrFail($id);
        $this->id_kelas = $kelas->id_kelas;
        $this->namaKelas = $kelas->namaKelas;
        $this->tahunAjaran = $kelas->tahunAjaran;
        $this->jumlahSiswa = $kelas->jumlahSiswa;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        Kelas::where('id_kelas', $this->id_kelas)->update([
            'namaKelas' => $this->namaKelas,
            'tahunAjaran' => $this->tahunAjaran,
            'jumlahSiswa' => $this->jumlahSiswa,
        ]);

        $this->reset(['open', 'id_kelas', 'namaKelas', 'tahunAjaran', 'jumlahSiswa']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.kelas.update');
    }
}
