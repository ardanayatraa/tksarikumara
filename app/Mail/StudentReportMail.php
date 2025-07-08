<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $records;
    public $start;
    public $end;
    public $summary;
    public $rekap;

    /**
     * @param  \App\Models\AkunSiswa  $student
     * @param  array  $records
     * @param  string $start
     * @param  string $end
     * @param  array  $rekap
     */
    public function __construct($student, $records, $start, $end, $rekap)
    {
        $this->student = $student;
        $this->records = $records;
        $this->start   = $start;
        $this->end     = $end;
        $this->rekap   = $rekap;

        // Hitung summary berdasarkan nilai
        $this->summary = [
            'BSB' => collect($records)->where('nilai', 'BSB')->count(),
            'BSH' => collect($records)->where('nilai', 'BSH')->count(),
            'MB'  => collect($records)->where('nilai', 'MB')->count(),
            'BB'  => collect($records)->where('nilai', 'BB')->count(),
        ];
    }

    public function build()
    {
        // Generate PDF attachment
        $pdf = Pdf::loadView('reports.student_report_pdf', [
            'student' => $this->student,
            'records' => $this->records,
            'summary' => $this->summary,
            'rekap'   => $this->rekap,
            'start'   => $this->start,
            'end'     => $this->end,
        ]);

        return $this
            ->subject('Laporan Perkembangan Anak')
            ->view('emails.student-report', [
                'student' => $this->student,
                'records' => $this->records,
                'summary' => $this->summary,
                'rekap'   => $this->rekap,
                'start'   => $this->start,
                'end'     => $this->end,
            ])
            ->attachData($pdf->output(), 'laporan-perkembangan.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
