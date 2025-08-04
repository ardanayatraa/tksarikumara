<?php

namespace App\Livewire\NilaiSiswa;

use Livewire\Component;
use App\Models\NilaiSiswa;
use App\Models\Penilaian;
use App\Models\AkunSiswa;
use App\Models\IndikatorAspek;
use Illuminate\Support\Facades\Auth;

class Add extends Component
{
    public $open = false;

    // Props dari parent (harus sesuai key saat @livewire dipanggil)
    public $id_akunsiswa;
    public $indikator_id;

    // Header penilaian
    public $id_guru;
    public $id_kelas;
    public $kelasNama;
    public $tgl_penilaian;

    // Detail nilai
    public $nilai;
    public $skor;
    public $catatan;

    public $nilaiOptions = [
        'BSB' => 4,
        'BSH' => 3,
        'MB'  => 2,
        'BB'  => 1,
    ];

    public function updatedNilai($value)
    {
        $this->skor = $this->nilaiOptions[$value] ?? null;
    }

    public function mount($id_akunsiswa, $indikator_id)
    {
        $this->id_akunsiswa = $id_akunsiswa;
        $this->indikator_id = $indikator_id;
        $this->id_guru            = optional(Auth::guard('guru')->user())->id_guru;

        $siswa = AkunSiswa::with('kelas')->findOrFail($id_akunsiswa);
        $this->id_kelas  = $siswa->id_kelas;
        $this->kelasNama = $siswa->kelas->namaKelas;
    }

    public function save()
    {
        $this->validate([
            'tgl_penilaian' => 'required|date',
            'nilai'         => 'required|in:BSB,BSH,MB,BB',
        ]);

        $pen = Penilaian::create([
            'id_akunsiswa'  => $this->id_akunsiswa,
            'id_guru'       => $this->id_guru,
            'id_kelas'      => $this->id_kelas,
            'tgl_penilaian' => $this->tgl_penilaian,
        ]);

        NilaiSiswa::create([
            'id_penilaian' => $pen->id_penilaian,
            'indikator_id' => $this->indikator_id,
            'nilai'        => $this->nilai,
            'skor'               => $this->skor,
            'catatan'            => $this->catatan,
        ]);

        $this->reset(['open','tgl_penilaian','nilai','skor','catatan']);
        $this->dispatchBrowserEvent('refreshDatatable');
    }

    public function render()
    {
        // ambil nama indikator untuk ditampilkan di modal
        $indikator = \App\Models\Indikator::find($this->indikator_id);

        return view('livewire.nilai-siswa.add', compact('indikator'));
    }
}
