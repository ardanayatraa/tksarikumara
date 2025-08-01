<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AspekPenilaian;
use App\Models\AkunSiswa;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use App\Models\Kelas;
use App\Models\Indikator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PenilaianAspek extends Component
{
    public $selectedKelas;
    public $selectedAspek;
    public $selectedKelompokUsia;
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

    public $kelompokUsiaOptions = [
        '2-3_tahun' => '2-3 Tahun',
        '3-4_tahun' => '3-4 Tahun',
        '4-5_tahun' => '4-5 Tahun',
        '5-6_tahun' => '5-6 Tahun',
    ];

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
        $this->aspekList = AspekPenilaian::where('is_active', true)->orderBy('kode_aspek')->get();
    }

    public function updatedSelectedKelas()
    {
        $this->loadSiswa();
        $this->loadNilai();
    }

    public function updatedSelectedAspek()
    {
        $this->loadIndikator();
        $this->loadNilai();
    }

    public function updatedSelectedKelompokUsia()
    {
        $this->loadIndikator();
        $this->loadNilai();
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
        if ($this->selectedAspek && $this->selectedKelompokUsia) {
            $this->indikatorList = Indikator::with(['aspekPenilaian', 'subAspek'])
                ->where('aspek_id', $this->selectedAspek)
                ->where('kelompok_usia', $this->selectedKelompokUsia)
                ->where('is_active', true)
                ->orderBy('sub_aspek_id')
                ->orderBy('kode_indikator')
                ->get();
        } else {
            $this->indikatorList = collect();
        }
    }

    public function loadNilai()
    {
        if ($this->selectedKelas && $this->selectedAspek && $this->selectedKelompokUsia) {
            $this->isLoading = true;

            // Reset nilai data untuk mencegah data lama
            $this->nilaiData = [];

            foreach ($this->siswaList as $siswa) {
                foreach ($this->indikatorList as $indikator) {
                    for ($minggu = 1; $minggu <= 20; $minggu++) {
                        // Cari penilaian yang sudah ada
                        $penilaian = Penilaian::where('id_akunsiswa', $siswa->id_akunsiswa)
                            ->where('id_kelas', $this->selectedKelas)
                            ->where('minggu_ke', $minggu)
                            ->where('tahun_ajaran', $this->tahunAjaran)
                            ->where('semester', $this->semester)
                            ->first();

                        if ($penilaian) {
                            $nilai = NilaiSiswa::where('penilaian_id', $penilaian->id_penilaian)
                                ->where('indikator_id', $indikator->id_indikator)
                                ->first();

                            if ($nilai) {
                                // Konversi nilai ke boolean
                                $this->nilaiData[$siswa->id_akunsiswa][$indikator->id_indikator][$minggu] =
                                    in_array($nilai->nilai, ['BSH', 'BSB']) || $nilai->skor >= 3;
                            } else {
                                $this->nilaiData[$siswa->id_akunsiswa][$indikator->id_indikator][$minggu] = false;
                            }
                        } else {
                            $this->nilaiData[$siswa->id_akunsiswa][$indikator->id_indikator][$minggu] = false;
                        }
                    }
                }
            }
            $this->isLoading = false;
        }
    }

    public function toggleNilai($siswaId, $indikatorId, $minggu)
    {
        try {
            // Log untuk debugging
            Log::info('Toggle nilai called', [
                'siswaId' => $siswaId,
                'indikatorId' => $indikatorId,
                'minggu' => $minggu
            ]);

            // Pastikan array sudah diinisialisasi
            if (!isset($this->nilaiData[$siswaId])) {
                $this->nilaiData[$siswaId] = [];
            }
            if (!isset($this->nilaiData[$siswaId][$indikatorId])) {
                $this->nilaiData[$siswaId][$indikatorId] = [];
            }

            // Toggle nilai
            $currentValue = $this->nilaiData[$siswaId][$indikatorId][$minggu] ?? false;
            $newValue = !$currentValue;

            // Update di array
            $this->nilaiData[$siswaId][$indikatorId][$minggu] = $newValue;

            // Log perubahan
            Log::info('Nilai changed', [
                'from' => $currentValue,
                'to' => $newValue
            ]);

            // Auto-save ke database
            $this->simpanNilaiIndividual($siswaId, $indikatorId, $minggu, $newValue);

        } catch (\Exception $e) {
            Log::error('Error in toggleNilai: ' . $e->getMessage(), [
                'siswaId' => $siswaId,
                'indikatorId' => $indikatorId,
                'minggu' => $minggu,
                'trace' => $e->getTraceAsString()
            ]);

            $this->showAlert('Gagal mengubah nilai: ' . $e->getMessage(), 'error');
        }
    }

    private function simpanNilaiIndividual($siswaId, $indikatorId, $minggu, $isChecked)
    {
        try {
            DB::beginTransaction();

            Log::info('Simpan nilai individual', [
                'siswaId' => $siswaId,
                'indikatorId' => $indikatorId,
                'minggu' => $minggu,
                'isChecked' => $isChecked,
                'selectedKelas' => $this->selectedKelas,
                'selectedKelompokUsia' => $this->selectedKelompokUsia
            ]);

            // Validasi data yang diperlukan
            if (!$siswaId || !$indikatorId || !$minggu || !$this->selectedKelas) {
                throw new \Exception('Data tidak lengkap untuk penyimpanan');
            }

            // Cari siswa untuk mendapatkan kelompok usia yang tepat
            $siswa = AkunSiswa::find($siswaId);
            if (!$siswa) {
                throw new \Exception('Siswa tidak ditemukan');
            }

            // Tentukan kelompok usia berdasarkan umur siswa
            $kelompokUsia = $this->selectedKelompokUsia;
            if ($siswa->tgl_lahir) {
                $usia = Carbon::parse($siswa->tgl_lahir)->age;
                if ($usia >= 5) {
                    $kelompokUsia = '5-6_tahun';
                } elseif ($usia >= 4) {
                    $kelompokUsia = '4-5_tahun';
                } elseif ($usia >= 3) {
                    $kelompokUsia = '3-4_tahun';
                } else {
                    $kelompokUsia = '2-3_tahun';
                }
            }

            // Cari atau buat penilaian header
            $penilaian = Penilaian::firstOrCreate([
                'id_akunsiswa' => $siswaId,
                'id_kelas' => $this->selectedKelas,
                'minggu_ke' => $minggu,
                'tahun_ajaran' => $this->tahunAjaran,
                'semester' => $this->semester,
            ], [
                'id_guru' => auth()->id() ?? 1, // Gunakan auth()->id() yang lebih umum
                'tgl_penilaian' => now(),
                'kelompok_usia_siswa' => $kelompokUsia,
                'status' => 'draft',
                'catatan_umum' => '',
            ]);

            Log::info('Penilaian created/found', ['id' => $penilaian->id_penilaian]);

            // Tentukan nilai berdasarkan checkbox
            $nilaiEnum = $isChecked ? 'BSH' : 'BB'; // Berkembang Sesuai Harapan atau Belum Berkembang
            $skor = $isChecked ? 3 : 1; // Langsung set skor tanpa konversi

            // Simpan atau update nilai siswa
            $nilaiSiswa = NilaiSiswa::updateOrCreate([
                'penilaian_id' => $penilaian->id_penilaian,
                'indikator_id' => $indikatorId,
            ], [
                'nilai' => $nilaiEnum,
                'skor' => $skor,
                'catatan' => '',
            ]);

            Log::info('NilaiSiswa saved', [
                'id' => $nilaiSiswa->id_nilai ?? 'new',
                'nilai' => $nilaiEnum,
                'skor' => $skor
            ]);

            DB::commit();

            // Flash message untuk auto-save
            session()->flash('saved_' . $siswaId . '_' . $indikatorId . '_' . $minggu, true);

            // Show success message
            $status = $isChecked ? 'Tercapai (BSH)' : 'Belum Berkembang (BB)';
            $this->showAlert("Nilai berhasil disimpan: {$status}", 'success');

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error simpan nilai individual', [
                'error' => $e->getMessage(),
                'siswaId' => $siswaId,
                'indikatorId' => $indikatorId,
                'minggu' => $minggu,
                'trace' => $e->getTraceAsString()
            ]);

            $this->showAlert('Gagal menyimpan nilai: ' . $e->getMessage(), 'error');

            // Revert nilai di UI
            if (isset($this->nilaiData[$siswaId][$indikatorId][$minggu])) {
                $this->nilaiData[$siswaId][$indikatorId][$minggu] = !$this->nilaiData[$siswaId][$indikatorId][$minggu];
            }
        }
    }

    public function refreshData()
    {
        $this->loadNilai();
        $this->showAlert('Data berhasil direfresh!', 'success');
    }

    public function simpanSemuaNilai()
    {
        if (!$this->selectedKelas || !$this->selectedAspek || !$this->selectedKelompokUsia) {
            $this->showAlert('Silakan pilih kelas, aspek, dan kelompok usia terlebih dahulu!', 'error');
            return;
        }

        DB::beginTransaction();
        try {
            $totalSaved = 0;

            foreach ($this->siswaList as $siswa) {
                foreach ($this->indikatorList as $indikator) {
                    for ($minggu = 1; $minggu <= 20; $minggu++) {
                        if (isset($this->nilaiData[$siswa->id_akunsiswa][$indikator->id_indikator][$minggu])) {
                            $isChecked = $this->nilaiData[$siswa->id_akunsiswa][$indikator->id_indikator][$minggu];

                            // Tentukan kelompok usia
                            $kelompokUsia = $this->selectedKelompokUsia;
                            if ($siswa->tgl_lahir) {
                                $usia = Carbon::parse($siswa->tgl_lahir)->age;
                                if ($usia >= 5) {
                                    $kelompokUsia = '5-6_tahun';
                                } elseif ($usia >= 4) {
                                    $kelompokUsia = '4-5_tahun';
                                } elseif ($usia >= 3) {
                                    $kelompokUsia = '3-4_tahun';
                                } else {
                                    $kelompokUsia = '2-3_tahun';
                                }
                            }

                            $penilaian = Penilaian::firstOrCreate([
                                'id_akunsiswa' => $siswa->id_akunsiswa,
                                'id_kelas' => $this->selectedKelas,
                                'minggu_ke' => $minggu,
                                'tahun_ajaran' => $this->tahunAjaran,
                                'semester' => $this->semester,
                            ], [
                                'id_guru' => auth()->id() ?? 1,
                                'tgl_penilaian' => now(),
                                'kelompok_usia_siswa' => $kelompokUsia,
                                'status' => 'draft',
                                'catatan_umum' => '',
                            ]);

                            $nilaiEnum = $isChecked ? 'BSH' : 'BB';
                            $skor = $isChecked ? 3 : 1;

                            NilaiSiswa::updateOrCreate([
                                'penilaian_id' => $penilaian->id_penilaian,
                                'indikator_id' => $indikator->id_indikator,
                            ], [
                                'nilai' => $nilaiEnum,
                                'skor' => $skor,
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
            Log::error('Error simpan semua nilai: ' . $e->getMessage());
            $this->showAlert('Terjadi kesalahan: ' . $e->getMessage(), 'error');
        }
    }

    private function showAlert($message, $type = 'success')
    {
        $this->alertMessage = $message;
        $this->alertType = $type;
        $this->showAlert = true;

        // Auto hide alert after 3 seconds
        $this->dispatch('hide-alert');
    }

    public function render()
    {
        return view('livewire.penilaian-aspek');
    }
}
