<?php

namespace App\Livewire\NilaiSiswa;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AspekPenilaian;
use App\Models\IndikatorAspek;
use App\Models\AkunSiswa;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use Illuminate\Database\Eloquent\Builder;

class PenilaianManager extends Component
{
    use WithPagination;

    public $selectedAspekId;
    public $search = '';
    public $perPage = 10;

    // Bulk mode untuk assessment
    public $bulkMode = false;

    // Current scores untuk real-time update
    public $currentScores = [];

    // Loading states
    public $loadingCells = [];

    protected $paginationTheme = 'bootstrap';

    public $nilaiOptions = [
        'BSB' => 4,
        'BSH' => 3,
        'MB'  => 2,
        'BB'  => 1,
    ];

    public $nilaiLabels = [
        'BSB' => 'Berkembang Sangat Baik',
        'BSH' => 'Berkembang Sesuai Harapan',
        'MB'  => 'Mulai Berkembang',
        'BB'  => 'Belum Berkembang',
    ];

    protected $listeners = [
        'refresh' => '$refresh',
        'showNotification'
    ];

    public function mount()
    {
        $this->loadCurrentScores();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->loadCurrentScores();
    }

    /**
     * Load current scores untuk UI state
     */
    public function loadCurrentScores()
    {
        if (!$this->selectedAspekId) return;

        $this->currentScores = DB::table('nilai_siswa')
            ->join('penilaian', 'nilai_siswa.id_penilaian', '=', 'penilaian.id_penilaian')
            ->join('indikator_aspek', 'nilai_siswa.indikator_aspek_id', '=', 'indikator_aspek.id')
            ->where('indikator_aspek.aspek_id', $this->selectedAspekId)
            ->where('penilaian.tgl_penilaian', today()->toDateString())
            ->select([
                'penilaian.id_akunsiswa as siswa_id',
                'indikator_aspek.id as indikator_id',
                'nilai_siswa.nilai',
                'nilai_siswa.catatan'
            ])
            ->get()
            ->mapWithKeys(function($item) {
                return ["{$item->siswa_id}_{$item->indikator_id}" => [
                    'nilai' => $item->nilai,
                    'catatan' => $item->catatan
                ]];
            })
            ->toArray();
    }

    /**
     * Pilih aspek dan langsung ke assessment
     */
    public function selectAspek($id)
    {
        $this->selectedAspekId = $id;
        $this->search = '';
        $this->resetPage();
        $this->loadCurrentScores();
    }

    /**
     * Kembali ke pilihan aspek
     */
    public function backToAspek()
    {
        $this->selectedAspekId = null;
        $this->search = '';
        $this->bulkMode = false;
        $this->currentScores = [];
        $this->resetPage();
    }

    /**
     * Toggle bulk assessment mode
     */
    public function toggleBulkMode()
    {
        $this->bulkMode = !$this->bulkMode;
        $this->resetPage();
    }

