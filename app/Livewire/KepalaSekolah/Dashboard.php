<?php

namespace App\Livewire\KepalaSekolah;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\AkunSiswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\AspekPenilaian;

class Dashboard extends Component
{
    public $kepsekLogin;
    public $totalSiswaPerKelas = [];
    public $totalGuru;
    public $totalKelas;
    public $totalAspekPenilaian;

    public function mount()
    {
        // ambil kepala sekolah yang sedang login
        $this->kepsekLogin = Auth::guard('kepsek')->user();

        // total siswa per kelas
        $kelasList = Kelas::withCount('akunSiswa')->get();
        $this->totalSiswaPerKelas = $kelasList->map(fn($kelas) => [
            'id_kelas'     => $kelas->id_kelas,
            'namaKelas'    => $kelas->namaKelas,
            'jumlahSiswa'  => $kelas->akun_siswa_count,
        ])->toArray();

        // statistik lainnya
        $this->totalGuru           = Guru::count();
        $this->totalKelas          = Kelas::count();
        $this->totalAspekPenilaian = AspekPenilaian::count();
    }

    public function render()
    {
        return view('livewire.kepala-sekolah.dashboard');
    }
}
