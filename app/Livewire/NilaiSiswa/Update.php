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
    public $id_aspek;
    public $nilai;
    public $skor;

    // dropdown data
    public $kelasList   = [];
    public $aspekGroups = []; // parent + children

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
            'id_kelas'      => 'required|exists:kelas,id_kelas',
            'tgl_penilaian' => 'required|date',
            'id_aspek'      => 'required|exists:aspek_penilaian,id_aspek',
            'nilai'         => 'required|in:BSB,BSH,MB,BB',
            'skor'          => 'required|numeric|min:1|max:4',
        ];
    }

    public function mount($id_akunsiswa)
    {

        $this->id_akunsiswa = $id_akunsiswa;
        // auto-set guru yg login
        $this->id_guru   = optional(Auth::guard('guru')->user())->id_guru;
        $this->kelasList = Kelas::all();

        // hitung umur & muat aspek sesuai umur
        $siswa = AkunSiswa::findOrFail($id_akunsiswa);
        $umur   = Carbon::parse($siswa->tgl_lahir)->age;

        $this->aspekGroups = AspekPenilaian::whereNull('parent_id')
            ->where('min_umur', '<=', $umur)
            ->where('max_umur', '>=', $umur)
            ->with(['children' => function($q) use ($umur) {
                $q->where('min_umur', '<=', $umur)
                  ->where('max_umur', '>=', $umur)
                  ->orderBy('kode_aspek');
            }])
            ->orderBy('kode_aspek')
            ->get();
    }

    public function editModal($id_nilai)
    {
        $detail = NilaiSiswa::findOrFail($id_nilai);
        $pen    = Penilaian::findOrFail($detail->id_penilaian);

        $this->id_nilai      = $detail->id_nilai;
        $this->id_penilaian  = $pen->id_penilaian;
        $this->id_akunsiswa  = $pen->id_akunsiswa;
        // guru tidak bisa diubah
        $this->id_kelas      = $pen->id_kelas;
        $this->tgl_penilaian = $pen->tgl_penilaian;

        $this->id_aspek = $detail->id_aspek;
        $this->nilai    = $detail->nilai;
        $this->skor     = $detail->skor;

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
                'id_akunsiswa'  => $this->id_akunsiswa,
                'id_guru'       => $this->id_guru,
                'id_kelas'      => $this->id_kelas,
                'tgl_penilaian' => $this->tgl_penilaian,
            ]);

        // update detail nilai
        NilaiSiswa::where('id_nilai', $this->id_nilai)
            ->update([
                'id_aspek' => $this->id_aspek,
                'nilai'    => $this->nilai,
                'skor'     => $this->skor,
            ]);

        $this->reset([
            'open','id_nilai','id_penilaian',
            'id_kelas','tgl_penilaian',
            'id_aspek','nilai','skor'
        ]);

        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.nilai-siswa.update');
    }
}
