<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AkunSiswa;
use App\Models\AspekPenilaian;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use App\Models\Indikator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DetailPenilaianSiswa extends Component
{
    public $siswaId;
    public $siswa;
    public $tahunAjaran;
    public $semester = 1;

    public $aspekList;
    public $nilaiData = [];

    public $isLoading = false;
    public $showAlert = false;
    public $alertMessage = '';
    public $alertType = 'success';

    public $viewOnly = false; // Mode view only

    public function mount($siswaId, $viewOnly = false)
    {
        $this->siswaId = $siswaId;
        $this->viewOnly = $viewOnly;
        $this->tahunAjaran = date('Y') . '/' . (date('Y') + 1);
        $this->loadSiswa();
        $this->loadAspek();
        $this->loadNilai();
    }

    public function loadSiswa()
    {
        $this->siswa = AkunSiswa::with('kelas')->find($this->siswaId);

        if (!$this->siswa) {
            abort(404, 'Siswa tidak ditemukan');
        }
    }

    public function loadAspek()
    {
        // Load aspek dengan indikator yang aktif, diurutkan berdasarkan kode aspek
        $this->aspekList = AspekPenilaian::with(['indikatorAktif' => function($query) {
            $query->orderBy('kode_indikator');
        }])
        ->aktif()
        ->orderBy('kode_aspek')
        ->get();
    }

    public function loadNilai()
    {
        $this->isLoading = true;

        // Reset nilai data
        $this->nilaiData = [];

        // Load nilai untuk semua aspek dan indikator
        foreach ($this->aspekList as $aspek) {
            foreach ($aspek->indikatorAktif as $indikator) {
                for ($minggu = 1; $minggu <= 20; $minggu++) {
                    // Cari penilaian yang sudah ada
                    $penilaian = Penilaian::where('id_akunsiswa', $this->siswaId)
                        ->where('id_kelas', $this->siswa->id_kelas)
                        ->where('minggu_ke', $minggu)
                        ->where('tahun_ajaran', $this->tahunAjaran)
                        ->where('semester', $this->semester)
                        ->first();

                    if ($penilaian) {
                        $nilai = NilaiSiswa::where('penilaian_id', $penilaian->id_penilaian)
                            ->where('indikator_id', $indikator->id_indikator)
                            ->first();

                        if ($nilai) {
                            // Menggunakan skor (1-4) sesuai dengan model NilaiSiswa
                            $this->nilaiData[$indikator->id_indikator][$minggu] = $nilai->skor;
                        }
                    }
                }
            }
        }

        $this->isLoading = false;
    }

    public function updateNilai($indikatorId, $minggu, $nilai)
    {
        // Validasi nilai (1-4)
        if (!empty($nilai) && !in_array($nilai, ['1', '2', '3', '4'])) {
            return;
        }

        // Update nilai di array
        $this->nilaiData[$indikatorId][$minggu] = $nilai;

        // Auto-save
        if (!empty($nilai)) {
            $this->simpanNilaiIndividual($indikatorId, $minggu, $nilai);
        }
    }

    private function simpanNilaiIndividual($indikatorId, $minggu, $nilai)
    {
        try {
            // Cari atau buat penilaian header
            $penilaian = Penilaian::firstOrCreate([
                'id_akunsiswa' => $this->siswaId,
                'id_kelas' => $this->siswa->id_kelas,
                'minggu_ke' => $minggu,
                'tahun_ajaran' => $this->tahunAjaran,
                'semester' => $this->semester,
            ], [
                'id_guru' => Auth::id(), // Sesuaikan dengan ID guru yang login
                'tgl_penilaian' => now(),
                'kelompok_usia_siswa' => $this->getKelompokUsiaSiswa(),
                'status' => 'draft',
                'catatan_umum' => '',
            ]);

            // Konversi skor ke nilai sesuai model NilaiSiswa
            $nilaiText = NilaiSiswa::konversiSkorKeNilai((int)$nilai);

            // Simpan nilai
            NilaiSiswa::updateOrCreate([
                'penilaian_id' => $penilaian->id_penilaian,
                'indikator_id' => $indikatorId,
            ], [
                'nilai' => $nilaiText, // BB, MB, BSH, BSB
                'skor' => (int)$nilai,  // 1, 2, 3, 4
                'catatan' => '',
            ]);

            // Flash message untuk auto-save
            session()->flash('saved_' . $indikatorId . '_' . $minggu, true);

        } catch (\Exception $e) {
            $this->showAlert('Gagal menyimpan nilai: ' . $e->getMessage(), 'error');
        }
    }

    public function simpanSemua()
    {
        DB::beginTransaction();
        try {
            $totalSaved = 0;

            foreach ($this->aspekList as $aspek) {
                foreach ($aspek->indikatorAktif as $indikator) {
                    for ($minggu = 1; $minggu <= 20; $minggu++) {
                        if (isset($this->nilaiData[$indikator->id_indikator][$minggu]) &&
                            !empty($this->nilaiData[$indikator->id_indikator][$minggu])) {

                            $nilai = $this->nilaiData[$indikator->id_indikator][$minggu];

                            // Cari atau buat penilaian header
                            $penilaian = Penilaian::firstOrCreate([
                                'id_akunsiswa' => $this->siswaId,
                                'id_kelas' => $this->siswa->id_kelas,
                                'minggu_ke' => $minggu,
                                'tahun_ajaran' => $this->tahunAjaran,
                                'semester' => $this->semester,
                            ], [
                                'id_guru' => Auth::id(),
                                'tgl_penilaian' => now(),
                                'kelompok_usia_siswa' => $this->getKelompokUsiaSiswa(),
                                'status' => 'draft',
                                'catatan_umum' => '',
                            ]);

                            // Konversi skor ke nilai
                            $nilaiText = NilaiSiswa::konversiSkorKeNilai((int)$nilai);

                            NilaiSiswa::updateOrCreate([
                                'penilaian_id' => $penilaian->id_penilaian,
                                'indikator_id' => $indikator->id_indikator,
                            ], [
                                'nilai' => $nilaiText,
                                'skor' => (int)$nilai,
                                'catatan' => '',
                            ]);

                            $totalSaved++;
                        }
                    }
                }
            }

            DB::commit();
            $this->showAlert("Berhasil menyimpan {$totalSaved} data penilaian!", 'success');

        } catch (\Exception $e) {
            DB::rollback();
            $this->showAlert('Terjadi kesalahan: ' . $e->getMessage(), 'error');
        }
    }

    /**
     * Mendapatkan kelompok usia siswa berdasarkan tanggal lahir
     */
    private function getKelompokUsiaSiswa()
    {
        if (!$this->siswa->tgl_lahir) {
            return '2-3_tahun'; // Default
        }

        $usia = \Carbon\Carbon::parse($this->siswa->tgl_lahir)->age;

        if ($usia >= 3) {
            return '3-4_tahun';
        } else {
            return '2-3_tahun';
        }
    }

    /**
     * Menghitung total nilai untuk suatu aspek
     */
    public function getTotalNilaiAspek($aspek)
    {
        $totalNilaiAspek = 0;
        $hasNilai = false;

        foreach ($aspek->indikatorAktif as $indikator) {
            for ($minggu = 1; $minggu <= 20; $minggu++) {
                if (isset($this->nilaiData[$indikator->id_indikator][$minggu]) &&
                    !empty($this->nilaiData[$indikator->id_indikator][$minggu])) {

                    $nilai = $this->nilaiData[$indikator->id_indikator][$minggu];
                    $totalNilaiAspek += (int) $nilai;
                    $hasNilai = true;
                }
            }
        }

        return $hasNilai ? $totalNilaiAspek : null;
    }

    /**
     * Mendapatkan CSS class untuk nilai berdasarkan skor
     */
    public function getNilaiClass($skor)
    {
        switch ($skor) {
            case '4':
                return 'bg-green-100 text-green-800 font-semibold';
            case '3':
                return 'bg-blue-100 text-blue-800 font-semibold';
            case '2':
                return 'bg-yellow-100 text-yellow-800 font-semibold';
            case '1':
                return 'bg-red-100 text-red-800 font-semibold';
            default:
                return 'bg-white';
        }
    }

    /**
     * Mendapatkan CSS class untuk total nilai aspek
     */
    public function getTotalNilaiClass($totalNilai)
    {
        if ($totalNilai >= 240) {
            return 'bg-green-100 text-green-800 border-2 border-green-300';
        } elseif ($totalNilai >= 160) {
            return 'bg-blue-100 text-blue-800 border-2 border-blue-300';
        } elseif ($totalNilai >= 80) {
            return 'bg-yellow-100 text-yellow-800 border-2 border-yellow-300';
        } else {
            return 'bg-red-100 text-red-800 border-2 border-red-300';
        }
    }

    private function showAlert($message, $type = 'success')
    {
        $this->alertMessage = $message;
        $this->alertType = $type;
        $this->showAlert = true;

        // Auto hide after 3 seconds
        $this->dispatch('hide-alert');
    }

    public function render()
    {
        return view('livewire.detail-penilaian-siswa');
    }
}
