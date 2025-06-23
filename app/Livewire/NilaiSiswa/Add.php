<?php

namespace App\Livewire\NilaiSiswa;

use Livewire\Component;
use App\Models\NilaiSiswa;
use App\Models\Penilaian;
use App\Models\AkunSiswa;
use App\Models\IndikatorAspek;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Add extends Component
{
    public $open = false;

    // Props from parent
    public $id_akunsiswa;

    // Header penilaian
    public $id_guru;
    public $id_kelas;
    public $kelasNama;
    public $tgl_penilaian;

    // Detail nilai
    public $indikator_aspek_id;
    public $nilai;
    public $skor;
    public $catatan;

    // Data dropdown
    public $indikatorGroups = [];   // grouped by aspek
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

    public function mount($id_akunsiswa)
    {
        $this->id_akunsiswa = $id_akunsiswa;
        $this->id_guru     = optional(Auth::guard('guru')->user())->id_guru;

        $siswa = AkunSiswa::with('kelas')->findOrFail($id_akunsiswa);
        $this->id_kelas  = $siswa->id_kelas;
        $this->kelasNama = $siswa->kelas->namaKelas;


        // Ambil indikator langsung dari IndikatorAspek, filter umur, eager aspek
        $indicators = IndikatorAspek::with('aspek')
          ->get();


        // Group by aspek kode & nama
        $this->indikatorGroups = $indicators
            ->groupBy(fn($i) => "{$i->aspek->kode_aspek}. {$i->aspek->nama_aspek}")
            ->all();
    }

    public function save()
    {
        $this->validate([
            'tgl_penilaian'       => 'required|date',
            'indikator_aspek_id'  => 'required|exists:indikator_aspek,id',
            'nilai'               => 'required|in:BSB,BSH,MB,BB',
        ]);

        $pen = Penilaian::create([
            'id_akunsiswa'  => $this->id_akunsiswa,
            'id_guru'       => $this->id_guru,
            'id_kelas'      => $this->id_kelas,
            'tgl_penilaian' => $this->tgl_penilaian,
        ]);

        NilaiSiswa::create([
            'id_penilaian'        => $pen->id_penilaian,
            'indikator_aspek_id'  => $this->indikator_aspek_id,
            'nilai'               => $this->nilai,
            'skor'                => $this->skor,
            'catatan'             => $this->catatan,
        ]);

        $this->reset(['open','tgl_penilaian','indikator_aspek_id','nilai','skor','catatan']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.nilai-siswa.add');
    }
}
