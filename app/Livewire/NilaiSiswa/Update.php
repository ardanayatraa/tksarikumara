<?php

namespace App\Livewire\NilaiSiswa;

use Livewire\Component;
use App\Models\NilaiSiswa;
use App\Models\Penilaian;
use App\Models\AspekPenilaian;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Semester;

class Update extends Component
{
    public $open = false;

    // key
    public $id_nilai;
    public $id_penilaian;

    // untuk Penilaian
    public $id_akunsiswa;
    public $id_guru;
    public $id_kelas;
    public $id_semester;
    public $tgl_penilaian;

    // untuk detail NilaiSiswa
    public $id_aspek;
    public $nilai;
    public $skor;

    // dropdown data
    public $guruList    = [];
    public $kelasList   = [];
    public $semesterList= [];
    public $aspeks      = [];

    public $nilaiOptions = [
        'BSB' => 4,
        'BSH' => 3,
        'MB'  => 2,
        'BB'  => 1,
    ];

    protected $listeners = ['editNilaiSiswa' => 'editModal'];

    protected function rules()
    {
        return [
            'id_akunsiswa'  => 'required',
            'id_guru'       => 'required',
            'id_kelas'      => 'required',
            'id_semester'   => 'required',
            'tgl_penilaian' => 'required|date',
            'id_aspek'      => 'required',
            'nilai'         => 'required|string|min:0',
            'skor'          => 'required|numeric|min:0|max:100',
        ];
    }

    public function mount($id_akunsiswa)
    {
        // terima dari parent
        $this->id_akunsiswa   = $id_akunsiswa;
        $this->guruList       = Guru::all();
        $this->kelasList      = Kelas::all();
        $this->semesterList   = Semester::all();
        $this->aspeks         = AspekPenilaian::all();
    }

    public function editModal($id_nilai)
    {
        $item = NilaiSiswa::findOrFail($id_nilai);
        $pen  = Penilaian::findOrFail($item->id_penilaian);

        $this->id_nilai      = $item->id_nilai;
        $this->id_penilaian  = $pen->id_penilaian;
        $this->id_akunsiswa  = $pen->id_akunsiswa;
        $this->id_guru       = $pen->id_guru;
        $this->id_kelas      = $pen->id_kelas;
        $this->id_semester   = $pen->id_semester;
        $this->tgl_penilaian = $pen->tgl_penilaian;

        $this->id_aspek      = $item->id_aspek;
        $this->nilai         = $item->nilai;
        $this->skor          = $item->skor;

        $this->open = true;
    }

        public function updatedNilai($value)
    {
        if (isset($this->nilaiOptions[$value])) {
            $this->skor = $this->nilaiOptions[$value];
        } else {
            $this->skor = null;
        }
    }


    public function update()
    {
        $this->validate();

        // update Penilaian
        Penilaian::where('id_penilaian', $this->id_penilaian)->update([
            'id_akunsiswa'  => $this->id_akunsiswa,
            'id_guru'       => $this->id_guru,
            'id_kelas'      => $this->id_kelas,
            'id_semester'   => $this->id_semester,
            'tgl_penilaian' => $this->tgl_penilaian,
        ]);

        // update NilaiSiswa
        NilaiSiswa::where('id_nilai', $this->id_nilai)->update([
            'id_aspek' => $this->id_aspek,
            'nilai'    => $this->nilai,
            'skor'     => $this->skor,
        ]);

        $this->reset([
            'open',
            'id_nilai','id_penilaian',
            'id_guru','id_kelas','id_semester','tgl_penilaian',
            'id_aspek','nilai','skor'
        ]);
        $this->dispatchBrowserEvent('notify', 'Nilai siswa berhasil diupdate');
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.nilai-siswa.update');
    }
}
