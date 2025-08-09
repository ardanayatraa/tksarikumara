<?php

namespace App\Livewire\Penilaian;

use App\Models\Penilaian;
use Livewire\Component;

class Add extends Component
{
    public $open = false;
    public $id_akunsiswa, $id_guru, $id_kelas, $tgl_penilaian, $minggu_ke, $semester, $tahun_ajaran, $kelompok_usia_siswa;

    // Initialize with authenticated user's ID
    public function mount()
    {
        $this->id_guru = auth()->user()->guru->id_guru ?? null;
        $this->tahun_ajaran = date('Y') . '/' . (date('Y') + 1);
        $this->semester = 1;
        $this->minggu_ke = 1;
        $this->kelompok_usia_siswa = '2-3_tahun';
    }

    protected $rules = [
        'id_akunsiswa' => 'required',
        'id_kelas' => 'required',
        'tgl_penilaian' => 'required|date',
        'minggu_ke' => 'required|integer|min:1|max:20',
        'semester' => 'required',
        'tahun_ajaran' => 'required',
        'kelompok_usia_siswa' => 'required|in:2-3_tahun,3-4_tahun,4-5_tahun,5-6_tahun',
    ];

    public function save()
    {
        $this->validate();

        Penilaian::create([
            'id_akunsiswa' => $this->id_akunsiswa,
            'id_guru' => $this->id_guru,
            'id_kelas' => $this->id_kelas,
            'tgl_penilaian' => $this->tgl_penilaian,
            'minggu_ke' => $this->minggu_ke,
            'semester' => $this->semester,
            'tahun_ajaran' => $this->tahun_ajaran,
            'kelompok_usia_siswa' => $this->kelompok_usia_siswa,
            'status' => 'draft',
        ]);

        $this->reset(['open', 'id_akunsiswa', 'id_kelas', 'tgl_penilaian', 'minggu_ke']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.penilaian.add');
    }
}
