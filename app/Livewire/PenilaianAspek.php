<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AspekPenilaian;
use App\Models\AkunSiswa;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class PenilaianAspek extends Component
{
    public $selectedKelas;
    public $selectedAspek;
    public $tahunAjaran;
    public $semester = 1;
    public $kelasList;
    public $aspekList;
    public $siswaList;
    public $indikatorList;
    public $nilaiData = [];
    public $isLoading = false;
    public $showAlert = false;
    public $alertMessage = '';
    public $alertType = 'success';

    public function mount()
    {
        $this->tahunAjaran = date('Y') . '/' . (date('Y') + 1);
        $this->kelasList = collect();
        $this->aspekList = collect();
        $this->siswaList = collect();
        $this->indikatorList = collect();
        $this->loadKelas();
        $this->loadAspek();
    }

    public function loadKelas()
    {
        $this->kelasList = Kelas::orderBy('namaKelas')->get();
    }

    public function loadAspek()
    {
        $this->aspekList = AspekPenilaian::orderBy('nama_aspek')->get();
    }

    public function updatedSelectedKelas()
    {
        $this->resetNilaiData();
        $this->loadSiswa();
        if ($this->selectedAspek) {
            $this->loadIndikator();
            $this->loadNilai();
        }
    }

    public function updatedSelectedAspek()
    {
        $this->resetNilaiData();
        $this->loadIndikator();
        if ($this->selectedKelas) {
            $this->loadNilai();
        }
    }

    public function updatedSemester()
    {
        $this->resetNilaiData();
        if ($this->selectedKelas && $this->selectedAspek) {
            $this->loadNilai();
        }
    }

    public function updatedTahunAjaran()
    {
        $this->resetNilaiData();
        if ($this->selectedKelas && $this->selectedAspek) {
            $this->loadNilai();
        }
    }

    private function resetNilaiData()
    {
        $this->nilaiData = [];
    }

    public function loadSiswa()
    {
        if ($this->selectedKelas) {
            $this->siswaList = AkunSiswa::where('id_kelas', $this->selectedKelas)
                ->orderBy('namaSiswa')
                ->get();
        } else {
            $this->siswaList = collect();
        }
    }

    public function loadIndikator()
    {
        if ($this->selectedAspek) {
            $this->indikatorList = AspekPenilaian::find($this->selectedAspek)
                ->indikator()
                ->orderBy('kode_indikator')
                ->get();
        } else {
            $this->indikatorList = collect();
        }
    }

    public function loadNilai()
    {
        if (!$this->selectedKelas || !$this->selectedAspek) {
            return;
        }

        $this->isLoading = true;
        $this->resetNilaiData();

        try {
            // Inisialisasi struktur data untuk semua siswa, indikator, dan minggu
            foreach ($this->siswaList as $siswa) {
                $this->nilaiData[$siswa->id_akunsiswa] = [];
                foreach ($this->indikatorList as $indikator) {
                    $this->nilaiData[$siswa->id_akunsiswa][$indikator->id] = [];
                    for ($minggu = 1; $minggu <= 20; $minggu++) {
                        $this->nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] = false;
                    }
                }
            }

            // Query optimized untuk mengambil semua data penilaian sekaligus
            $penilaianData = DB::table('penilaian as p')
                ->join('nilai_siswa as ns', 'p.id_penilaian', '=', 'ns.id_penilaian')
                ->whereIn('p.id_akunsiswa', $this->siswaList->pluck('id_akunsiswa'))
                ->where('p.id_kelas', $this->selectedKelas)
                ->where('p.tahun_ajaran', $this->tahunAjaran)
                ->where('p.semester', $this->semester)
                ->whereIn('ns.indikator_aspek_id', $this->indikatorList->pluck('id'))
                ->whereBetween('p.minggu_ke', [1, 20])
                ->select(
                    'p.id_akunsiswa',
                    'p.minggu_ke',
                    'ns.indikator_aspek_id',
                    'ns.nilai'
                )
                ->get();

            // Populasi data berdasarkan hasil query
            foreach ($penilaianData as $data) {
                $siswaId = $data->id_akunsiswa;
                $indikatorId = $data->indikator_aspek_id;
                $minggu = $data->minggu_ke;
                $nilai = $data->nilai;

                // Set checkbox checked jika nilai > 0
                if (isset($this->nilaiData[$siswaId][$indikatorId][$minggu])) {
                    $this->nilaiData[$siswaId][$indikatorId][$minggu] = $nilai > 0;
                }
            }

        } catch (\Exception $e) {
            \Log::error('Error load nilai: ' . $e->getMessage());
            $this->showAlert('Gagal memuat data nilai: ' . $e->getMessage(), 'error');
        } finally {
            $this->isLoading = false;
        }
    }

    public function updateNilai($siswaId, $indikatorId, $minggu, $isChecked)
    {
        // Validasi input
        if (!$siswaId || !$indikatorId || !$minggu) {
            $this->showAlert('Data tidak valid', 'error');
            return;
        }

        // Pastikan struktur array ada
        if (!isset($this->nilaiData[$siswaId][$indikatorId][$minggu])) {
            $this->nilaiData[$siswaId][$indikatorId][$minggu] = false;
        }

        // Update nilai di array dengan explicit boolean conversion
        $this->nilaiData[$siswaId][$indikatorId][$minggu] = (bool) $isChecked;

        // Auto-save
        $this->simpanNilaiIndividual($siswaId, $indikatorId, $minggu, $isChecked);
    }

    private function simpanNilaiIndividual($siswaId, $indikatorId, $minggu, $isChecked)
    {
        try {
            DB::beginTransaction();

            // Validasi data
            if (!$siswaId || !$indikatorId || !$minggu || !$this->selectedKelas) {
                throw new \Exception('Data tidak lengkap untuk penyimpanan');
            }

            // Ambil bobot indikator
            $indikator = $this->indikatorList->where('id', $indikatorId)->first();
            if (!$indikator) {
                throw new \Exception('Indikator tidak ditemukan');
            }
            $bobotIndikator = $indikator->bobot ?? 1;

            // Cari atau buat penilaian header
            $penilaian = Penilaian::firstOrCreate([
                'id_akunsiswa' => $siswaId,
                'id_kelas' => $this->selectedKelas,
                'minggu_ke' => $minggu,
                'tahun_ajaran' => $this->tahunAjaran,
                'semester' => $this->semester,
            ], [
                'id_guru' => auth()->guard('guru')->user()->id_guru,
                'tgl_penilaian' => now(),
                'catatan_guru' => '',
            ]);

            // Tentukan nilai berdasarkan status checkbox
            $nilai = $isChecked ? $bobotIndikator : 0;

            // Simpan atau update nilai siswa
            NilaiSiswa::updateOrCreate([
                'id_penilaian' => $penilaian->id_penilaian,
                'indikator_aspek_id' => $indikatorId,
            ], [
                'nilai' => $nilai,
                'skor' => $nilai,
                'catatan' => '',
            ]);

            DB::commit();

            // Flash message untuk feedback visual
            session()->flash('saved_' . $siswaId . '_' . $indikatorId . '_' . $minggu, true);

            // Dispatch event untuk notifikasi
            $this->dispatch('nilai-tersimpan', [
                'siswa' => $siswaId,
                'indikator' => $indikatorId,
                'minggu' => $minggu,
                'status' => $isChecked ? 'checked' : 'unchecked'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error simpan nilai individual: ' . $e->getMessage());

            // Revert nilai di array jika gagal simpan
            if (isset($this->nilaiData[$siswaId][$indikatorId][$minggu])) {
                $this->nilaiData[$siswaId][$indikatorId][$minggu] = !$isChecked;
            }

            $this->showAlert('Gagal menyimpan nilai: ' . $e->getMessage(), 'error');
        }
    }

    public function simpanNilai()
    {
        if (!$this->selectedKelas || !$this->selectedAspek) {
            $this->showAlert('Silakan pilih kelas dan aspek terlebih dahulu!', 'error');
            return;
        }

        DB::beginTransaction();
        try {
            $totalSaved = 0;

            foreach ($this->siswaList as $siswa) {
                foreach ($this->indikatorList as $indikator) {
                    for ($minggu = 1; $minggu <= 20; $minggu++) {
                        if (isset($this->nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu])) {
                            $isChecked = $this->nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu];

                            // Cari atau buat penilaian header
                            $penilaian = Penilaian::firstOrCreate([
                                'id_akunsiswa' => $siswa->id_akunsiswa,
                                'id_kelas' => $this->selectedKelas,
                                'minggu_ke' => $minggu,
                                'tahun_ajaran' => $this->tahunAjaran,
                                'semester' => $this->semester,
                            ], [
                                'id_guru' => auth()->guard('guru')->user()->id_guru,
                                'tgl_penilaian' => now(),
                                'catatan_guru' => '',
                            ]);

                            $bobotIndikator = $indikator->bobot ?? 1;
                            $nilai = $isChecked ? $bobotIndikator : 0;

                            NilaiSiswa::updateOrCreate([
                                'id_penilaian' => $penilaian->id_penilaian,
                                'indikator_aspek_id' => $indikator->id,
                            ], [
                                'nilai' => $nilai,
                                'skor' => $nilai,
                                'catatan' => '',
                            ]);

                            $totalSaved++;
                        }
                    }
                }
            }

            DB::commit();
            $this->showAlert("Berhasil menyimpan {$totalSaved} data penilaian!", 'success');

            // Reload data setelah berhasil simpan
            $this->loadNilai();

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error simpan semua nilai: ' . $e->getMessage());
            $this->showAlert('Terjadi kesalahan: ' . $e->getMessage(), 'error');
        }
    }

    // Helper method untuk cek apakah checkbox harus dicentang
    public function isChecked($siswaId, $indikatorId, $minggu)
    {
        return isset($this->nilaiData[$siswaId][$indikatorId][$minggu])
            && $this->nilaiData[$siswaId][$indikatorId][$minggu] === true;
    }

    // Helper method untuk menghitung rata-rata nilai siswa
    public function getRataRata($siswaId)
    {
        $totalNilai = 0;
        $countNilai = 0;

        foreach ($this->indikatorList as $indikator) {
            for ($minggu = 1; $minggu <= 20; $minggu++) {
                if (isset($this->nilaiData[$siswaId][$indikator->id][$minggu])) {
                    if ($this->nilaiData[$siswaId][$indikator->id][$minggu] === true) {
                        $totalNilai += $indikator->bobot;
                    }
                    $countNilai++;
                }
            }
        }

        return $countNilai > 0 ? $totalNilai / $countNilai : 0;
    }

    // Helper method untuk mendapatkan kelas CSS berdasarkan rata-rata
    public function getRataRataClass($rataRata)
    {
        if ($rataRata >= 3.5) {
            return 'bg-green-100 text-green-800';
        } elseif ($rataRata >= 2.5) {
            return 'bg-blue-100 text-blue-800';
        } elseif ($rataRata >= 1.5) {
            return 'bg-yellow-100 text-yellow-800';
        } else {
            return 'bg-red-100 text-red-800';
        }
    }

    // Helper method untuk debugging (hanya untuk development)
    public function debugNilaiData()
    {
        if (config('app.debug')) {
            return $this->nilaiData;
        }
        return null;
    }

    // Method untuk menangani perubahan semester
    public function changeSemester($semester)
    {
        $this->semester = $semester;
        $this->resetNilaiData();
        if ($this->selectedKelas && $this->selectedAspek) {
            $this->loadNilai();
        }
    }

    // Method untuk export data (jika diperlukan)
    public function exportData()
    {
        // Implementasi export bisa ditambahkan di sini
        $this->showAlert('Fitur export akan segera tersedia', 'info');
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
        return view('livewire.penilaian-aspek');
    }
}