    /**
     * Set nilai untuk indikator tertentu dari siswa tertentu
     */
    public function setNilai($siswaId, $indikatorId, $nilai, $catatan = null)
    {
        $cellKey = "{$siswaId}_{$indikatorId}";
        $this->loadingCells[$cellKey] = true;

        try {
            DB::beginTransaction();

            // Buat atau cari header penilaian hari ini
            $penilaian = Penilaian::firstOrCreate([
                'id_akunsiswa'  => $siswaId,
                'id_guru'       => Auth::guard('guru')->id(),
                'id_kelas'      => AkunSiswa::find($siswaId)->id_kelas,
                'tgl_penilaian' => today()->toDateString(),
            ]);

            // Update atau create nilai siswa untuk indikator ini
            NilaiSiswa::updateOrCreate([
                'id_penilaian'       => $penilaian->id_penilaian,
                'indikator_aspek_id' => $indikatorId,
            ], [
                'nilai'   => $nilai,
                'skor'    => $this->nilaiOptions[$nilai],
                'catatan' => $catatan,
            ]);

            // Update current scores untuk UI
            $this->currentScores[$cellKey] = [
                'nilai' => $nilai,
                'catatan' => $catatan
            ];

            DB::commit();

            // Success notification
            $siswa = AkunSiswa::find($siswaId);
            $indikator = IndikatorAspek::find($indikatorId);

            $this->dispatch('showNotification', [
                'message' => "Nilai {$nilai} untuk {$siswa->namaSiswa} berhasil disimpan",
                'type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            $this->dispatch('showNotification', [
                'message' => 'Gagal menyimpan nilai: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        } finally {
            unset($this->loadingCells[$cellKey]);
        }
    }

    /**
     * Quick fill semua siswa untuk 1 indikator dengan nilai yang sama
     */
    public function quickFillIndikator($indikatorId, $nilai)
    {
        try {
            $siswaList = AkunSiswa::when($this->search, fn(Builder $q) =>
                $q->where('namaSiswa','like',"%{$this->search}%")
                  ->orWhereHas('kelas', fn($q2) =>
                      $q2->where('namaKelas','like',"%{$this->search}%")
                  )
            )->get();

            $count = 0;
            foreach ($siswaList as $siswa) {
                $this->setNilaiQuiet($siswa->id_akunsiswa, $indikatorId, $nilai);
                $count++;
            }

            $this->loadCurrentScores(); // Refresh UI state

            $indikator = IndikatorAspek::find($indikatorId);
            $this->dispatch('showNotification', [
                'message' => "Berhasil mengisi {$count} siswa dengan nilai {$nilai} untuk {$indikator->nama_indikator}",
                'type' => 'success'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('showNotification', [
                'message' => 'Gagal melakukan quick fill: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    /**
     * Quick fill semua indikator untuk 1 siswa dengan nilai yang sama
     */
    public function quickFillSiswa($siswaId, $nilai)
    {
        try {
            $indikatorList = IndikatorAspek::where('aspek_id', $this->selectedAspekId)->get();

            foreach ($indikatorList as $indikator) {
                $this->setNilaiQuiet($siswaId, $indikator->id, $nilai);
            }

            $this->loadCurrentScores(); // Refresh UI state

            $siswa = AkunSiswa::find($siswaId);
            $this->dispatch('showNotification', [
                'message' => "Semua indikator untuk {$siswa->namaSiswa} berhasil diisi dengan nilai {$nilai}",
                'type' => 'success'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('showNotification', [
                'message' => 'Gagal mengisi nilai siswa: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    /**
     * Update catatan saja tanpa mengubah nilai
     */
    public function updateCatatan($siswaId, $indikatorId, $catatan)
    {
        $cellKey = "{$siswaId}_{$indikatorId}";

        // Cek apakah sudah ada nilai
        if (!isset($this->currentScores[$cellKey]['nilai'])) {
            return; // Tidak ada nilai, skip update catatan
        }

        $nilai = $this->currentScores[$cellKey]['nilai'];
        $this->setNilai($siswaId, $indikatorId, $nilai, $catatan);
    }

    /**
     * Set nilai tanpa dispatch event (untuk bulk operations)
     */
    private function setNilaiQuiet($siswaId, $indikatorId, $nilai, $catatan = null)
    {
        $penilaian = Penilaian::firstOrCreate([
            'id_akunsiswa'  => $siswaId,
            'id_guru'       => Auth::guard('guru')->id(),
            'id_kelas'      => AkunSiswa::find($siswaId)->id_kelas,
            'tgl_penilaian' => today()->toDateString(),
        ]);

        NilaiSiswa::updateOrCreate([
            'id_penilaian'       => $penilaian->id_penilaian,
            'indikator_aspek_id' => $indikatorId,
        ], [
            'nilai'   => $nilai,
            'skor'    => $this->nilaiOptions[$nilai],
            'catatan' => $catatan,
        ]);

        // Update current scores
        $cellKey = "{$siswaId}_{$indikatorId}";
        $this->currentScores[$cellKey] = [
            'nilai' => $nilai,
            'catatan' => $catatan
        ];
    }

    /**
     * Get progress untuk aspek saat ini
     */
    public function getProgressAspek()
    {
        if (!$this->selectedAspekId) {
            return ['completed' => 0, 'total' => 0, 'percentage' => 0];
        }

        $siswaCount = AkunSiswa::when($this->search, fn(Builder $q) =>
            $q->where('namaSiswa','like',"%{$this->search}%")
              ->orWhereHas('kelas', fn($q2) =>
                  $q2->where('namaKelas','like',"%{$this->search}%")
              )
        )->count();

        $indikatorCount = IndikatorAspek::where('aspek_id', $this->selectedAspekId)->count();
        $totalAssessments = $siswaCount * $indikatorCount;

        $completedAssessments = DB::table('nilai_siswa')
            ->join('penilaian', 'nilai_siswa.id_penilaian', '=', 'penilaian.id_penilaian')
            ->join('indikator', 'nilai_siswa.indikator_id', '=', 'indikator.id_indikator')
            ->join('akun_siswa', 'penilaian.id_akunsiswa', '=', 'akun_siswa.id_akunsiswa')
            ->where('indikator.aspek_id', $this->selectedAspekId)
            ->where('penilaian.tgl_penilaian', today()->toDateString())
            ->when($this->search, function($q) {
                $q->where(function($subQ) {
                    $subQ->where('akun_siswa.namaSiswa', 'like', "%{$this->search}%")
                         ->orWhereExists(function($kelasQ) {
                             $kelasQ->select(DB::raw(1))
                                    ->from('kelas')
                                    ->whereColumn('kelas.id_kelas', 'akun_siswa.id_kelas')
                                    ->where('kelas.namaKelas', 'like', "%{$this->search}%");
                         });
                });
            })
            ->count();

        $percentage = $totalAssessments > 0 ? round(($completedAssessments / $totalAssessments) * 100) : 0;

        return [
            'completed' => $completedAssessments,
            'total' => $totalAssessments,
            'percentage' => $percentage,
            'siswa_count' => $siswaCount,
            'indikator_count' => $indikatorCount
        ];
    }

    /**
     * Get current score untuk specific cell
     */
    public function getCurrentScore($siswaId, $indikatorId)
    {
        $cellKey = "{$siswaId}_{$indikatorId}";
        return $this->currentScores[$cellKey] ?? ['nilai' => null, 'catatan' => ''];
    }

    /**
     * Check if cell is loading
     */
    public function isCellLoading($siswaId, $indikatorId)
    {
        $cellKey = "{$siswaId}_{$indikatorId}";
        return isset($this->loadingCells[$cellKey]);
    }

    public function render()
    {
        // Mode 1: Pilih Aspek
        if (is_null($this->selectedAspekId)) {
            $aspeks = AspekPenilaian::when($this->search, fn($q) =>
                $q->where('nama_aspek','like',"%{$this->search}%")
                  ->orWhere('kode_aspek','like',"%{$this->search}%")
            )->paginate($this->perPage);

            return view('livewire.nilai-siswa.manager-aspek', compact('aspeks'));
        }

        // Mode 2: Assessment Matrix (Aspek terpilih)
        $aspek = AspekPenilaian::with('indikator')->findOrFail($this->selectedAspekId);

        $siswaQuery = AkunSiswa::with('kelas')
            ->when($this->search, fn(Builder $q) =>
                $q->where('namaSiswa','like',"%{$this->search}%")
                  ->orWhereHas('kelas', fn($q2) =>
                      $q2->where('namaKelas','like',"%{$this->search}%")
                  )
            );

        if ($this->bulkMode) {
            $siswaList = $siswaQuery->get();
        } else {
            $siswaList = $siswaQuery->paginate($this->perPage);
        }

        $indikatorList = $aspek->indikator;
        $progress = $this->getProgressAspek();

        return view('livewire.nilai-siswa.assessment-matrix', compact(
            'aspek',
            'siswaList',
            'indikatorList',
            'progress'
        ));
    }
}
