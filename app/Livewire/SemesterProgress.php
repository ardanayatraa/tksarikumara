<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\AspekPenilaian;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;

class SemesterProgress extends Component
{
    public $id_akunsiswa;
    public $id_kelas;
    public $tahun_ajaran;
    public $semester = 1;
    public $id_aspek = '';  // Filter aspek
    public $title = 'Progress 1 Semester';

    protected $listeners = [
        'refreshChart' => 'emitChartData'
    ];

    public function mount($id_akunsiswa, $id_kelas = null, $tahun_ajaran = null, $semester = null)
    {
        $this->id_akunsiswa = $id_akunsiswa;

        // Auto-detect jika tidak disediakan
        if (!$id_kelas || !$tahun_ajaran) {
            $siswaData = $this->getSiswaData();
            $this->id_kelas = $id_kelas ?? $siswaData['id_kelas'] ?? null;
            $this->tahun_ajaran = $tahun_ajaran ?? $siswaData['tahun_ajaran'] ?? date('Y') . '/' . (date('Y') + 1);
        } else {
            $this->id_kelas = $id_kelas;
            $this->tahun_ajaran = $tahun_ajaran;
        }

        $this->semester = $semester ?? $this->getCurrentSemester();
    }

    private function getSiswaData()
    {
        $siswa = DB::table('akun_siswa')
            ->where('id_akunsiswa', $this->id_akunsiswa)
            ->first();

        return [
            'id_kelas' => $siswa->id_kelas ?? null,
            'tahun_ajaran' => date('Y') . '/' . (date('Y') + 1)
        ];
    }

    private function getCurrentSemester()
    {
        $bulan = date('n');
        return ($bulan >= 7 && $bulan <= 12) ? 1 : 2;
    }

    // Method untuk mendapatkan daftar aspek penilaian
    public function getAspekOptions()
    {
        return AspekPenilaian::orderBy('kode_aspek')->get();
    }

    public function render(LarapexChart $chart)
    {
        $chartData = $this->getWeeklyScores();

        // Build simple line chart
        $chartObj = $chart->lineChart()
            ->setTitle($this->title)
            ->setSubtitle('Semester ' . $this->semester . ' (' . $this->tahun_ajaran . ')')
            ->setXAxis($chartData['labels'])
            ->addData('Rata-rata Skor', $chartData['scores'])
            ->setColors(['#0d9488'])
            ->setHeight(400)
            ->setMarkers(['#0d9488'], 6, 6);

        return view('livewire.semester-progress', [
            'chart' => $chartObj,
            'aspekOptions' => $this->getAspekOptions()
        ]);
    }

    // Mendapatkan skor per minggu (1-20) dengan filter aspek
    private function getWeeklyScores()
    {
        $labels = [];
        $scores = [];

        // Loop untuk 20 minggu
        for ($minggu = 1; $minggu <= 20; $minggu++) {
            $labels[] = 'Minggu ' . $minggu;

            // Gunakan Eloquent untuk query yang lebih akurat
            $penilaianQuery = Penilaian::where('id_akunsiswa', $this->id_akunsiswa)
                ->where('minggu_ke', $minggu)
                ->where('tahun_ajaran', $this->tahun_ajaran)
                ->where('semester', $this->semester)
                ->when($this->id_kelas, function($q) {
                    $q->where('id_kelas', $this->id_kelas);
                });

            if ($this->id_aspek) {
                // Jika ada filter aspek, ambil nilai siswa untuk aspek tertentu
                $nilaiSiswa = NilaiSiswa::whereIn('id_penilaian', $penilaianQuery->pluck('id_penilaian'))
                    ->where('skor', '>', 0)
                    ->whereHas('indikator', function($q) {
                        $q->where('aspek_id', (int) $this->id_aspek);
                    })
                    ->get();
            } else {
                // Jika tidak ada filter aspek, ambil semua nilai siswa
                $nilaiSiswa = NilaiSiswa::whereIn('id_penilaian', $penilaianQuery->pluck('id_penilaian'))
                    ->where('skor', '>', 0)
                    ->get();
            }

            $avgScore = $nilaiSiswa->isNotEmpty() ? $nilaiSiswa->avg('skor') : 0;
            $scores[] = $avgScore ? round($avgScore, 2) : 0;
        }

        return [
            'labels' => $labels,
            'scores' => $scores
        ];
    }

