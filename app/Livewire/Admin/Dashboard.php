<?php

namespace App\Livewire\Admin;

use App\Models\AkunSiswa;
use Livewire\Component;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;

class Dashboard extends Component
{
    public $jumlahSiswa;
    public $jumlahGuru;
    public $jumlahKelas;

    public function mount()
    {
        // Ambil jumlah siswa, guru, dan kelas
        $this->jumlahSiswa = AkunSiswa::count();
        $this->jumlahGuru = Guru::count();
        $this->jumlahKelas = Kelas::count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
