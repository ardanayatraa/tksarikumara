<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class WeeklyProgress extends Component
{
    public $id_akunsiswa;
    public $title = 'Perkembangan Harian Minggu Ini';

    protected $listeners = [
      // jika kamu mau trigger manual via Livewire.emit('refreshChart')
      'refreshChart' => 'emitChartData'
    ];

    public function mount($id_akunsiswa)
    {
        $this->id_akunsiswa = $id_akunsiswa;
    }

    public function render(LarapexChart $chart)
    {
        // initial build
        $chartObj = $chart->lineChart()
            ->setTitle($this->title)
            ->setSubtitle('Skor rata-rata per hari')
            ->setXAxis($this->getLabels())
            ->addData('Skor', $this->getData())
            ->setColors(['#2563EB']);

        return view('livewire.weekly-progress', [
            'chart' => $chartObj,
            'title' => $this->title,
        ]);
    }

    // ambil labels Senin-Minggu
    protected function getLabels(): array
    {
        $start = Carbon::now()->startOfWeek();
        $end   = Carbon::now()->endOfWeek();
        $labels = [];
        for($date = $start; $date->lte($end); $date->addDay()) {
            $labels[] = $date->format('D d M');
        }
        return $labels;
    }

    // ambil data rata-rata per hari
    protected function getData(): array
    {
        $start = Carbon::now()->startOfWeek()->toDateString();
        $end   = Carbon::now()->endOfWeek()->toDateString();

        // Buat array tanggal ke skor, default 0
        $byDay = array_fill(0, 7, 0);

        $rows = DB::table('penilaian')
            ->join('nilai_siswa','penilaian.id_penilaian','=','nilai_siswa.id_penilaian')
            ->selectRaw("DATE(tgl_penilaian) as day, ROUND(AVG(nilai_siswa.skor),2) as avg_skor")
            ->where('penilaian.id_akunsiswa', $this->id_akunsiswa)
            ->whereBetween('penilaian.tgl_penilaian', [$start, $end])
            ->groupBy('day')
            ->get();

        // map rows ke array index 0..6
        $startDate = Carbon::now()->startOfWeek();
        foreach($rows as $r) {
            $i = Carbon::parse($r->day)->diffInDays($startDate);
            if ($i>=0 && $i<7) {
                $byDay[$i] = $r->avg_skor;
            }
        }
        return $byDay;
    }

    // dipanggil dari JS via Livewire.emit('refreshChart')
    public function emitChartData()
    {
        $this->dispatchBrowserEvent('chartDataUpdated', [
            'labels' => $this->getLabels(),
            'data'   => $this->getData(),
        ]);
    }
}
