<?php

namespace App\Livewire\NilaiSiswa;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AspekPenilaian;
use App\Models\IndikatorAspek;
use App\Models\AkunSiswa;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use Illuminate\Database\Eloquent\Builder;

class PenilaianManager extends Component
{
    use WithPagination;

    public $selectedAspekId;
    public $selectedIndikatorId;
    public $search = '';
    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';

    public $nilaiOptions = [
        'BSB' => 4,
        'BSH' => 3,
        'MB'  => 2,
        'BB'  => 1,
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function selectAspek($id)
    {
        $this->selectedAspekId     = $id;
        $this->selectedIndikatorId = null;
        $this->search              = '';
        $this->resetPage();
    }

    public function selectIndikator($id)
    {
        $this->selectedIndikatorId = $id;
        $this->search              = '';
        $this->resetPage();
    }

    public function backToAspek()
    {
        $this->selectedAspekId     = null;
        $this->selectedIndikatorId = null;
        $this->search              = '';
        $this->resetPage();
    }

    public function backToIndikator()
    {
        $this->selectedIndikatorId = null;
        $this->search              = '';
        $this->resetPage();
    }

    /**
     * Simpan atau update nilai siswa.
     */
    public function setNilai($idSiswa, $nilai)
    {
        // header penilaian hari ini
        $pen = Penilaian::firstOrCreate([
            'id_akunsiswa'  => $idSiswa,
            'id_guru'       => optional(Auth::guard('guru')->user())->id_guru,
            'id_kelas'      => AkunSiswa::find($idSiswa)->id_kelas,
            'tgl_penilaian' => today()->toDateString(),
        ]);

        // cari detail
        $detail = NilaiSiswa::where('id_penilaian', $pen->id_penilaian)
            ->where('indikator_aspek_id', $this->selectedIndikatorId)
            ->first();

        if ($detail) {
            // update
            $detail->update([
                'nilai' => $nilai,
                'skor'  => $this->nilaiOptions[$nilai] ?? null,
            ]);
        } else {
            // create
            NilaiSiswa::create([
                'id_penilaian'       => $pen->id_penilaian,
                'indikator_aspek_id' => $this->selectedIndikatorId,
                'nilai'              => $nilai,
                'skor'               => $this->nilaiOptions[$nilai] ?? null,
                'catatan'            => null,
            ]);
        }
    }

    public function render()
    {
        if (is_null($this->selectedAspekId)) {
            $aspeks = AspekPenilaian::when($this->search, fn($q) =>
                $q->where('nama_aspek','like',"%{$this->search}%")
                  ->orWhere('kode_aspek','like',"%{$this->search}%")
            )->paginate($this->perPage);

            return view('livewire.nilai-siswa.manager-aspek', compact('aspeks'));
        }

        if (is_null($this->selectedIndikatorId)) {
            $indikators = IndikatorAspek::where('aspek_id', $this->selectedAspekId)
                ->when($this->search, fn($q) =>
                    $q->where('nama_indikator','like',"%{$this->search}%")
                      ->orWhere('kode_indikator','like',"%{$this->search}%")
                )->paginate($this->perPage);

            $aspek = AspekPenilaian::findOrFail($this->selectedAspekId);
            return view('livewire.nilai-siswa.manager-indikator', compact('indikators','aspek'));
        }

        // daftar siswa
        $siswaList = AkunSiswa::with('kelas')
            ->when($this->search, fn(Builder $q) =>
                $q->where('namaSiswa','like',"%{$this->search}%")
                  ->orWhereHas('kelas', fn($q2) =>
                      $q2->where('namaKelas','like',"%{$this->search}%")
                  )
            )
            ->paginate($this->perPage);

        $indikator = IndikatorAspek::findOrFail($this->selectedIndikatorId);

        // ambil id_akunsiswa yang sudah punya nilai hari ini untuk indikator
        $checkedIds = DB::table('nilai_siswa')
            ->join('penilaian', 'nilai_siswa.id_penilaian', '=', 'penilaian.id_penilaian')
            ->where('nilai_siswa.indikator_aspek_id', $indikator->id)
            ->where('penilaian.tgl_penilaian', today()->toDateString())
            ->pluck('penilaian.id_akunsiswa')
            ->toArray();

        return view('livewire.nilai-siswa.manager-siswa', compact('siswaList','indikator','checkedIds'));
    }
}
