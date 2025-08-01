<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use App\Models\AkunSiswa;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Indikator;
use App\Models\AspekPenilaian;
use Carbon\Carbon;

class PenilaianSeeder extends Seeder
{
    public function run(): void
    {
        // Get all students
        $students = AkunSiswa::with('kelas')->get();

        if ($students->isEmpty()) {
            $this->command->error('No students found. Please run AkunSiswaSeeder first.');
            return;
        }

        // Get all classes
        $classes = Kelas::all();

        if ($classes->isEmpty()) {
            $this->command->error('No classes found. Please run KelasSeeder first.');
            return;
        }

        // Get a teacher for the assessments (assuming you have a User model for teachers)
        // If you have a separate Guru model, adjust accordingly
        $guruId = 1; // Default guru ID, adjust as needed

        // Get all active indicators grouped by aspect
        $indikatorsByAspek = Indikator::aktif()
            ->with(['aspekPenilaian'])
            ->get()
            ->groupBy('aspek_id');

        if ($indikatorsByAspek->isEmpty()) {
            $this->command->error('No active indicators found. Please run IndikatorSeeder first.');
            return;
        }

        // Current semester and academic year
        $semester = 1;
        $tahunAjaran = date('Y') . '/' . (date('Y') + 1);

        $totalCreated = 0;
        $totalStudents = $students->count();

        // For each student
        foreach ($students as $index => $student) {
            $kelas = $student->kelas;

            if (!$kelas) {
                $this->command->warn("Student {$student->namaSiswa} has no assigned class. Skipping...");
                continue;
            }

            // Determine student's age group
            $studentAge = $student->tgl_lahir ? Carbon::parse($student->tgl_lahir)->age : 3;
            $kelompokUsia = $studentAge >= 3 ? '3-4_tahun' : '2-3_tahun';

            // For each week in a semester (typically 20 weeks)
            for ($minggu = 1; $minggu <= 20; $minggu++) {
                // Create assessments more frequently at the beginning and end of semester
                $shouldCreateAssessment = $this->shouldCreateAssessmentForWeek($minggu);

                if (!$shouldCreateAssessment) {
                    continue;
                }

                // Create assessment header
                $penilaian = Penilaian::create([
                    'id_akunsiswa' => $student->id_akunsiswa,
                    'id_guru' => $guruId,
                    'id_kelas' => $kelas->id_kelas,
                    'tgl_penilaian' => Carbon::now()->subWeeks(20 - $minggu),
                    'minggu_ke' => $minggu,
                    'semester' => $semester,
                    'tahun_ajaran' => $tahunAjaran,
                    'kelompok_usia_siswa' => $kelompokUsia,
                    'status' => $this->getAssessmentStatus($minggu),
                    'catatan_umum' => $this->generateGeneralNote($minggu, $student->namaSiswa),
                ]);

                $assessmentCount = 0;

                // For each aspect, randomly select some indicators to assess
                foreach ($indikatorsByAspek as $aspekId => $indikators) {
                    // Filter indicators by age group
                    $ageAppropriateIndikators = $indikators->filter(function ($indikator) use ($kelompokUsia) {
                        return $indikator->kelompok_usia === $kelompokUsia;
                    });

                    // If no age-appropriate indicators, use all indicators from this aspect
                    if ($ageAppropriateIndikators->isEmpty()) {
                        $ageAppropriateIndikators = $indikators;
                    }

                    if ($ageAppropriateIndikators->isEmpty()) {
                        continue;
                    }

                    // Determine how many indicators to assess based on week
                    $maxIndicators = $this->getMaxIndicatorsForWeek($minggu, $ageAppropriateIndikators->count());

                    // Randomly select indicators from this aspect
                    $selectedIndikators = $ageAppropriateIndikators->random(
                        min($maxIndicators, $ageAppropriateIndikators->count())
                    );

                    foreach ($selectedIndikators as $indikator) {
                        // Generate realistic score based on week and student profile
                        $scoreData = $this->generateRealisticScore($minggu, $studentAge, $indikator->aspekPenilaian->kode_aspek);

                        // Create assessment detail
                        NilaiSiswa::create([
                            'penilaian_id' => $penilaian->id_penilaian,
                            'indikator_id' => $indikator->id_indikator,
                            'nilai' => $scoreData['nilai'],
                            'skor' => $scoreData['skor'],
                            'catatan' => $this->generateIndicatorNote(
                                $scoreData['nilai'],
                                $indikator->deskripsi_indikator,
                                $student->namaSiswa
                            ),
                        ]);

                        $assessmentCount++;
                    }
                }

                $totalCreated++;

                // Progress indicator
                if ($totalCreated % 50 === 0) {
                    $progress = round(($index + 1) / $totalStudents * 100, 1);
                    $this->command->info("Progress: {$progress}% - Created {$totalCreated} assessments");
                }
            }

            $this->command->info("✓ Created assessments for student: {$student->namaSiswa} (Class: {$kelas->namaKelas})");
        }

        $this->command->info("Semester assessment data seeded successfully!");
        $this->command->info("Total assessments created: {$totalCreated}");
        $this->command->info("Total students processed: {$totalStudents}");
        $this->command->info("Academic year: {$tahunAjaran}");
        $this->command->info("Semester: {$semester}");
    }

