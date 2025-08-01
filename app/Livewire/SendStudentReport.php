<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AkunSiswa;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use App\Models\Indikator;
use App\Models\AspekPenilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentReportMail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SendStudentReport extends Component
{
    public $id_akunsiswa;
    public $open = false;
    public $year;
    public $month;
    public $week;
    public $start;
    public $end;
    public $records = [];
    public $rekap = [];
    public $months = [];
    public $weeks = [];
    public $tahunAjaran;
    public $semester = 1;

    protected $rules = [
        'year' => 'required|integer|min:2020|max:2030',
        'month' => 'required|integer|min:1|max:12',
        'week' => 'required|integer|min:1|max:5',
    ];

    public function mount($id_akunsiswa)
    {
        $this->id_akunsiswa = $id_akunsiswa;
        $this->year = now()->year;
        $this->month = now()->month;
        $this->week = $this->getCurrentWeekOfMonth();
        $this->tahunAjaran = date('Y') . '/' . (date('Y') + 1);
        $this->generateMonths();
        $this->generateWeeks();
        $this->updateDateRange();
        $this->loadRecords();
    }

    public function updated($field)
    {
        $this->validateOnly($field);
        if ($field === 'year' || $field === 'month') {
            $this->generateMonths();
            $this->generateWeeks();
            if ($field === 'year' || $field === 'month') {
                $this->week = 1;
            }
        }
        $this->updateDateRange();
        $this->loadRecords();
    }

    protected function generateMonths()
    {
        $this->months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
    }

    protected function generateWeeks()
    {
        $this->weeks = [];
        if ($this->year && $this->month) {
            $startOfMonth = Carbon::createFromDate($this->year, $this->month, 1);
            $endOfMonth = $startOfMonth->copy()->endOfMonth();
            $currentWeek = $startOfMonth->copy()->startOfWeek();
            $weekNumber = 1;

            while ($currentWeek->lte($endOfMonth) && $weekNumber <= 5) {
                $weekStart = $currentWeek->copy();
                $weekEnd = $currentWeek->copy()->endOfWeek();

                if ($weekEnd->gt($endOfMonth)) {
                    $weekEnd = $endOfMonth;
                }

                if ($weekStart->month == $this->month || $weekEnd->month == $this->month) {
                    if ($weekStart->month < $this->month) {
                        $weekStart = $startOfMonth;
                    }

                    $this->weeks[] = [
                        'number' => $weekNumber,
                        'start' => $weekStart->toDateString(),
                        'end' => $weekEnd->toDateString(),
                        'label' => "Minggu ke-{$weekNumber} ({$weekStart->format('d')} - {$weekEnd->format('d M')})"
                    ];
                }
                $currentWeek->addWeek();
                $weekNumber++;
            }
        }
    }

    protected function getCurrentWeekOfMonth()
    {
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $dayOfMonth = $now->day;
        return intval(ceil(($dayOfMonth + $startOfMonth->dayOfWeek - 1) / 7));
    }

    protected function updateDateRange()
    {
        if ($this->year && $this->month && $this->week && isset($this->weeks[$this->week - 1])) {
            $selectedWeek = $this->weeks[$this->week - 1];
            $this->start = $selectedWeek['start'];
            $this->end = $selectedWeek['end'];
        }
    }

    protected function loadRecords()
    {
        if (!$this->start || !$this->end) {
            $this->records = [];
            $this->rekap = [];
            return;
        }

        // Query yang diperbaiki - menggunakan field yang benar-benar ada di model
        $this->records = Penilaian::query()
            ->where('penilaian.id_akunsiswa', $this->id_akunsiswa)
            ->whereBetween('penilaian.tgl_penilaian', [$this->start, $this->end])
            ->join('nilai_siswa', 'penilaian.id_penilaian', '=', 'nilai_siswa.penilaian_id')
            ->join('indikator', 'nilai_siswa.indikator_id', '=', 'indikator.id_indikator')
            ->join('aspek_penilaian', 'indikator.aspek_id', '=', 'aspek_penilaian.id_aspek')
            ->leftJoin('sub_aspek', 'indikator.sub_aspek_id', '=', 'sub_aspek.id_sub_aspek')
            ->select([
                'penilaian.id_penilaian',
                'penilaian.tgl_penilaian',
                'penilaian.kelompok_usia_siswa',
                'penilaian.status',
                'penilaian.catatan_umum',
                'aspek_penilaian.id_aspek',
                'aspek_penilaian.kode_aspek',
                'aspek_penilaian.nama_aspek',
                'sub_aspek.id_sub_aspek',
                'sub_aspek.kode_sub_aspek',
                'sub_aspek.nama_sub_aspek',
                'indikator.id_indikator',
                'indikator.kode_indikator',
                'indikator.deskripsi_indikator as nama_indikator',
                'indikator.kelompok_usia',
                'nilai_siswa.nilai',
                'nilai_siswa.skor',
                'nilai_siswa.catatan',
            ])
            ->orderBy('aspek_penilaian.kode_aspek')
            ->orderBy('sub_aspek.kode_sub_aspek')
            ->orderBy('indikator.kode_indikator')
            ->orderBy('penilaian.tgl_penilaian')
            ->get()
            ->toArray();

        $this->rekap = $this->generateRekap($this->records);
    }

    protected function generateRekap(array $records): array
    {
        $grouped = [];
        foreach ($records as $r) {
            $kode = $r['kode_aspek'];
            $nama = $r['nama_aspek'];

            if (!isset($grouped[$kode])) {
                $grouped[$kode] = [
                    'kode_aspek' => $kode,
                    'nama_aspek' => $nama,
                    'indikator' => [],
                    'sub_aspek' => [],
                    'skor_total' => 0,
                    'jumlah_nilai' => 0,
                    'nilai_bb' => 0,
                    'nilai_mb' => 0,
                    'nilai_bsh' => 0,
                    'nilai_bsb' => 0,
                ];
            }

            // Kumpulkan indikator unik
            $indikatorKey = $r['kode_indikator'] . '.' . $r['nama_indikator'];
            if (!in_array($indikatorKey, $grouped[$kode]['indikator'])) {
                $grouped[$kode]['indikator'][] = $indikatorKey;
            }

            // Kumpulkan sub aspek unik (jika ada)
            if ($r['kode_sub_aspek'] && $r['nama_sub_aspek']) {
                $subAspekKey = $r['kode_sub_aspek'] . '. ' . $r['nama_sub_aspek'];
                if (!in_array($subAspekKey, $grouped[$kode]['sub_aspek'])) {
                    $grouped[$kode]['sub_aspek'][] = $subAspekKey;
                }
            }

            // Jumlahkan skor dan hitung distribusi nilai
            $grouped[$kode]['skor_total'] += $r['skor'];
            $grouped[$kode]['jumlah_nilai']++;

            // Hitung distribusi nilai
            switch ($r['nilai']) {
                case 'BB':
                    $grouped[$kode]['nilai_bb']++;
                    break;
                case 'MB':
                    $grouped[$kode]['nilai_mb']++;
                    break;
                case 'BSH':
                    $grouped[$kode]['nilai_bsh']++;
                    break;
                case 'BSB':
                    $grouped[$kode]['nilai_bsb']++;
                    break;
            }
        }

        return collect($grouped)->map(function ($item) {
            // Hitung skor rata-rata
            $item['skor_rata'] = $item['jumlah_nilai'] > 0
                ? round($item['skor_total'] / $item['jumlah_nilai'], 2)
                : 0;

            // Hitung persentase
            if ($item['jumlah_nilai'] > 0) {
                $item['persentase_bb'] = round(($item['nilai_bb'] / $item['jumlah_nilai']) * 100, 1);
                $item['persentase_mb'] = round(($item['nilai_mb'] / $item['jumlah_nilai']) * 100, 1);
                $item['persentase_bsh'] = round(($item['nilai_bsh'] / $item['jumlah_nilai']) * 100, 1);
                $item['persentase_bsb'] = round(($item['nilai_bsb'] / $item['jumlah_nilai']) * 100, 1);
            } else {
                $item['persentase_bb'] = 0;
                $item['persentase_mb'] = 0;
                $item['persentase_bsh'] = 0;
                $item['persentase_bsb'] = 0;
            }

            // Status perkembangan berdasarkan skor rata-rata
            if ($item['skor_rata'] >= 3.5) {
                $item['status_perkembangan'] = 'Sangat Baik';
                $item['status_color'] = 'success';
            } elseif ($item['skor_rata'] >= 2.5) {
                $item['status_perkembangan'] = 'Baik';
                $item['status_color'] = 'info';
            } elseif ($item['skor_rata'] >= 1.5) {
                $item['status_perkembangan'] = 'Cukup';
                $item['status_color'] = 'warning';
            } else {
                $item['status_perkembangan'] = 'Perlu Perhatian';
                $item['status_color'] = 'danger';
            }

            return $item;
        })->sortBy('kode_aspek')->values()->toArray();
    }

    public function sendEmail()
    {
        $this->validate();
        if (empty($this->records)) {
            session()->flash('error', 'Tidak ada data untuk dikirim.');
            return;
        }

        $student = AkunSiswa::findOrFail($this->id_akunsiswa);
        Mail::to($student->email)
            ->send(new StudentReportMail(
                $student,
                $this->records,
                $this->start,
                $this->end,
                $this->rekap,
                $this->tahunAjaran,
                $this->semester
            ));

        session()->flash('success', 'Email laporan berhasil dikirim.');
        $this->open = false;
    }

    public function downloadReport()
    {
        if (!$this->year || !$this->month || !$this->week) {
            session()->flash('error', 'Silakan pilih rentang tanggal yang valid terlebih dahulu.');
            return;
        }

        if (empty($this->records)) {
            session()->flash('error', 'Tidak ada data untuk di-download.');
            return;
        }

        $student = AkunSiswa::with(['kelas'])->findOrFail($this->id_akunsiswa);

        // Hitung summary nilai
        $summary = [
            'BSB' => collect($this->records)->where('nilai', 'BSB')->count(),
            'BSH' => collect($this->records)->where('nilai', 'BSH')->count(),
            'MB'  => collect($this->records)->where('nilai', 'MB')->count(),
            'BB'  => collect($this->records)->where('nilai', 'BB')->count(),
        ];

        $summary['total'] = array_sum($summary);

        if ($summary['total'] > 0) {
            $summary['persentase_bsb'] = round(($summary['BSB'] / $summary['total']) * 100, 1);
            $summary['persentase_bsh'] = round(($summary['BSH'] / $summary['total']) * 100, 1);
            $summary['persentase_mb'] = round(($summary['MB'] / $summary['total']) * 100, 1);
            $summary['persentase_bb'] = round(($summary['BB'] / $summary['total']) * 100, 1);
        } else {
            $summary['persentase_bsb'] = 0;
            $summary['persentase_bsh'] = 0;
            $summary['persentase_mb'] = 0;
            $summary['persentase_bb'] = 0;
        }

        $monthName = $this->months[$this->month] ?? 'Unknown';
        $pdf = Pdf::loadView('reports.student_report_pdf', [
            'student' => $student,
            'records' => $this->records,
            'summary' => $summary,
            'rekap'   => $this->rekap,
            'start'   => $this->start,
            'end'     => $this->end,
            'year'    => $this->year,
            'month'   => $this->month,
            'week'    => $this->week,
            'monthName' => $monthName,
            'monthNames' => $this->months,
            'tahun_ajaran' => $this->tahunAjaran,
            'semester' => $this->semester,
        ]);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'laporan-perkembangan-' . Str::slug($student->namaSiswa) . '-' . $monthName . '-minggu-' . $this->week . '-' . $this->year . '.pdf'
        );
    }

    public function render()
    {
        return view('livewire.send-student-report', [
            'records' => $this->records,
            'months' => $this->months,
            'weeks' => $this->weeks,
        ]);
    }
}
