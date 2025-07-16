<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AkunSiswa;
use App\Models\Penilaian;
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
            // Reset to first week when year/month changes
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

                // Adjust if week extends beyond the month
                if ($weekEnd->gt($endOfMonth)) {
                    $weekEnd = $endOfMonth;
                }

                // Only include weeks that have days in the current month
                if ($weekStart->month == $this->month || $weekEnd->month == $this->month) {
                    // Adjust start date if it's before the month
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

        // Calculate which week of the month we're in
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

        $this->records = Penilaian::query()
            ->where('penilaian.id_akunsiswa', $this->id_akunsiswa)
            ->where('penilaian.minggu_ke', $this->week)
            ->whereYear('penilaian.tgl_penilaian', $this->year)
            ->whereMonth('penilaian.tgl_penilaian', $this->month)
            ->join('nilai_siswa', 'penilaian.id_penilaian', '=', 'nilai_siswa.id_penilaian')
            ->join('indikator_aspek', 'nilai_siswa.indikator_aspek_id', '=', 'indikator_aspek.id')
            ->join('aspek_penilaian', 'indikator_aspek.aspek_id', '=', 'aspek_penilaian.id_aspek')
            ->select([
                'penilaian.tgl_penilaian',
                'penilaian.minggu_ke',
                'aspek_penilaian.kode_aspek',
                'aspek_penilaian.nama_aspek',
                'aspek_penilaian.kategori',
                'indikator_aspek.kode_indikator',
                'indikator_aspek.nama_indikator',
                'nilai_siswa.nilai',
                'nilai_siswa.skor',
            ])
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
                    'skor_total' => 0,
                ];
            }

            // Hindari duplikasi indikator
            if (!in_array($r['nama_indikator'], $grouped[$kode]['indikator'])) {
                $grouped[$kode]['indikator'][] = $r['nama_indikator'];
            }

            // Jumlahkan skor (bukan rata-rata)
            $grouped[$kode]['skor_total'] += $r['skor'];
        }

        return collect($grouped)->map(function ($item) {
            // Skor adalah total, bukan rata-rata
            $item['skor'] = $item['skor_total'];
            unset($item['skor_total']);
            return $item;
        })->values()->toArray();
    }

    public function sendEmail()
    {
        $this->validate();

        $student = AkunSiswa::findOrFail($this->id_akunsiswa);

        Mail::to($student->email)
            ->send(new StudentReportMail(
                $student,
                $this->records,
                $this->start,
                $this->end,
                $this->rekap
            ));

        session()->flash('success', 'Email laporan berhasil dikirim.');
        $this->open = false;
    }

    public function downloadReport()
    {
        // Validasi data sebelum generate PDF
        if (!$this->year || !$this->month || !$this->week) {
            session()->flash('error', 'Silakan pilih rentang tanggal yang valid terlebih dahulu.');
            return;
        }

        $student = AkunSiswa::findOrFail($this->id_akunsiswa);

        $summary = [
            'BSB' => collect($this->records)->where('nilai', 'BSB')->count(),
            'BSH' => collect($this->records)->where('nilai', 'BSH')->count(),
            'MB'  => collect($this->records)->where('nilai', 'MB')->count(),
            'BB'  => collect($this->records)->where('nilai', 'BB')->count(),
        ];

        // Array bulan Indonesia
        $monthNames = [
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

        $monthName = $monthNames[$this->month] ?? 'Unknown';

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
            'monthNames' => $monthNames,
            'tahun_ajaran' => '2024/2025', // Tambahkan tahun ajaran
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
