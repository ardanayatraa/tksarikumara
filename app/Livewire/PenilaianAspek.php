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
        $this->loadSiswa();
        $this->loadNilai();
    }

    public function updatedSelectedAspek()
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
        if ($this->selectedKelas && $this->selectedAspek) {
            $this->isLoading = true;

            // Reset nilai data
            $this->nilaiData = [];

            // Load nilai untuk semua minggu (1-20)
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
                            $nilai = NilaiSiswa::where('id_penilaian', $penilaian->id_penilaian)
                                ->where('indikator_aspek_id', $indikator->id)
                                ->first();

                            if ($nilai) {
                                $this->nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] = $nilai->nilai;
                            }
                        }
                    }
                }
            }

            $this->isLoading = false;
        }
    }

    public function updateNilai($siswaId, $indikatorId, $minggu, $nilai)
    {
        // Validasi nilai (1-4)
        if (!empty($nilai) && !in_array($nilai, ['1', '2', '3', '4'])) {
            return;
        }

        // Update nilai di array
        $this->nilaiData[$siswaId][$indikatorId][$minggu] = $nilai;

        // Auto-save
        if (!empty($nilai)) {
            $this->simpanNilaiIndividual($siswaId, $indikatorId, $minggu, $nilai);
        }
    }

    private function simpanNilaiIndividual($siswaId, $indikatorId, $minggu, $nilai)
    {
        try {
            // Cari atau buat penilaian header
            $penilaian = Penilaian::firstOrCreate([
                'id_akunsiswa' => $siswaId,
                'id_kelas' => $this->selectedKelas,
                'minggu_ke' => $minggu,
                'tahun_ajaran' => $this->tahunAjaran,
                'semester' => $this->semester,
            ], [
                'tanggal_penilaian' => now(),
                'catatan_guru' => '',
            ]);

            // Simpan nilai
            NilaiSiswa::updateOrCreate([
                'id_penilaian' => $penilaian->id_penilaian,
                'indikator_aspek_id' => $indikatorId,
            ], [
                'nilai' => $nilai,
                'skor' => (int)$nilai,
                'catatan' => '',
            ]);

            // Flash message untuk auto-save
            session()->flash('saved_' . $siswaId . '_' . $indikatorId . '_' . $minggu, true);

        } catch (\Exception $e) {
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
                        if (isset($this->nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu]) &&
                            !empty($this->nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu])) {

                            $nilai = $this->nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu];

                            // Cari atau buat penilaian header
                            $penilaian = Penilaian::firstOrCreate([
                                'id_akunsiswa' => $siswa->id_akunsiswa,
                                'id_kelas' => $this->selectedKelas,
                                'minggu_ke' => $minggu,
                                'tahun_ajaran' => $this->tahunAjaran,
                                'semester' => $this->semester,
                            ], [
                                'tanggal_penilaian' => now(),
                                'catatan_guru' => '',
                            ]);

                            NilaiSiswa::updateOrCreate([
                                'id_penilaian' => $penilaian->id_penilaian,
                                'indikator_aspek_id' => $indikator->id,
                            ], [
                                'nilai' => $nilai,
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
