<?php

namespace App\Livewire\NilaiSiswa;

use App\Models\NilaiSiswa;
use Livewire\Component;

class Update extends Component
{
    public $open = false;
    public $id_nilai, $id_penilaian, $aspek_penilaian, $kategori, $skor;

    protected $listeners = ['editNilaiSiswaModal'];

    protected $rules = [
        'id_penilaian' => 'required|exists:penilaian,id_penilaian',
        'aspek_penilaian' => 'required|string',
        'kategori' => 'required|string',
        'skor' => 'required|numeric|min:0|max:100',
    ];

    public function editNilaiSiswaModal($id)
    {
        $nilai = NilaiSiswa::findOrFail($id);
        $this->id_nilai = $nilai->id_nilai;
        $this->id_penilaian = $nilai->id_penilaian;
        $this->aspek_penilaian = $nilai->aspek_penilaian;
        $this->kategori = $nilai->kategori;
        $this->skor = $nilai->skor;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        NilaiSiswa::where('id_nilai', $this->id_nilai)->update([
            'id_penilaian' => $this->id_penilaian,
            'aspek_penilaian' => $this->aspek_penilaian,
            'kategori' => $this->kategori,
            'skor' => $this->skor,
        ]);

        $this->reset(['open', 'id_nilai', 'id_penilaian', 'aspek_penilaian', 'kategori', 'skor']);
        $this->dispatchBrowserEvent('notify', 'Nilai siswa berhasil diupdate');
        $this->emit('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.nilai-siswa.update');
    }
}
