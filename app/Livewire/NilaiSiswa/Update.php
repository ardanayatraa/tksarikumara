<?php

namespace App\Livewire\NilaiSiswa;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\NilaiSiswa;
use App\Models\Penilaian;
use App\Models\AkunSiswa;
use App\Models\IndikatorAspek;

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
    public $kelasNama;
    public $tgl_penilaian;

    // detail NilaiSiswa
    public $indikator_aspek_id;
    public $nilai;
    public $skor;
    public $catatan;

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
            'tgl_penilaian'      => 'required|date',
            'nilai'              => 'required|in:BSB,BSH,MB,BB',
            'skor'               => 'required|numeric|min:1|max:4',
            'catatan'            => 'nullable|string',
        ];
    }

    public function mount($id_akunsiswa)
    {
        $this->id_akunsiswa = $id_akunsiswa;
        $this->id_guru      = optional(Auth::guard('guru')->user())->id_guru;

        $siswa = AkunSiswa::with('kelas')->findOrFail($id_akunsiswa);
        $this->id_kelas  = $siswa->id_kelas;
        $this->kelasNama = $siswa->kelas->namaKelas;
    }

    public function editModal($id_nilai)
    {
        $detail = NilaiSiswa::findOrFail($id_nilai);
        $pen    = Penilaian::findOrFail($detail->id_penilaian);

        $this->id_nilai           = $detail->id_nilai;
        $this->id_penilaian       = $pen->id_penilaian;
        $this->id_akunsiswa       = $pen->id_akunsiswa;
        $this->tgl_penilaian      = $pen->tgl_penilaian;

        $this->indikator_aspek_id = $detail->indikator_aspek_id;
        $this->nilai              = $detail->nilai;
        $this->skor               = $detail->skor;
        $this->catatan            = $detail->catatan;

        // juga (re)load nama kelas
        $siswa = AkunSiswa::with('kelas')->findOrFail($this->id_akunsiswa);
        $this->kelasNama = $siswa->kelas->namaKelas;

        $this->open = true;
    }

    public function updatedNilai($value)
    {
        $this->skor = $this->nilaiOptions[$value] ?? null;
    }

    public function update()
    {
        $this->validate();

        // update tanggal di header Penilaian
        Penilaian::where('id_penilaian', $this->id_penilaian)
            ->update([
                'tgl_penilaian' => $this->tgl_penilaian,
            ]);

        // update detail nilai
        NilaiSiswa::where('id_nilai', $this->id_nilai)
            ->update([
                'nilai'   => $this->nilai,
                'skor'    => $this->skor,
                'catatan' => $this->catatan,
            ]);

        $this->reset(['open','id_nilai','id_penilaian','tgl_penilaian','nilai','skor','catatan']);
        $this->dispatchBrowserEvent('refreshDatatable');
    }

    public function render()
    {
        $indikator = IndikatorAspek::find($this->indikator_aspek_id);
        return view('livewire.nilai-siswa.update', compact('indikator'));
    }
}
