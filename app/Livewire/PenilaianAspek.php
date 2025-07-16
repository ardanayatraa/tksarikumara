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

            // Reset nilaiData untuk fresh load
            $this->nilaiData = [];

            // Load semua data penilaian sekaligus dengan query yang lebih efisien
            $allPenilaian = Penilaian::where('id_kelas', $this->selectedKelas)
                ->where('tahun_ajaran', $this->tahunAjaran)
                ->where('semester', $this->semester)
                ->whereIn('id_akunsiswa', $this->siswaList->pluck('id_akunsiswa'))
                ->with(['nilaiSiswa' => function($query) {
                    $query->whereIn('indikator_aspek_id', $this->indikatorList->pluck('id'));
                }])
                ->get()
                ->keyBy(function($item) {
                    return $item->id_akunsiswa . '_' . $item->minggu_ke;
                });

            // Initialize data untuk semua siswa, indikator, dan minggu
            foreach ($this->siswaList as $siswa) {
                foreach ($this->indikatorList as $indikator) {
                    for ($minggu = 1; $minggu <= 20; $minggu++) {
                        $key = $siswa->id_akunsiswa . '_' . $minggu;

                        // Default value
                        $this->nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] = false;

                        // Cek apakah ada penilaian untuk siswa dan minggu tersebut
                        if (isset($allPenilaian[$key])) {
                            $penilaian = $allPenilaian[$key];

                            // Cari nilai untuk indikator ini
                            $nilaiSiswa = $penilaian->nilaiSiswa->where('indikator_aspek_id', $indikator->id)->first();

                            if ($nilaiSiswa && $nilaiSiswa->nilai > 0) {
                                $this->nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] = true;
                            }
                        }
                    }
                }
            }

            $this->isLoading = false;
        }
    }

    public function updateNilai($siswaId, $indikatorId, $minggu, $isChecked)
    {
        // Update nilai di array - pastikan data tidak hilang
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

    public function refreshData()
    {
        // Simpan data yang sudah ada sementara
        $tempData = $this->nilaiData;

        // Load fresh data dari database
        $this->loadNilai();

        // Merge dengan data yang baru diinput user (prioritas ke user input)
        foreach ($tempData as $siswaId => $siswaData) {
            foreach ($siswaData as $indikatorId => $indikatorData) {
                foreach ($indikatorData as $minggu => $nilai) {
                    if (isset($this->nilaiData[$siswaId][$indikatorId][$minggu])) {
                        // Jika ada perubahan dari user yang belum tersimpan, pertahankan
                        $this->nilaiData[$siswaId][$indikatorId][$minggu] = $nilai;
                    }
                }
            }
        }
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

            // Cari atau buat penilaian header - pastikan menggunakan field yang benar
            $penilaian = Penilaian::firstOrCreate([
                'id_akunsiswa' => $siswaId,
                'id_kelas' => $this->selectedKelas,
                'minggu_ke' => $minggu,
                'tahun_ajaran' => $this->tahunAjaran,
                'semester' => $this->semester,
            ], [
                'id_guru' => auth()->guard('guru')->user()->id_guru,
                'tgl_penilaian' => now(), // Gunakan tgl_penilaian, bukan tanggal_penilaian
                'catatan_guru' => '',
            ]);

            // Simpan atau update nilai siswa
            if ($isChecked) {
                // Jika checked, simpan dengan bobot indikator
                NilaiSiswa::updateOrCreate([
                    'id_penilaian' => $penilaian->id_penilaian,
                    'indikator_aspek_id' => $indikatorId,
                ], [
                    'nilai' => $bobotIndikator,
                    'skor' => $bobotIndikator,
                    'catatan' => '',
                ]);
            } else {
                // Jika unchecked, set ke 0
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
                                'tgl_penilaian' => now(), // Gunakan tgl_penilaian, bukan tanggal_penilaian
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
        // Auto hide after 3 seconds
        $this->dispatch('hide-alert');
    }

    public function render()
    {
        return view('livewire.penilaian-aspek');
    }
}
