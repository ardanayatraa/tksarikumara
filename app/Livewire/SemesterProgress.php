<?php

namespace App\Livewire;

use Livewire\Component;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\AspekPenilaian;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use App\Models\AkunSiswa;
use Carbon\Carbon;

class SemesterProgress extends Component
{
    public $id_akunsiswa;
    public $id_kelas;
    public $tahun_ajaran;
    public $semester = 1;
    public $id_aspek = '';
    public $kelompok_usia = '';

    protected $listeners = ['refreshChart' => 'emitChartData'];

    public function mount($id_akunsiswa, $id_kelas = null, $tahun_ajaran = null, $semester = null)
    {
        $this->id_akunsiswa = $id_akunsiswa;
        $this->id_kelas = $id_kelas;
        $this->tahun_ajaran = $tahun_ajaran ?? date('Y') . '/' . (date('Y') + 1);
        $this->semester = $semester ?? $this->getCurrentSemester();
    }

    private function getCurrentSemester()
    {
        return (date('n') >= 7 && date('n') <= 12) ? 1 : 2;
    }

    public function getAspekOptions()
    {
        return AspekPenilaian::where('is_active', true)->orderBy('kode_aspek')->get();
    }

    public function getKelompokUsiaOptions()
    {
        return [
            '2-3_tahun' => '2-3 Tahun',
            '3-4_tahun' => '3-4 Tahun',
            '4-5_tahun' => '4-5 Tahun',
            '5-6_tahun' => '5-6 Tahun',
        ];
    }

    public function render(LarapexChart $chart)
    {
        $chartData = $this->getWeeklyScores();
        $stats = $this->getSimpleStats($chartData['scores']);

        $chartObj = $chart->lineChart()
            ->setTitle('')
            ->setXAxis($chartData['labels'])
            ->addData('Rata-rata Skor', $chartData['scores'])
            ->setColors(['#3b82f6'])
            ->setHeight(350);

        return view('livewire.semester-progress', [
            'chart' => $chartObj,
            'aspekOptions' => $this->getAspekOptions(),
            'kelompokUsiaOptions' => $this->getKelompokUsiaOptions(),
            'stats' => $stats
        ]);
    }

    private function getWeeklyScores()
    {
        $labels = [];
        $scores = [];

        // Tentukan rentang tanggal semester
        $tahunStart = (int) substr($this->tahun_ajaran, 0, 4);
        if ($this->semester == 1) {
            $startDate = Carbon::create($tahunStart, 7, 1);
            $endDate = Carbon::create($tahunStart, 12, 31);
        } else {
            $startDate = Carbon::create($tahunStart + 1, 1, 1);
            $endDate = Carbon::create($tahunStart + 1, 6, 30);
        }

        // Ambil data penilaian
        $allPenilaian = Penilaian::where('id_akunsiswa', $this->id_akunsiswa)
            ->whereBetween('tgl_penilaian', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->when($this->id_kelas, fn($q) => $q->where('id_kelas', $this->id_kelas))
            ->with(['nilaiSiswa.indikator.aspekPenilaian'])
            ->get();

        // Generate data untuk 20 minggu
        for ($minggu = 1; $minggu <= 20; $minggu++) {
            $labels[] = 'M' . $minggu; // Singkat untuk modal

            $weekStart = $startDate->copy()->addWeeks($minggu - 1);
            $weekEnd = $weekStart->copy()->addWeek()->subDay();

            $weeklyPenilaian = $allPenilaian->filter(function($penilaian) use ($weekStart, $weekEnd) {
                return Carbon::parse($penilaian->tgl_penilaian)->between($weekStart, $weekEnd);
            });

            if ($weeklyPenilaian->isEmpty()) {
                $scores[] = 0;
                continue;
            }

            $totalSkor = 0;
            $jumlahNilai = 0;

            foreach ($weeklyPenilaian as $penilaian) {
                foreach ($penilaian->nilaiSiswa as $nilai) {
                    if ($this->shouldIncludeNilai($nilai)) {
                        $totalSkor += $nilai->skor;
                        $jumlahNilai++;
                    }
                }
            }

            $scores[] = $jumlahNilai > 0 ? round($totalSkor / $jumlahNilai, 2) : 0;
        }

        return ['labels' => $labels, 'scores' => $scores];
    }

    private function shouldIncludeNilai($nilai)
    {
        if ($nilai->skor <= 0 || !$nilai->indikator) {
            return false;
        }

        if ($this->id_aspek && $nilai->indikator->aspek_id != $this->id_aspek) {
            return false;
        }

        if ($this->kelompok_usia && $nilai->indikator->kelompok_usia != $this->kelompok_usia) {
            return false;
        }

        return true;
    }

    private function getSimpleStats($scores)
    {
        $validScores = array_filter($scores, fn($score) => $score > 0);

        if (empty($validScores)) {
            return [
                'minggu_dinilai' => 0,
                'rata_rata' => 0,
                'progress_percent' => 0
            ];
        }

        return [
            'minggu_dinilai' => count($validScores),
            'rata_rata' => round(array_sum($validScores) / count($validScores), 2),
            'progress_percent' => round((count($validScores) / 20) * 100, 1)
        ];
    }

    public function updatedIdAspek()
    {
        $this->dispatch('forceChartReload');
    }

    public function updatedKelompokUsia()
    {
        $this->dispatch('forceChartReload');
    }

    public function emitChartData()
    {
        $chartData = $this->getWeeklyScores();

        $this->dispatch('semesterChartUpdated', [
            'labels' => $chartData['labels'],
            'data' => $chartData['scores'],
            'aspek_id' => $this->id_aspek,
            'kelompok_usia' => $this->kelompok_usia,
            'timestamp' => now()->timestamp
        ]);
    }
}
