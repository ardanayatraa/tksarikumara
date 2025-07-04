<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\AkunSiswa;
use App\Models\Guru;
use App\Models\Kelas;

class Dashboard extends Component
{
    public $adminLogin;
    public $jumlahSiswa;
    public $jumlahGuru;
    public $jumlahKelas;

    public function mount()
    {
        // Ambil admin yang sedang login
        $this->adminLogin   = Auth::guard('admin')->user();

        // Ambil statistik
        $this->jumlahSiswa  = AkunSiswa::count();
        $this->jumlahGuru   = Guru::count();
        $this->jumlahKelas  = Kelas::count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
