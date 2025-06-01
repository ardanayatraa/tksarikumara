<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student, $records, $start, $end;

    public function __construct($student, $records, $start, $end)
    {
        $this->student = $student;
        $this->records = $records;
        $this->start = $start;
        $this->end = $end;
    }

    public function build()
    {
        $summary = [
            'BSB' => collect($this->records)->where('skor', 'BSB')->count(),
            'BSH' => collect($this->records)->where('skor', 'BSH')->count(),
            'MB'  => collect($this->records)->where('skor', 'MB')->count(),
            'BB'  => collect($this->records)->where('skor', 'BB')->count(),
        ];

        $pdf = Pdf::loadView('reports.student_report_pdf', [
            'student' => $this->student,
            'records' => $this->records,
            'summary' => $summary,
            'start' => $this->start,
            'end' => $this->end,
        ]);

        return $this->subject('Laporan Perkembangan Anak')
                    ->view('emails.student-report')
                    ->attachData($pdf->output(), 'laporan-perkembangan.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
