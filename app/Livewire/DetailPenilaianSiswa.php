<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AkunSiswa;
use App\Models\AspekPenilaian;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use Illuminate\Support\Facades\DB;

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
        $this->aspekList = AspekPenilaian::with('indikator')->orderBy('kode_aspek')->get();
    }

    public function loadNilai()
    {
        $this->isLoading = true;

        // Reset nilai data
        $this->nilaiData = [];

        // Load nilai untuk semua aspek dan indikator
        foreach ($this->aspekList as $aspek) {
            foreach ($aspek->indikator as $indikator) {
                for ($minggu = 1; $minggu <= 20; $minggu++) {
                    // Cari penilaian yang sudah ada
                    $penilaian = Penilaian::where('id_akunsiswa', $this->siswaId)
                        ->where('id_kelas', $this->siswa->id_kelas)
                        ->where('minggu_ke', $minggu)
                        ->where('tahun_ajaran', $this->tahunAjaran)
                        ->where('semester', $this->semester)
                        ->first();

                    if ($penilaian) {
                        $nilai = NilaiSiswa::where('id_penilaian', $penilaian->id_penilaian)
                            ->where('indikator_aspek_id', $indikator->id)
                            ->first();

                        if ($nilai) {
                            $this->nilaiData[$indikator->id][$minggu] = $nilai->nilai;
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
                foreach ($aspek->indikator as $indikator) {
                    for ($minggu = 1; $minggu <= 20; $minggu++) {
                        if (isset($this->nilaiData[$indikator->id][$minggu]) &&
                            !empty($this->nilaiData[$indikator->id][$minggu])) {

                            $nilai = $this->nilaiData[$indikator->id][$minggu];

                            // Cari atau buat penilaian header
                            $penilaian = Penilaian::firstOrCreate([
                                'id_akunsiswa' => $this->siswaId,
                                'id_kelas' => $this->siswa->id_kelas,
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
        return view('livewire.detail-penilaian-siswa');
    }
}