    /**
     * Determine if assessment should be created for specific week
     */
    private function shouldCreateAssessmentForWeek(int $minggu): bool
    {
        // More frequent assessments at beginning and end of semester
        $frequentWeeks = [1, 2, 3, 4, 5, 18, 19, 20]; // First 5 and last 3 weeks
        $regularWeeks = [8, 10, 12, 15]; // Mid-semester assessments
        $occasionalWeeks = [6, 7, 9, 11, 13, 14, 16, 17]; // 30% chance

        if (in_array($minggu, $frequentWeeks)) {
            return true;
        } elseif (in_array($minggu, $regularWeeks)) {
            return true;
        } elseif (in_array($minggu, $occasionalWeeks)) {
            return rand(1, 100) <= 30; // 30% chance
        }

        return false;
    }

    /**
     * Get maximum indicators to assess for a specific week
     */
    private function getMaxIndicatorsForWeek(int $minggu, int $totalIndicators): int
    {
        if ($minggu <= 3) {
            // Early weeks: assess fewer indicators (adaptation period)
            return min(2, $totalIndicators);
        } elseif ($minggu >= 18) {
            // Final weeks: comprehensive assessment
            return min(4, $totalIndicators);
        } else {
            // Regular weeks: moderate assessment
            return min(3, $totalIndicators);
        }
    }

    /**
     * Get assessment status based on week
     */
    private function getAssessmentStatus(int $minggu): string
    {
        if ($minggu <= 15) {
            // 80% chance of finalized for earlier weeks
            return rand(1, 100) <= 80 ? 'final' : 'draft';
        } else {
            // 50% chance of finalized for later weeks (ongoing assessments)
            return rand(1, 100) <= 50 ? 'final' : 'draft';
        }
    }

    /**
     * Generate realistic score based on various factors
     */
    private function generateRealisticScore(int $minggu, int $studentAge, string $aspekKode): array
    {
        // Base score influenced by week progression
        $baseScore = 2.0; // Starting point

        // Weekly progression (gradual improvement)
        $weeklyProgress = ($minggu - 1) * 0.05;

        // Age adjustment
        $ageBonus = ($studentAge - 2) * 0.15;

        // Aspect-specific adjustments
        $aspekAdjustment = $this->getAspekDifficulty($aspekKode);

        // Random variation
        $randomFactor = (rand(-10, 15) / 100);

        // Calculate final score
        $finalScore = $baseScore + $weeklyProgress + $ageBonus + $aspekAdjustment + $randomFactor;

        // Ensure score is within bounds
        $finalScore = max(1.0, min(4.0, $finalScore));

        // Convert to discrete score
        $skor = round($finalScore);

        // Map score to nilai
        $nilaiMapping = [
            1 => 'BB',  // Belum Berkembang
            2 => 'MB',  // Mulai Berkembang
            3 => 'BSH', // Berkembang Sesuai Harapan
            4 => 'BSB'  // Berkembang Sangat Baik
        ];

        return [
            'skor' => $skor,
            'nilai' => $nilaiMapping[$skor]
        ];
    }

