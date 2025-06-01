<?php

namespace App\Livewire\KepalaSekolah;

use Livewire\Component;
use App\Models\AkunSiswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\AspekPenilaian;

class Dashboard extends Component
{
    public $totalSiswaPerKelas = [];
    public $totalGuru;
    public $totalKelas;
    public $totalAspekPenilaian;

    public function mount()
    {
        // Total siswa per kelas (group by namaKelas)
        $kelasList = Kelas::withCount('akunSiswa')->get();
        $this->totalSiswaPerKelas = $kelasList->map(function ($kelas) {
            return [
                'namaKelas' => $kelas->namaKelas,
                'jumlahSiswa' => $kelas->akun_siswa_count,
            ];
        });

        // Total guru
        $this->totalGuru = Guru::count();

        // Total kelas
        $this->totalKelas = Kelas::count();

        // Total aspek penilaian
        $this->totalAspekPenilaian = AspekPenilaian::count();
    }

    public function render()
    {
        return view('livewire.kepala-sekolah.dashboard');
    }
}
