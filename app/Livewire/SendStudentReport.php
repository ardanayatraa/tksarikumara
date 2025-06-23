<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AkunSiswa;
use App\Models\Penilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentReportMail;
use Illuminate\Support\Str;

class SendStudentReport extends Component
{
    public $id_akunsiswa;
    public $open = false;
    public $start;
    public $end;
    public $records = [];

    protected $rules = [
        'start' => 'required|date',
        'end'   => 'required|date|after_or_equal:start',
    ];

    public function mount($id_akunsiswa)
    {
        $this->id_akunsiswa = $id_akunsiswa;
        $this->start = now()->startOfWeek()->toDateString();
        $this->end   = now()->endOfWeek()->toDateString();
        $this->loadRecords();
    }

    public function updated($field)
    {
        $this->validateOnly($field);
        $this->loadRecords();
    }

    protected function loadRecords()
    {
        // join via indikator_aspek
        $this->records = Penilaian::query()
            ->where('penilaian.id_akunsiswa', $this->id_akunsiswa)
            ->whereBetween('penilaian.tgl_penilaian', [$this->start, $this->end])
            ->join('nilai_siswa', 'penilaian.id_penilaian', '=', 'nilai_siswa.id_penilaian')
            ->join('indikator_aspek', 'nilai_siswa.indikator_aspek_id', '=', 'indikator_aspek.id')
            ->join('aspek_penilaian', 'indikator_aspek.aspek_id', '=', 'aspek_penilaian.id_aspek')
            ->select([
                'penilaian.tgl_penilaian',
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
                $this->end
            ));

        session()->flash('success', 'Email laporan berhasil dikirim.');
        $this->open = false;
    }

    public function downloadReport()
    {
        $student = AkunSiswa::findOrFail($this->id_akunsiswa);

        $summary = [
            'BSB' => collect($this->records)->where('nilai', 'BSB')->count(),
            'BSH' => collect($this->records)->where('nilai', 'BSH')->count(),
            'MB'  => collect($this->records)->where('nilai', 'MB')->count(),
            'BB'  => collect($this->records)->where('nilai', 'BB')->count(),
        ];

        $pdf = Pdf::loadView('reports.student_report_pdf', [
            'student' => $student,
            'records' => $this->records,
            'summary' => $summary,
            'start'   => $this->start,
            'end'     => $this->end,
        ]);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'laporan-perkembangan-' . Str::slug($student->namaSiswa) . '.pdf'  // ← pakai Str::slug
        );
    }

    public function render()
    {
        return view('livewire.send-student-report', [
            'records' => $this->records,
        ]);
    }
}
