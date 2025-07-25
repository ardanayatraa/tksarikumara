<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AkunSiswa;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use Illuminate\Support\Facades\DB;

class LaporanPerkembanganSeeder extends Seeder
{
    public function run(): void
    {
        // Create monthly progress reports
        $students = AkunSiswa::with(['penilaian.nilaiSiswa.indikator.aspek'])->get();

        foreach ($students as $student) {
            echo "Generating progress report for {$student->namaSiswa}...\n";

            // Group assessments by month
            $monthlyData = $student->penilaian->groupBy(function($penilaian) {
                return \Carbon\Carbon::parse($penilaian->tgl_penilaian)->format('Y-m');
            });

            foreach ($monthlyData as $month => $assessments) {
                $this->generateMonthlyReport($student, $month, $assessments);
            }
        }

        echo "Monthly progress reports generated successfully!\n";
    }

    private function generateMonthlyReport($student, $month, $assessments)
    {
        $reportData = [
            'student_id' => $student->id_akunsiswa,
            'student_name' => $student->namaSiswa,
            'month' => $month,
            'total_assessments' => $assessments->count(),
            'aspects_summary' => [],
            'overall_progress' => '',
            'recommendations' => []
        ];

        // Calculate average scores by aspect
        $aspectScores = [];

        foreach ($assessments as $assessment) {
            foreach ($assessment->nilaiSiswa as $nilai) {
                $aspectCode = $nilai->indikator->aspek->kode_aspek;
                $aspectName = $nilai->indikator->aspek->nama_aspek;

                if (!isset($aspectScores[$aspectCode])) {
                    $aspectScores[$aspectCode] = [
                        'name' => $aspectName,
                        'scores' => [],
                        'notes' => []
                    ];
                }

                $aspectScores[$aspectCode]['scores'][] = $nilai->skor;
                $aspectScores[$aspectCode]['notes'][] = $nilai->catatan;
            }
        }

        // Calculate averages and generate summary
        foreach ($aspectScores as $code => $data) {
            $average = array_sum($data['scores']) / count($data['scores']);
            $reportData['aspects_summary'][$code] = [
                'name' => $data['name'],
                'average_score' => round($average, 2),
                'grade' => $this->getGradeFromScore($average),
                'trend' => $this->calculateTrend($data['scores'])
            ];
        }

        // Generate overall progress summary
        $overallAverage = collect($reportData['aspects_summary'])->avg('average_score');
        $reportData['overall_progress'] = $this->generateProgressSummary($overallAverage, $student->namaSiswa);

        // Generate recommendations
        $reportData['recommendations'] = $this->generateRecommendations($reportData['aspects_summary'], $student->namaSiswa);

        // Store report (you might want to create a separate table for this)
        // For now, we'll just output the summary
        $this->outputReport($reportData);
    }

    private function getGradeFromScore($score): string
    {
        if ($score <= 1.5) return 'BB';
        if ($score <= 2.5) return 'MB';
        if ($score <= 3.5) return 'BSH';
        return 'BSB';
    }

    private function calculateTrend($scores): string
    {
        if (count($scores) < 2) return 'stable';

        $firstHalf = array_slice($scores, 0, ceil(count($scores) / 2));
        $secondHalf = array_slice($scores, floor(count($scores) / 2));

        $firstAvg = array_sum($firstHalf) / count($firstHalf);
        $secondAvg = array_sum($secondHalf) / count($secondHalf);

        $difference = $secondAvg - $firstAvg;

        if ($difference > 0.3) return 'improving';
        if ($difference < -0.3) return 'declining';
        return 'stable';
    }

    private function generateProgressSummary($overallAverage, $studentName): string
    {
        $firstName = explode(' ', $studentName)[0];

        if ($overallAverage >= 3.5) {
            return "{$firstName} menunjukkan perkembangan yang sangat baik di semua aspek. Kemampuan anak berkembang melebihi harapan untuk usianya.";
        } elseif ($overallAverage >= 2.5) {
            return "{$firstName} berkembang sesuai dengan tahapan usianya. Menunjukkan kemajuan yang konsisten dalam berbagai aspek perkembangan.";
        } elseif ($overallAverage >= 1.5) {
            return "{$firstName} mulai menunjukkan perkembangan dalam berbagai aspek. Perlu dukungan dan stimulasi yang konsisten.";
        } else {
            return "{$firstName} memerlukan perhatian khusus dan bimbingan intensif untuk mendukung perkembangannya.";
        }
    }

    private function generateRecommendations($aspectsSummary, $studentName): array
    {
        $recommendations = [];
        $firstName = explode(' ', $studentName)[0];

        foreach ($aspectsSummary as $code => $data) {
            if ($data['average_score'] < 2.0) {
                $recommendations[] = "Berikan stimulasi tambahan untuk aspek {$data['name']} melalui kegiatan yang menyenangkan dan sesuai minat {$firstName}.";
            } elseif ($data['trend'] === 'declining') {
                $recommendations[] = "Perhatikan perkembangan {$data['name']} yang menunjukkan penurunan. Evaluasi metode pembelajaran dan berikan dukungan ekstra.";
            } elseif ($data['average_score'] >= 3.5 && $data['trend'] === 'improving') {
                $recommendations[] = "Pertahankan dan kembangkan kemampuan {$data['name']} yang sudah sangat baik. {$firstName} dapat menjadi tutor sebaya.";
            }
        }

        // General recommendations
        $recommendations[] = "Lanjutkan komunikasi rutin dengan orang tua untuk mendukung perkembangan {$firstName} di rumah.";
        $recommendations[] = "Dokumentasikan kemajuan {$firstName} melalui portofolio dan observasi berkelanjutan.";

        return $recommendations;
    }

    private function outputReport($reportData)
    {
        echo "\n=== LAPORAN PERKEMBANGAN BULANAN ===\n";
        echo "Nama Siswa: {$reportData['student_name']}\n";
        echo "Bulan: {$reportData['month']}\n";
        echo "Total Penilaian: {$reportData['total_assessments']}\n\n";

        echo "RINGKASAN ASPEK PERKEMBANGAN:\n";
        foreach ($reportData['aspects_summary'] as $code => $data) {
            echo "- {$data['name']}: {$data['grade']} (Skor: {$data['average_score']}) - Trend: {$data['trend']}\n";
        }

        echo "\nRINGKASAN PERKEMBANGAN:\n";
        echo $reportData['overall_progress'] . "\n\n";

        echo "REKOMENDASI:\n";
        foreach ($reportData['recommendations'] as $index => $recommendation) {
            echo ($index + 1) . ". {$recommendation}\n";
        }
        echo "\n" . str_repeat("=", 50) . "\n";
    }
}
