<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class TopAspectThisWeek extends Component
{
    public $id_akunsiswa;
    public $tahunAjaran;
    public $semester = 1;

    protected $listeners = ['refreshData' => '$refresh'];

    public function mount($id_akunsiswa)
    {
        $this->id_akunsiswa = $id_akunsiswa;
        $this->tahunAjaran = date('Y') . '/' . (date('Y') + 1);
    }

    public function render(LarapexChart $chart)
    {
        // Tentukan rentang tanggal minggu ini
        $start = Carbon::now()->startOfWeek()->toDateString();
        $end = Carbon::now()->endOfWeek()->toDateString();

        // Query data aspek dengan skor rata-rata
        $rows = DB::table('penilaian')
            ->join('nilai_siswa', 'penilaian.id_penilaian', '=', 'nilai_siswa.penilaian_id')
            ->join('indikator', 'nilai_siswa.indikator_id', '=', 'indikator.id_indikator')
            ->join('aspek_penilaian', 'indikator.aspek_id', '=', 'aspek_penilaian.id_aspek')
            ->select(
                'aspek_penilaian.kode_aspek',
                'aspek_penilaian.nama_aspek',
                DB::raw('ROUND(AVG(nilai_siswa.skor), 2) as avg_skor'),
                DB::raw('COUNT(nilai_siswa.skor) as total_penilaian'),
                DB::raw('SUM(CASE WHEN nilai_siswa.nilai IN ("BSB", "BSH") THEN 1 ELSE 0 END) as count_positif')
            )
            ->where('penilaian.id_akunsiswa', $this->id_akunsiswa)
            ->where('penilaian.tahun_ajaran', $this->tahunAjaran)
            ->where('penilaian.semester', $this->semester)
            ->whereBetween('penilaian.tgl_penilaian', [$start, $end])
            ->where('nilai_siswa.skor', '>', 0)
            ->groupBy('aspek_penilaian.id_aspek', 'aspek_penilaian.kode_aspek', 'aspek_penilaian.nama_aspek')
            ->orderByDesc('avg_skor')
            ->limit(8) // Batasi untuk modal
            ->get();

        // Jika tidak ada data minggu ini, ambil data minggu terakhir
        if ($rows->isEmpty()) {
            $rows = $this->getLatestWeekData();
        }

        // Prepare data untuk chart
        $labels = [];
        $data = [];
        $colors = [];
        $detailData = [];

        foreach ($rows as $row) {
            $labels[] = $row->kode_aspek; // Hanya kode aspek untuk label singkat
            $data[] = (float) $row->avg_skor;
            $colors[] = $this->getScoreColor($row->avg_skor);

            $detailData[] = [
                'kode_aspek' => $row->kode_aspek,
                'nama_aspek' => $row->nama_aspek,
                'avg_skor' => $row->avg_skor,
                'total_penilaian' => $row->total_penilaian,
                'persentase_positif' => $row->total_penilaian > 0
                    ? round(($row->count_positif / $row->total_penilaian) * 100, 1)
                    : 0
            ];
        }

        // Buat line chart untuk modal
        if (!empty($data)) {
            $chartObj = $chart->lineChart()
                ->setTitle('')
                ->setXAxis($labels)
                ->addData('Rata-rata Skor', $data)
                ->setColors(['#10B981']) // Single color for line
                ->setHeight(350)
                ->setDataLabels(true)
                ->setMarkers(['#10B981'], 5, 2);
        } else {
            $chartObj = $chart->lineChart()
                ->setTitle('Tidak Ada Data')
                ->setXAxis([''])
                ->addData('Skor', [0])
                ->setHeight(350);
        }

        return view('livewire.top-aspect-this-week', [
            'chart' => $chartObj,
            'detailData' => $detailData,
            'hasData' => !empty($data),
            'totalAspek' => count($data),
            'avgOverall' => !empty($data) ? round(array_sum($data) / count($data), 2) : 0,
            'topScore' => !empty($data) ? max($data) : 0,
            'startDate' => $start,
            'endDate' => $end,
        ]);
    }

    private function getLatestWeekData()
    {
        return DB::table('penilaian')
            ->join('nilai_siswa', 'penilaian.id_penilaian', '=', 'nilai_siswa.penilaian_id')
            ->join('indikator', 'nilai_siswa.indikator_id', '=', 'indikator.id_indikator')
            ->join('aspek_penilaian', 'indikator.aspek_id', '=', 'aspek_penilaian.id_aspek')
            ->select(
                'aspek_penilaian.kode_aspek',
                'aspek_penilaian.nama_aspek',
                DB::raw('ROUND(AVG(nilai_siswa.skor), 2) as avg_skor'),
                DB::raw('COUNT(nilai_siswa.skor) as total_penilaian'),
                DB::raw('SUM(CASE WHEN nilai_siswa.nilai IN ("BSB", "BSH") THEN 1 ELSE 0 END) as count_positif')
            )
            ->where('penilaian.id_akunsiswa', $this->id_akunsiswa)
            ->where('penilaian.tahun_ajaran', $this->tahunAjaran)
            ->where('penilaian.semester', $this->semester)
            ->where('penilaian.tgl_penilaian', '>=', Carbon::now()->subWeeks(2)->toDateString())
            ->where('nilai_siswa.skor', '>', 0)
            ->groupBy('aspek_penilaian.id_aspek', 'aspek_penilaian.kode_aspek', 'aspek_penilaian.nama_aspek')
            ->orderByDesc('avg_skor')
            ->limit(6)
            ->get();
    }

    private function getScoreColor($score)
    {
        if ($score >= 3.5) return '#10B981'; // Green
        if ($score >= 2.5) return '#3B82F6'; // Blue
        if ($score >= 1.5) return '#F59E0B'; // Yellow
        return '#EF4444'; // Red
    }

    public function refreshData()
    {
        $this->dispatch('$refresh');
    }
}
