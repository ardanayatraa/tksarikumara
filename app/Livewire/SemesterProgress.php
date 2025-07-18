<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class SemesterProgress extends Component
{
    public $id_akunsiswa;
    public $id_kelas;
    public $tahun_ajaran;
    public $semester = 1;
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
            'chart' => $chartObj
        ]);
    }

    // Mendapatkan skor per minggu (1-20)
    private function getWeeklyScores()
    {
        $labels = [];
        $scores = [];

        // Loop untuk 20 minggu
        for ($minggu = 1; $minggu <= 20; $minggu++) {
            $labels[] = 'Minggu ' . $minggu;

            // Query rata-rata skor per minggu
            $avgScore = DB::table('penilaian')
                ->join('nilai_siswa', 'penilaian.id_penilaian', '=', 'nilai_siswa.id_penilaian')
                ->where('penilaian.id_akunsiswa', $this->id_akunsiswa)
                ->where('penilaian.minggu_ke', $minggu)
                ->where('penilaian.tahun_ajaran', $this->tahun_ajaran)
                ->where('penilaian.semester', $this->semester)
                ->where('nilai_siswa.skor', '>', 0)
                ->when($this->id_kelas, function($q) {
                    $q->where('penilaian.id_kelas', $this->id_kelas);
                })
                ->avg('nilai_siswa.skor');

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

    public function emitChartData()
    {
        $chartData = $this->getWeeklyScores();

        $this->dispatch('semesterChartUpdated', [
            'labels' => $chartData['labels'],
            'data' => $chartData['scores']
        ]);
    }
}
