<?php

namespace App\Livewire\NilaiSiswa;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\NilaiSiswa;
use App\Models\Penilaian;
use App\Models\AspekPenilaian;
use App\Models\Kelas;
use App\Models\AkunSiswa;
use Carbon\Carbon;

class Update extends Component
{
    public $open = false;

    // keys
    public $id_nilai;
    public $id_penilaian;

    // header Penilaian
    public $id_akunsiswa;
    public $id_guru;
    public $id_kelas;
    public $tgl_penilaian;

    // detail NilaiSiswa
    public $indikator_aspek_id;
    public $nilai;
    public $skor;
    public $catatan;

    // dropdown data
    public $kelasList   = [];
    public $aspekGroups = [];

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
            'id_kelas'             => 'required|exists:kelas,id_kelas',
            'tgl_penilaian'        => 'required|date',
            'indikator_aspek_id'   => 'required|exists:indikator_aspek,id',
            'nilai'                => 'required|in:BSB,BSH,MB,BB',
            'skor'                 => 'required|numeric|min:1|max:4',
            'catatan'              => 'nullable|string',
        ];
    }

    public function mount($id_akunsiswa)
    {
        $this->id_akunsiswa = $id_akunsiswa;
        $this->id_guru   = optional(Auth::guard('guru')->user())->id_guru;
        $this->kelasList = Kelas::all();

        $siswa = AkunSiswa::findOrFail($id_akunsiswa);
        $umur   = Carbon::parse($siswa->tgl_lahir)->age;

        // muat semua aspek + indikator sesuai umur
        $this->aspekGroups = AspekPenilaian::with(['indikator' => function($q) use ($umur) {
                $q->where('min_umur', '<=', $umur)
                  ->where('max_umur', '>=', $umur)
                  ->orderBy('kode_indikator');
            }])
            ->orderBy('kode_aspek')
            ->get()
            ->filter(fn($asp) => $asp->indikator->isNotEmpty())
            ->values();
    }

    public function editModal($id_nilai)
    {
        $detail = NilaiSiswa::findOrFail($id_nilai);
        $pen    = Penilaian::findOrFail($detail->id_penilaian);

        $this->id_nilai            = $detail->id_nilai;
        $this->id_penilaian        = $pen->id_penilaian;
        $this->id_akunsiswa        = $pen->id_akunsiswa;
        $this->id_kelas            = $pen->id_kelas;
        $this->tgl_penilaian       = $pen->tgl_penilaian;

        $this->indikator_aspek_id  = $detail->indikator_aspek_id;
        $this->nilai               = $detail->nilai;
        $this->skor                = $detail->skor;
        $this->catatan             = $detail->catatan;

        $this->open = true;
    }

    public function updatedNilai($value)
    {
        $this->skor = $this->nilaiOptions[$value] ?? null;
    }

    public function update()
    {
        $this->validate();

        // update header penilaian
        Penilaian::where('id_penilaian', $this->id_penilaian)
            ->update([
                'id_kelas'      => $this->id_kelas,
                'tgl_penilaian' => $this->tgl_penilaian,
            ]);

        // update detail nilai
        NilaiSiswa::where('id_nilai', $this->id_nilai)
            ->update([
                'indikator_aspek_id' => $this->indikator_aspek_id,
                'nilai'              => $this->nilai,
                'skor'               => $this->skor,
                'catatan'            => $this->catatan,
            ]);

        // reset state
        $this->reset([
            'open','id_nilai','id_penilaian',
            'id_kelas','tgl_penilaian',
            'indikator_aspek_id','nilai','skor','catatan'
        ]);

        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.nilai-siswa.update');
    }
}
