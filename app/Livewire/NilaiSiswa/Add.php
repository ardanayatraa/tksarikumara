<?php

namespace App\Livewire\NilaiSiswa;

use Livewire\Component;
use App\Models\NilaiSiswa;
use App\Models\Penilaian;
use App\Models\AspekPenilaian;
use App\Models\AkunSiswa;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Add extends Component
{
    public $open = false;

    // langsung terima dari parent
    public $id_akunsiswa;

    // field Penilaian
    public $id_guru;
    public $id_kelas;       // di-set otomatis
    public $kelasNama;      // untuk tampilan
    public $tgl_penilaian;

    // detail NilaiSiswa
    public $id_aspek;
    public $nilai;
    public $skor;

    // data untuk dropdown aspek
    public $aspekGroups = [];

    public $nilaiOptions = [
        'BSB' => 4,
        'BSH' => 3,
        'MB'  => 2,
        'BB'  => 1,
    ];

    public function updatedNilai($value)
    {
        $this->skor = $this->nilaiOptions[$value] ?? null;
    }

    public function mount($id_akunsiswa)
    {
        $this->id_akunsiswa = $id_akunsiswa;

        // set id_guru dari guru yang login
        $user = Auth::guard('guru')->user();
        $this->id_guru = optional($user)->id_guru;

        // ambil data siswa beserta kelas
        $siswa = AkunSiswa::with('kelas')->findOrFail($id_akunsiswa);
        $this->id_kelas  = $siswa->id_kelas;
        $this->kelasNama = $siswa->kelas->namaKelas;

        // hitung umur untuk filter aspek
        $umur = Carbon::parse($siswa->tgl_lahir)->age;

        // muat aspek sesuai umur, plus children
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

    public function save()
    {
        // validasi jika diperlukan
        // $this->validate([
        //     'tgl_penilaian' => 'required|date',
        //     'id_aspek'      => 'required',
        //     'nilai'         => 'required|in:BSB,BSH,MB,BB',
        // ]);

        // simpan header penilaian
        $penilaian = Penilaian::create([
            'id_akunsiswa'  => $this->id_akunsiswa,
            'id_guru'       => $this->id_guru,
            'id_kelas'      => $this->id_kelas,
            'tgl_penilaian' => $this->tgl_penilaian,
        ]);

        // simpan detail nilai
        NilaiSiswa::create([
            'id_penilaian' => $penilaian->id_penilaian,
            'id_aspek'     => $this->id_aspek,
            'nilai'        => $this->nilai,
            'skor'         => $this->skor,
        ]);

        // reset form
        $this->reset(['open','tgl_penilaian','id_aspek','nilai','skor']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.nilai-siswa.add');
    }
}
