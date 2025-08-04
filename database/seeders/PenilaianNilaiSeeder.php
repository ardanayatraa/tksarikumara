<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AkunSiswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use App\Models\AspekPenilaian;
use App\Models\Indikator;
use Carbon\Carbon;

class PenilaianNilaiSeeder extends Seeder
{
    public function run(): void
    {
        // Get all students, teachers, and classes
        $students = AkunSiswa::all();
        $teachers = Guru::all();
        $classes = Kelas::all();

        // Get all assessment aspects and indicators
        $aspekPenilaian = AspekPenilaian::with('indikator')->get();

        // Define assessment criteria with scoring
        $nilaiKriteria = [
            'BB' => ['nilai' => 'BB', 'skor' => 1, 'deskripsi' => 'Belum Berkembang'],
            'MB' => ['nilai' => 'MB', 'skor' => 2, 'deskripsi' => 'Mulai Berkembang'],
            'BSH' => ['nilai' => 'BSH', 'skor' => 3, 'deskripsi' => 'Berkembang Sesuai Harapan'],
            'BSB' => ['nilai' => 'BSB', 'skor' => 4, 'deskripsi' => 'Berkembang Sangat Baik']
        ];

        // Sample assessment notes for each aspect - UPDATED for TK A and TK B
        $catatanAspek = [
            'I' => [ // Nilai Agama dan Moral
                'BB' => 'Perlu bimbingan dalam memahami nilai-nilai agama dan moral',
                'MB' => 'Mulai menunjukkan pemahaman nilai agama dan moral sederhana',
                'BSH' => 'Dapat melaksanakan kegiatan keagamaan sederhana dengan bimbingan',
                'BSB' => 'Mandiri dalam melaksanakan ibadah dan menunjukkan akhlak yang baik'
            ],
            'II' => [ // Fisik-Motorik
                'BB' => 'Memerlukan bantuan dalam aktivitas motorik kasar dan halus',
                'MB' => 'Mulai dapat melakukan gerakan dasar dengan bimbingan',
                'BSH' => 'Dapat melakukan aktivitas fisik sesuai tahapan usia',
                'BSB' => 'Sangat aktif dan terampil dalam berbagai gerakan motorik'
            ],
            'III' => [ // Kognitif
                'BB' => 'Perlu stimulasi lebih dalam kemampuan berpikir dan memecahkan masalah',
                'MB' => 'Mulai menunjukkan kemampuan berpikir logis sederhana',
                'BSH' => 'Dapat memecahkan masalah sederhana sesuai usianya',
                'BSB' => 'Menunjukkan kemampuan berpikir kritis dan kreatif yang baik'
            ],
            'IV' => [ // Bahasa
                'BB' => 'Masih terbatas dalam berkomunikasi dan memahami bahasa',
                'MB' => 'Mulai dapat mengungkapkan keinginan dengan bahasa sederhana',
                'BSH' => 'Dapat berkomunikasi dengan baik sesuai tahapan usia',
                'BSB' => 'Sangat komunikatif dengan kosakata yang kaya untuk usianya'
            ],
            'V' => [ // Sosial-Emosional
                'BB' => 'Perlu bimbingan dalam berinteraksi sosial dan mengelola emosi',
                'MB' => 'Mulai dapat bermain bersama teman dan menunjukkan empati',
                'BSH' => 'Dapat bersosialisasi dan mengelola emosi dengan baik',
                'BSB' => 'Menunjukkan empati tinggi dan kemampuan kepemimpinan'
            ],
            'VI' => [ // Seni
                'BB' => 'Perlu dorongan untuk berekspresi dalam kegiatan seni',
                'MB' => 'Mulai tertarik dan antusias dengan kegiatan seni',
                'BSH' => 'Dapat mengikuti dan menikmati kegiatan seni dengan baik',
                'BSB' => 'Sangat kreatif dan menunjukkan bakat seni yang menonjol'
            ]
        ];

        // Start date for assessments (current date)
        $startDate = Carbon::now()->startOfWeek();

        // Generate assessments for 20 weeks
        for ($week = 1; $week <= 20; $week++) {
            $assessmentDate = $startDate->copy()->addWeeks($week - 1);

            // Determine semester based on week
            $semester = $week <= 10 ? 1 : 2;
            $tahunAjaran = '2024/2025';

            echo "Generating assessments for Week {$week} ({$assessmentDate->format('Y-m-d')})...\n";

            foreach ($students as $student) {
                // Get student's age to determine appropriate indicators
                $studentAge = Carbon::parse($student->tgl_lahir)->age;

                // Find appropriate teacher for student's class
                $teacher = $teachers->where('id_kelas', $student->id_kelas)->first();
                if (!$teacher) {
                    $teacher = $teachers->first(); // Fallback to first teacher
                }

                // Create assessment record
                $penilaian = Penilaian::create([
                    'id_akunsiswa' => $student->id_akunsiswa,
                    'id_guru' => $teacher->id_guru,
                    'id_kelas' => $student->id_kelas,
                    'tgl_penilaian' => $assessmentDate->format('Y-m-d'),
                    'minggu_ke' => $week,
                    'semester' => $semester,
                    'tahun_ajaran' => $tahunAjaran,
                ]);

                // Generate grades for each aspect and indicator
                foreach ($aspekPenilaian as $aspek) {
                    // Get indicators appropriate for student's kelompok usia
                    $kelompokUsia = $this->getKelompokUsia($studentAge);
                    $indicators = $aspek->indikator->filter(function ($indicator) use ($kelompokUsia) {
                        return $indicator->kelompok_usia === $kelompokUsia;
                    });

                    foreach ($indicators as $indicator) {
                        // Generate realistic progression over weeks
                        $baseScore = $this->calculateProgressiveScore($week, $studentAge, $aspek->kode_aspek, $student->kelas->namaKelas);
                        $scoreKey = $this->getScoreKey($baseScore);
                        $scoreData = $nilaiKriteria[$scoreKey];

                        // Get appropriate note for this aspect and score
                        $aspekKode = explode('.', $aspek->kode_aspek)[0]; // Get main aspect code (I, II, III, etc.)
                        $catatan = $catatanAspek[$aspekKode][$scoreKey] ?? 'Perkembangan sesuai tahapan usia';

                        // Add class-specific context to notes
                        if ($student->kelas->namaKelas === 'TK A') {
                            $catatan .= ' - Tahap awal TK, fokus pada adaptasi dan eksplorasi';
                        } else {
                            $catatan .= ' - Persiapan masuk SD, pengembangan kemandirian';
                        }

                        // Add semester context
                        if ($week > 10) {
                            $catatan .= ' - Menunjukkan kemajuan dari semester sebelumnya';
                        }

                        NilaiSiswa::create([
                            'id_penilaian' => $penilaian->id_penilaian,
                            'indikator_id' => $indicator->id_indikator,
                            'nilai' => $scoreData['nilai'],
                            'skor' => $scoreData['skor'],
                            'catatan' => $catatan,
                        ]);
                    }
                }
            }
        }

        echo "Assessment data generation completed for 20 weeks with TK A and TK B classes!\n";
    }

