<?php

namespace App\Livewire\NilaiSiswa;

use Livewire\Component;
use App\Models\NilaiSiswa;
use App\Models\Penilaian;
use App\Models\AspekPenilaian;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Semester;

class Add extends Component
{
    public $open = false;

    // langsung terima dari parent
    public $id_akunsiswa;

    // field Penilaian lain
    public $id_guru;
    public $id_kelas;
    public $id_semester;
    public $tgl_penilaian;

    // detail NilaiSiswa
    public $id_aspek;
    public $nilai;
    public $skor;

    // data untuk dropdown
    public $guruList = [];
    public $kelasList = [];
    public $semesterList = [];
    public $aspeks = [];

    public $nilaiOptions = [
        'BSB' => 4,
        'BSH' => 3,
        'MB'  => 2,
        'BB'  => 1,
    ];

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

    public function updatedNilai($value)
{
    if (isset($this->nilaiOptions[$value])) {
        $this->skor = $this->nilaiOptions[$value];
    } else {
        $this->skor = null;
    }
}


    // sekarang menerima $id_akunsiswa sebagai argumen
    public function mount($id_akunsiswa)
    {
        $this->id_akunsiswa  = $id_akunsiswa;
        $this->guruList      = Guru::all();
        $this->kelasList     = Kelas::all();
        $this->semesterList  = Semester::all();
        $this->aspeks        = AspekPenilaian::all();
    }

    public function save()
    {
        $this->validate();

        $penilaian = Penilaian::create([
            'id_akunsiswa'  => $this->id_akunsiswa,
            'id_guru'       => $this->id_guru,
            'id_kelas'      => $this->id_kelas,
            'id_semester'   => $this->id_semester,
            'tgl_penilaian' => $this->tgl_penilaian,
        ]);

        NilaiSiswa::create([
            'id_penilaian' => $penilaian->id_penilaian,
            'id_aspek'     => $this->id_aspek,
            'nilai'        => $this->nilai,
            'skor'         => $this->skor,
        ]);

        $this->reset([
            'open',
            'id_guru','id_kelas','id_semester','tgl_penilaian',
            'id_aspek','nilai','skor'
        ]);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.nilai-siswa.add');
    }
}
