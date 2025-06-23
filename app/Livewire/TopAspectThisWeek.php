<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class TopAspectThisWeek extends Component
{
    public $id_akunsiswa;
    public $title = 'Rata-rata Skor per Aspek Minggu Ini';

    protected $listeners = ['refreshDatatable' => '$refresh'];

    public function mount($id_akunsiswa)
    {
        $this->id_akunsiswa = $id_akunsiswa;
    }

    public function render(LarapexChart $chart)
    {
        $start = Carbon::now()->startOfWeek()->toDateString();
        $end   = Carbon::now()->endOfWeek()->toDateString();

        $rows = DB::table('penilaian')
            ->join('nilai_siswa', 'penilaian.id_penilaian', '=', 'nilai_siswa.id_penilaian')
            ->join('indikator_aspek', 'nilai_siswa.indikator_aspek_id', '=', 'indikator_aspek.id')
            ->join('aspek_penilaian', 'indikator_aspek.aspek_id', '=', 'aspek_penilaian.id_aspek')
            ->select(
                'aspek_penilaian.nama_aspek',
                DB::raw('ROUND(AVG(nilai_siswa.skor),2) as avg_skor')
            )
            ->where('penilaian.id_akunsiswa', $this->id_akunsiswa)
            ->whereBetween('penilaian.tgl_penilaian', [$start, $end])
            ->groupBy('aspek_penilaian.nama_aspek')
            ->orderByDesc('avg_skor')
            ->get();

        $labels = $rows->pluck('nama_aspek')->toArray();
        $data   = $rows->pluck('avg_skor')->toArray();

        $barChart = $chart->barChart()
            ->setTitle($this->title)
            ->setSubtitle("Minggu: {$start} s.d. {$end}")
            ->setXAxis($labels)
            ->addData('Avg Skor', $data)
            ->setHeight(350);

        return view('livewire.top-aspect-this-week', [
            'chart' => $barChart,
            'title' => $this->title,
        ]);
    }
}
