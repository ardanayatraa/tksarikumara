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

            // Jangan reset nilaiData, tapi preserve yang sudah ada
            $existingData = $this->nilaiData;

            // Load nilai untuk semua minggu (1-20)
            foreach ($this->siswaList as $siswa) {
                foreach ($this->indikatorList as $indikator) {
                    for ($minggu = 1; $minggu <= 20; $minggu++) {
                        // Skip jika data sudah ada di memory (untuk preserve existing state)
                        if (isset($existingData[$siswa->id_akunsiswa][$indikator->id][$minggu])) {
                            $this->nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] =
                                $existingData[$siswa->id_akunsiswa][$indikator->id][$minggu];
                            continue;
                        }

                        // Cari penilaian yang sudah ada di database
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

                            if ($nilai && $nilai->nilai > 0) {
                                $this->nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] = true;
                            } else {
                                $this->nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] = false;
                            }
                        } else {
                            $this->nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] = false;
                        }
                    }
                }
            }
            $this->isLoading = false;
        }
    }

    // Method baru untuk toggle checkbox tanpa wire:model
    public function toggleNilai($siswaId, $indikatorId, $minggu)
    {
        // Toggle nilai
        $currentValue = $this->nilaiData[$siswaId][$indikatorId][$minggu] ?? false;
        $newValue = !$currentValue;

        // Update di array
        $this->nilaiData[$siswaId][$indikatorId][$minggu] = $newValue;

        // Auto-save ke database
        $this->simpanNilaiIndividual($siswaId, $indikatorId, $minggu, $newValue);
    }

    // Method lama tetap ada untuk backward compatibility
    public function updateNilai($siswaId, $indikatorId, $minggu, $isChecked)
    {
        // Update nilai di array tanpa merusak yang lain
        if (!isset($this->nilaiData[$siswaId])) {
            $this->nilaiData[$siswaId] = [];
        }
        if (!isset($this->nilaiData[$siswaId][$indikatorId])) {
            $this->nilaiData[$siswaId][$indikatorId] = [];
        }

        $this->nilaiData[$siswaId][$indikatorId][$minggu] = $isChecked;

        // Auto-save
        $this->simpanNilaiIndividual($siswaId, $indikatorId, $minggu, $isChecked);
    }

    private function simpanNilaiIndividual($siswaId, $indikatorId, $minggu, $isChecked)
    {
        try {
            DB::beginTransaction();

            // Pastikan semua data yang diperlukan ada
            if (!$siswaId || !$indikatorId || !$minggu || !$this->selectedKelas) {
                throw new \Exception('Data tidak lengkap untuk penyimpanan');
            }

            // Ambil bobot indikator
            $indikator = $this->indikatorList->where('id', $indikatorId)->first();
            if (!$indikator) {
                throw new \Exception('Indikator tidak ditemukan');
            }

            $bobotIndikator = $indikator->bobot;

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

            // Simpan atau update nilai siswa
            if ($isChecked) {
                NilaiSiswa::updateOrCreate([
                    'id_penilaian' => $penilaian->id_penilaian,
                    'indikator_aspek_id' => $indikatorId,
                ], [
                    'nilai' => $bobotIndikator,
                    'skor' => $bobotIndikator,
                    'catatan' => '',
                ]);
            } else {
                NilaiSiswa::updateOrCreate([
                    'id_penilaian' => $penilaian->id_penilaian,
                    'indikator_aspek_id' => $indikatorId,
                ], [
                    'nilai' => 0,
                    'skor' => 0,
                    'catatan' => '',
                ]);
            }

            DB::commit();

            // Flash message untuk auto-save
            session()->flash('saved_' . $siswaId . '_' . $indikatorId . '_' . $minggu, true);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error simpan nilai individual: ' . $e->getMessage());
            $this->showAlert('Gagal menyimpan nilai: ' . $e->getMessage(), 'error');
        }
    }

    // Method untuk refresh data tanpa kehilangan state
    public function refreshData()
    {
        $this->loadNilai();
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

                            $penilaian = Penilaian::firstOrCreate([
                                'id_akunsiswa' => $siswa->id_akunsiswa,
                                'id_kelas' => $this->selectedKelas,
                                'minggu_ke' => $minggu,
                                'tahun_ajaran' => $this->tahunAjaran,
                                'semester' => $this->semester,
                            ], [
                                'id_guru' => auth()->guard('guru')->user()->id_guru,
                                'tanggal_penilaian' => now(),
                                'catatan_guru' => '',
                            ]);

                            $bobotIndikator = $indikator->bobot;
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

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error simpan semua nilai: ' . $e->getMessage());
            $this->showAlert('Terjadi kesalahan: ' . $e->getMessage(), 'error');
        }
    }

    private function showAlert($message, $type = 'success')
    {
        $this->alertMessage = $message;
        $this->alertType = $type;
        $this->showAlert = true;
        $this->dispatch('hide-alert');
    }

    public function render()
    {
        return view('livewire.penilaian-aspek');
    }
}


