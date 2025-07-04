<?php

namespace App\Livewire\Guru;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $guruLogin;
    public $kelasGuru;
    public $jumlahSiswaDiKelas;

    public function mount()
    {
        // Ambil data guru yang sedang login
        $this->guruLogin = Auth::guard('guru')->user();

        if ($this->guruLogin) {
            // Ambil data kelas guru tersebut
            $this->kelasGuru = $this->guruLogin->kelas;

            // Ambil jumlah siswa pada kelas guru
            $this->jumlahSiswaDiKelas = $this->kelasGuru
                ? $this->kelasGuru->akunSiswa()->count()
                : 0;
        } else {
            $this->kelasGuru = null;
            $this->jumlahSiswaDiKelas = 0;
        }
    }

    public function render()
    {
        return view('livewire.guru.dashboard');
    }
}