    // Statistik sederhana
    private function getBasicStats($scores)
    {
        $validScores = array_filter($scores, function($score) {
            return $score > 0;
        });

        if (empty($validScores)) {
            return [
                'minggu_dinilai' => 0,
                'rata_rata' => 0,
                'tertinggi' => 0,
                'terendah' => 0,
                'progress_percent' => 0
            ];
        }

        return [
            'minggu_dinilai' => count($validScores),
            'rata_rata' => round(array_sum($validScores) / count($validScores), 2),
            'tertinggi' => max($validScores),
            'terendah' => min($validScores),
            'progress_percent' => round((count($validScores) / 20) * 100, 1)
        ];
    }

    // Method untuk kontrol
    public function updateSemester($semester)
    {
        $this->semester = $semester;
        $this->emitChartData();
    }

    // Method yang dipanggil ketika filter aspek berubah
    public function updatedIdAspek()
    {
        // Debug: log perubahan aspek
        logger('Aspek changed to: ' . $this->id_aspek);

        // Force re-render component untuk membuat chart baru
        $this->dispatch('forceChartReload');
    }

    public function emitChartData()
    {
        $chartData = $this->getWeeklyScores();

        // Debug: log chart data
        logger('Chart data for aspek ' . $this->id_aspek . ':', $chartData);

        // Kirim event dengan timestamp untuk memastikan uniqueness
        $this->dispatch('semesterChartUpdated', [
            'labels' => $chartData['labels'],
            'data' => $chartData['scores'],
            'aspek_id' => $this->id_aspek,
            'timestamp' => now()->timestamp
        ]);
    }

    // Method untuk debug - bisa dipanggil dari blade
    public function debugQuery()
    {
        $chartData = $this->getWeeklyScores();

        // Cek data penilaian untuk minggu pertama
        $penilaianMinggu1 = Penilaian::where('id_akunsiswa', $this->id_akunsiswa)
            ->where('minggu_ke', 1)
            ->where('tahun_ajaran', $this->tahun_ajaran)
            ->where('semester', $this->semester)
            ->when($this->id_kelas, function($q) {
                $q->where('id_kelas', $this->id_kelas);
            })
            ->with(['nilaiSiswa.indikator.aspek'])
            ->get();

        // Ambil semua nilai siswa untuk aspek tertentu
        $nilaiSiswaFiltered = collect();
        if ($this->id_aspek) {
            foreach ($penilaianMinggu1 as $penilaian) {
                $nilaiFiltered = $penilaian->nilaiSiswa->filter(function($nilai) {
                    return $nilai->indikator && $nilai->indikator->aspek_id == $this->id_aspek && $nilai->skor > 0;
                });
                $nilaiSiswaFiltered = $nilaiSiswaFiltered->merge($nilaiFiltered);
            }
        }

        // Cek semua aspek yang tersedia
        $availableAspeks = collect();
        foreach ($penilaianMinggu1 as $penilaian) {
            foreach ($penilaian->nilaiSiswa as $nilai) {
                if ($nilai->indikator && $nilai->skor > 0) {
                    $availableAspeks->push([
                        'aspek_id' => $nilai->indikator->aspek_id,
                        'aspek_nama' => $nilai->indikator->aspek->nama_aspek ?? 'Unknown',
                        'skor' => $nilai->skor
                    ]);
                }
            }
        }

        dd([
            'aspek_filter' => $this->id_aspek,
            'chart_data' => $chartData,
            'penilaian_minggu_1' => $penilaianMinggu1,
            'nilai_siswa_filtered' => $nilaiSiswaFiltered,
            'available_aspeks' => $availableAspeks->unique('aspek_id')->values(),
            'all_aspeks_with_scores' => $availableAspeks->groupBy('aspek_id')->map(function($group) {
                return [
                    'aspek_nama' => $group->first()['aspek_nama'],
                    'jumlah_nilai' => $group->count(),
                    'rata_rata' => $group->avg('skor')
                ];
            })
        ]);
    }
}