    /**
     * Calculate progressive score based on week, student characteristics, and class level
     */
    private function calculateProgressiveScore($week, $studentAge, $aspekKode, $className): int
    {
        // Base score influenced by age (older students tend to score higher)
        $ageBonus = max(0, ($studentAge - 2) * 0.3);

        // Class level adjustment (TK B students generally score higher than TK A)
        $classBonus = $className === 'TK B' ? 0.4 : 0.0;

        // Progressive improvement over weeks (students improve over time)
        $weeklyProgress = $week * 0.05;

        // Different aspects develop at different rates
        $aspekMultiplier = $this->getAspekMultiplier($aspekKode);

        // Add some randomness for realistic variation
        $randomFactor = (rand(-10, 15) / 100); // -0.1 to +0.15

        // Calculate base score (1-4 scale)
        $baseScore = 1.5 + $ageBonus + $classBonus + $weeklyProgress + $aspekMultiplier + $randomFactor;

        // Ensure score is within valid range
        return max(1, min(4, round($baseScore)));
    }

    /**
     * Get aspect-specific multiplier for realistic development patterns
     */
    private function getAspekMultiplier($aspekKode): float
    {
        $multipliers = [
            'I' => 0.2,    // Religious/Moral - develops steadily
            'II.A' => 0.3, // Gross Motor - develops quickly in young children
            'II.B' => 0.25, // Fine Motor - develops more gradually
            'II.C' => 0.2, // Health/Safety - develops with guidance
            'III.A' => 0.35, // Learning/Problem Solving - rapid development
            'III.B' => 0.3, // Logical Thinking - steady development
            'III.C' => 0.25, // Symbolic Thinking - gradual development
            'IV.A' => 0.4, // Language Understanding - rapid in early years
            'IV.B' => 0.35, // Language Expression - steady improvement
            'V.A' => 0.25, // Self Awareness - gradual development
            'V.B' => 0.2, // Responsibility - develops with maturity
            'V.C' => 0.3, // Prosocial Behavior - steady development
            'VI.A' => 0.3, // Sound Discrimination - develops well
            'VI.B' => 0.35, // Music/Arts Enthusiasm - often high in children
            'VI.C' => 0.25, // Arts Participation - steady development
        ];

        return $multipliers[$aspekKode] ?? 0.25;
    }

    /**
     * Convert numeric score to grade key
     */
    private function getScoreKey($score): string
    {
        if ($score <= 1.5) return 'BB';
        if ($score <= 2.5) return 'MB';
        if ($score <= 3.5) return 'BSH';
        return 'BSB';
    }

    /**
     * Map student age to kelompok_usia
     */
    private function getKelompokUsia($age): string
    {
        if ($age >= 2 && $age < 3) {
            return '2-3_tahun';
        } elseif ($age >= 3 && $age < 4) {
            return '3-4_tahun';
        } elseif ($age >= 4 && $age < 5) {
            return '4-5_tahun';
        } elseif ($age >= 5 && $age <= 6) {
            return '5-6_tahun';
        } else {
            return '5-6_tahun'; // default
        }
    }
}
