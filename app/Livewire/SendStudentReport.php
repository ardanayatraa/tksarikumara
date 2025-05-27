<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AkunSiswa;
use App\Models\Penilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentReportMail;

class SendStudentReport extends Component
{
    public $id_akunsiswa, $open = false, $start, $end, $records = [];

    protected $rules = [
        'start' => 'required|date',
        'end'   => 'required|date|after_or_equal:start',
    ];

    public function mount($id_akunsiswa)
    {
        $this->id_akunsiswa = $id_akunsiswa;
        $this->start = now()->startOfWeek()->toDateString();
        $this->end = now()->endOfWeek()->toDateString();
        $this->loadRecords();
    }

    public function updated($field)
    {
        $this->validateOnly($field);
        $this->loadRecords();
    }

    protected function loadRecords()
    {
        $this->records = Penilaian::query()
            ->where('id_akunsiswa', $this->id_akunsiswa)
            ->whereBetween('tgl_penilaian', [$this->start, $this->end])
            ->join('nilai_siswa', 'penilaian.id_penilaian', '=', 'nilai_siswa.id_penilaian')
            ->join('aspek_penilaian', 'nilai_siswa.id_aspek', '=', 'aspek_penilaian.id_aspek')
            ->select('penilaian.tgl_penilaian', 'aspek_penilaian.nama_aspek', 'aspek_penilaian.kategori', 'nilai_siswa.nilai', 'nilai_siswa.skor')
            ->orderBy('tgl_penilaian')
            ->get()
            ->toArray();
    }

    public function sendEmail()
    {
        $this->validate();

        $student = AkunSiswa::findOrFail($this->id_akunsiswa);

        Mail::to($student->email)->send(new StudentReportMail(
            $student, $this->records, $this->start, $this->end
        ));

        session()->flash('success', 'Email laporan berhasil dikirim.');
        $this->open = false;
    }

    // Method download laporan PDF
    public function downloadReport()
    {
        $student = AkunSiswa::findOrFail($this->id_akunsiswa);

        $summary = [
            'BSB' => collect($this->records)->where('skor', 'BSB')->count(),
            'BSH' => collect($this->records)->where('skor', 'BSH')->count(),
            'MB'  => collect($this->records)->where('skor', 'MB')->count(),
            'BB'  => collect($this->records)->where('skor', 'BB')->count(),
        ];

        $pdf = Pdf::loadView('reports.student_report_pdf', [
            'student' => $student,
            'records' => $this->records,
            'summary' => $summary,
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'laporan-perkembangan-'.$student->namaSiswa.'.pdf'
        );
    }

    public function render()
    {
        return view('livewire.send-student-report', [
            'records' => $this->records,
        ]);
    }
}