    /**
     * Get difficulty adjustment for different aspects
     */
    private function getAspekDifficulty(string $aspekKode): float
    {
        $difficulties = [
            'I' => 0.1,      // Nilai Agama dan Moral - easier
            'II.A' => 0.0,   // Fisik Motorik Kasar - neutral
            'II.B' => -0.1,  // Fisik Motorik Halus - slightly harder
            'II.C' => 0.1,   // Kesehatan - easier
            'III.A' => -0.2, // Kognitif Pembelajaran - harder
            'III.B' => -0.3, // Kognitif Berfikir Logis - hardest
            'III.C' => -0.2, // Kognitif Berfikir Simbolik - harder
            'IV.A' => 0.0,   // Bahasa Memahami - neutral
            'IV.B' => -0.1,  // Bahasa Mengungkapkan - slightly harder
            'V.A' => 0.0,    // Sosial Emosional Kesadaran Diri - neutral
            'V.B' => 0.1,    // Sosial Emosional Tanggung Jawab - easier
            'V.C' => 0.0,    // Sosial Emosional Prososial - neutral
            'VI.A' => 0.2,   // Seni Eksplorasi - easiest
            'VI.B' => 0.1,   // Seni Ekspresi - easy
            'VI.C' => 0.0    // Seni Apresiasi - neutral
        ];

        return $difficulties[$aspekKode] ?? 0.0;
    }

    /**
     * Generate contextual note for indicator assessment
     */
    private function generateIndicatorNote(string $nilai, string $indikatorDeskripsi, string $studentName): string
    {
        $firstName = explode(' ', $studentName)[0];

        // Shorten long indicator descriptions
        $shortIndicator = strlen($indikatorDeskripsi) > 40
            ? substr($indikatorDeskripsi, 0, 37) . '...'
            : $indikatorDeskripsi;

        $noteTemplates = [
            'BB' => [
                "{$firstName} masih memerlukan bimbingan dalam {$shortIndicator}.",
                "{$firstName} belum menunjukkan kemampuan {$shortIndicator} secara konsisten.",
                "Perlu pendampingan lebih intensif untuk {$shortIndicator}."
            ],
            'MB' => [
                "{$firstName} mulai menunjukkan kemajuan dalam {$shortIndicator}.",
                "{$firstName} dapat melakukan {$shortIndicator} dengan bantuan.",
                "Terlihat perkembangan positif dalam {$shortIndicator}."
            ],
            'BSH' => [
                "{$firstName} mampu melakukan {$shortIndicator} dengan baik.",
                "{$firstName} menunjukkan kemampuan {$shortIndicator} sesuai usianya.",
                "Pencapaian {$shortIndicator} sudah sesuai harapan."
            ],
            'BSB' => [
                "{$firstName} menunjukkan kemampuan {$shortIndicator} yang sangat baik.",
                "{$firstName} melampaui ekspektasi dalam {$shortIndicator}.",
                "Kemampuan {$shortIndicator} sangat memuaskan dan dapat menjadi contoh."
            ]
        ];

        $templates = $noteTemplates[$nilai] ?? $noteTemplates['MB'];
        return $templates[array_rand($templates)];
    }

    /**
     * Generate general note for weekly assessment
     */
    private function generateGeneralNote(int $minggu, string $studentName): string
    {
        $firstName = explode(' ', $studentName)[0];

        if ($minggu <= 3) {
            return "{$firstName} sedang dalam tahap adaptasi dan penyesuaian dengan lingkungan belajar.";
        } elseif ($minggu <= 8) {
            return "{$firstName} menunjukkan perkembangan yang stabil dalam berbagai aspek pembelajaran.";
        } elseif ($minggu <= 15) {
            return "{$firstName} aktif mengikuti kegiatan pembelajaran dan menunjukkan kemajuan yang baik.";
        } else {
            return "{$firstName} siap menghadapi evaluasi akhir semester dengan pencapaian yang memuaskan.";
        }
    }
}
