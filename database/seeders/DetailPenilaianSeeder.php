<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AkunSiswa;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use App\Models\Indikator;
use App\Models\AspekPenilaian;
use Carbon\Carbon;

class DetailPenilaianSeeder extends Seeder
{
    public function run(): void
    {
        // Detailed assessment scenarios for different student profiles
        $studentProfiles = [
            'advanced' => 0.15,    // 15% of students are advanced
            'typical' => 0.70,     // 70% are typical developers
            'needs_support' => 0.15 // 15% need additional support
        ];

        $students = AkunSiswa::all();

        if ($students->isEmpty()) {
            echo "No students found. Please run student seeder first.\n";
            return;
        }

        // Assign profiles to students
        $profiledStudents = [];
        $totalStudents = $students->count();

        $advancedCount = round($totalStudents * $studentProfiles['advanced']);
        $needsSupportCount = round($totalStudents * $studentProfiles['needs_support']);

        $shuffledStudents = $students->shuffle();

        foreach ($shuffledStudents as $index => $student) {
            if ($index < $advancedCount) {
                $profiledStudents[$student->id_akunsiswa] = 'advanced';
            } elseif ($index < $advancedCount + $needsSupportCount) {
                $profiledStudents[$student->id_akunsiswa] = 'needs_support';
            } else {
                $profiledStudents[$student->id_akunsiswa] = 'typical';
            }
        }

        // Get all active indicators
        $indikators = Indikator::aktif()->get();

        if ($indikators->isEmpty()) {
            echo "No active indicators found. Please create indicators first.\n";
            return;
        }

        $tahunAjaran = date('Y') . '/' . (date('Y') + 1);
        $semester = 1;

        // Create assessments for each student
        foreach ($students as $student) {
            $studentProfile = $profiledStudents[$student->id_akunsiswa];
            $studentAge = $student->tgl_lahir ? Carbon::parse($student->tgl_lahir)->age : 3;

            // Determine appropriate age group for indicators
            $kelompokUsia = $studentAge >= 3 ? '3-4_tahun' : '2-3_tahun';

            // Filter indicators by age group
            $ageAppropriateIndicators = $indikators->where('kelompok_usia', $kelompokUsia);

            if ($ageAppropriateIndicators->isEmpty()) {
                // If no age-specific indicators, use all indicators
                $ageAppropriateIndicators = $indikators;
            }

            // Create assessments for 20 weeks
            for ($week = 1; $week <= 20; $week++) {
                // Create or get assessment record
                $penilaian = Penilaian::firstOrCreate([
                    'id_akunsiswa' => $student->id_akunsiswa,
                    'id_kelas' => $student->id_kelas,
                    'minggu_ke' => $week,
                    'tahun_ajaran' => $tahunAjaran,
                    'semester' => $semester,
                ], [
                    'id_guru' => 1, // Assuming first guru ID, adjust as needed
                    'tgl_penilaian' => Carbon::now()->subWeeks(20 - $week),
                    'kelompok_usia_siswa' => $kelompokUsia,
                    'status' => 'draft',
                    'catatan_umum' => $this->generateWeeklyNote($studentProfile, $week)
                ]);

                // Create nilai for each indicator
                foreach ($ageAppropriateIndicators as $indikator) {
                    $existingNilai = NilaiSiswa::where('penilaian_id', $penilaian->id_penilaian)
                        ->where('indikator_id', $indikator->id_indikator)
                        ->first();

                    if (!$existingNilai) {
                        // Calculate realistic score
                        $newScore = $this->calculateRealisticScore(
                            $studentProfile,
                            $week,
                            $studentAge,
                            $indikator->aspekPenilaian->kode_aspek
                        );

                        $scoreKey = $this->getScoreKey($newScore);
                        $scoreData = $this->getNilaiKriteria()[$scoreKey];

                        // Generate detailed, contextual notes
                        $catatan = $this->generateDetailedNote(
                            $studentProfile,
                            $scoreKey,
                            $week,
                            $indikator->deskripsi_indikator,
                            $student->namaSiswa
                        );

                        NilaiSiswa::create([
                            'penilaian_id' => $penilaian->id_penilaian,
                            'indikator_id' => $indikator->id_indikator,
                            'nilai' => $scoreData['nilai'],
                            'skor' => $scoreData['skor'],
                            'catatan' => $catatan,
                        ]);
                    }
                }

                // Randomly finalize some assessments (70% chance for weeks 1-15)
                if ($week <= 15 && rand(1, 100) <= 70) {
                    $penilaian->update(['status' => 'final']);
                }
            }
        }

        echo "Detailed assessment data created successfully!\n";
        echo "Total students processed: " . $students->count() . "\n";
        echo "Total indicators used: " . $indikators->count() . "\n";
        echo "Assessment weeks: 20\n";
        echo "Academic year: " . $tahunAjaran . "\n";
    }

    private function calculateRealisticScore($profile, $week, $age, $aspekKode): int
    {
        // Base scores by profile
        $profileBases = [
            'advanced' => 2.8,
            'typical' => 2.2,
            'needs_support' => 1.6
        ];

        $baseScore = $profileBases[$profile];

        // Age adjustment (older children tend to score higher)
        $ageBonus = ($age - 2) * 0.2;

        // Weekly progression (different rates by profile)
        $progressionRates = [
            'advanced' => 0.08,
            'typical' => 0.06,
            'needs_support' => 0.04
        ];

        $weeklyProgress = $week * $progressionRates[$profile];

        // Aspect-specific adjustments
        $aspekAdjustment = $this->getAspekAdjustment($aspekKode, $profile);

        // Add realistic variation (some randomness)
        $variation = (rand(-8, 12) / 100);

        // Seasonal adjustment (children often perform better mid-semester)
        $seasonalBonus = 0;
        if ($week >= 8 && $week <= 12) {
            $seasonalBonus = 0.1;
        } elseif ($week >= 16 && $week <= 18) {
            $seasonalBonus = 0.15; // End of semester boost
        }

        $finalScore = $baseScore + $ageBonus + $weeklyProgress + $aspekAdjustment + $variation + $seasonalBonus;

        return max(1, min(4, round($finalScore)));
    }

    private function getAspekAdjustment($aspekKode, $profile): float
    {
        // Aspect adjustments based on typical development patterns
        $adjustments = [
            'advanced' => [
                'I' => 0.3,     // Nilai Agama dan Moral
                'II.A' => 0.4,  // Fisik Motorik - Motorik Kasar
                'II.B' => 0.3,  // Fisik Motorik - Motorik Halus
                'II.C' => 0.2,  // Fisik Motorik - Kesehatan
                'III.A' => 0.5, // Kognitif - Pembelajaran
                'III.B' => 0.4, // Kognitif - Berfikir Logis
                'III.C' => 0.3, // Kognitif - Berfikir Simbolik
                'IV.A' => 0.4,  // Bahasa - Memahami Bahasa
                'IV.B' => 0.5,  // Bahasa - Mengungkapkan Bahasa
                'V.A' => 0.3,   // Sosial Emosional - Kesadaran Diri
                'V.B' => 0.2,   // Sosial Emosional - Rasa Tanggung Jawab
                'V.C' => 0.3,   // Sosial Emosional - Perilaku Prososial
                'VI.A' => 0.3,  // Seni - Eksplorasi
                'VI.B' => 0.4,  // Seni - Ekspresi
                'VI.C' => 0.3   // Seni - Apresiasi
            ],
            'typical' => [
                'I' => 0.1, 'II.A' => 0.2, 'II.B' => 0.1, 'II.C' => 0.1,
                'III.A' => 0.2, 'III.B' => 0.1, 'III.C' => 0.1,
                'IV.A' => 0.2, 'IV.B' => 0.2,
                'V.A' => 0.1, 'V.B' => 0.1, 'V.C' => 0.1,
                'VI.A' => 0.1, 'VI.B' => 0.2, 'VI.C' => 0.1
            ],
            'needs_support' => [
                'I' => -0.1, 'II.A' => 0.0, 'II.B' => -0.2, 'II.C' => -0.1,
                'III.A' => -0.2, 'III.B' => -0.3, 'III.C' => -0.2,
                'IV.A' => -0.1, 'IV.B' => -0.2,
                'V.A' => -0.2, 'V.B' => -0.1, 'V.C' => -0.1,
                'VI.A' => 0.0, 'VI.B' => 0.1, 'VI.C' => 0.0
            ]
        ];

        return $adjustments[$profile][$aspekKode] ?? 0;
    }

    private function generateDetailedNote($profile, $scoreKey, $week, $indikatorDeskripsi, $studentName): string
    {
        $firstName = explode(' ', $studentName)[0];

        // Shorten indicator description for readability
        $shortIndicator = strlen($indikatorDeskripsi) > 50
            ? substr($indikatorDeskripsi, 0, 47) . '...'
            : $indikatorDeskripsi;

        $noteTemplates = [
            'advanced' => [
                'BB' => "{$firstName} menunjukkan potensi baik dalam {$shortIndicator}, namun perlu konsistensi lebih.",
                'MB' => "{$firstName} berkembang dengan baik dalam {$shortIndicator} dan menunjukkan antusiasme tinggi.",
                'BSH' => "{$firstName} menguasai {$shortIndicator} dengan sangat baik dan dapat membantu teman lain.",
                'BSB' => "{$firstName} menunjukkan kemampuan luar biasa dalam {$shortIndicator} dan menjadi contoh bagi teman-teman."
            ],
            'typical' => [
                'BB' => "{$firstName} memerlukan bimbingan tambahan dalam {$shortIndicator}.",
                'MB' => "{$firstName} mulai menunjukkan kemajuan dalam {$shortIndicator} dengan bimbingan guru.",
                'BSH' => "{$firstName} dapat melakukan {$shortIndicator} dengan baik sesuai tahapan usianya.",
                'BSB' => "{$firstName} menunjukkan kemampuan yang baik dalam {$shortIndicator}."
            ],
            'needs_support' => [
                'BB' => "{$firstName} memerlukan perhatian khusus dan bimbingan intensif dalam {$shortIndicator}.",
                'MB' => "{$firstName} menunjukkan kemajuan kecil dalam {$shortIndicator} dengan dukungan ekstra.",
                'BSH' => "{$firstName} berhasil mencapai kemajuan yang baik dalam {$shortIndicator} dengan bantuan.",
                'BSB' => "{$firstName} menunjukkan kemajuan menggembirakan dalam {$shortIndicator}."
            ]
        ];

        $baseNote = $noteTemplates[$profile][$scoreKey];

        // Add weekly context
        if ($week <= 5) {
            $baseNote .= " (Tahap adaptasi awal)";
        } elseif ($week <= 10) {
            $baseNote .= " (Semester 1 - perkembangan stabil)";
        } elseif ($week <= 15) {
            $baseNote .= " (Semester 2 - menunjukkan kemajuan)";
        } else {
            $baseNote .= " (Akhir semester - persiapan evaluasi)";
        }

        return $baseNote;
    }

    private function generateWeeklyNote($profile, $week): string
    {
        $weeklyNotes = [
            'advanced' => [
                1 => "Siswa menunjukkan adaptasi yang sangat baik di minggu pertama.",
                5 => "Perkembangan konsisten terlihat di berbagai aspek.",
                10 => "Kemampuan leadership mulai terlihat dalam aktivitas kelompok.",
                15 => "Menunjukkan kemampuan yang melampaui ekspektasi usia.",
                20 => "Siap untuk tantangan yang lebih kompleks."
            ],
            'typical' => [
                1 => "Proses adaptasi berjalan normal sesuai usia.",
                5 => "Mulai menunjukkan kemajuan yang stabil.",
                10 => "Perkembangan sesuai dengan tahapan usia.",
                15 => "Mencapai milestone perkembangan dengan baik.",
                20 => "Menunjukkan kesiapan untuk tahap selanjutnya."
            ],
            'needs_support' => [
                1 => "Memerlukan dukungan ekstra dalam proses adaptasi.",
                5 => "Mulai menunjukkan kemajuan dengan bantuan intensif.",
                10 => "Perkembangan lambat namun konsisten.",
                15 => "Mencapai beberapa milestone dengan bantuan.",
                20 => "Menunjukkan kemajuan yang menggembirakan."
            ]
        ];

        // Find the closest week key
        $availableWeeks = array_keys($weeklyNotes[$profile]);
        $closestWeek = $availableWeeks[0];

        foreach ($availableWeeks as $availableWeek) {
            if ($week >= $availableWeek) {
                $closestWeek = $availableWeek;
            }
        }

        return $weeklyNotes[$profile][$closestWeek];
    }

    private function getScoreKey($score): string
    {
        if ($score <= 1.5) return 'BB';
        if ($score <= 2.5) return 'MB';
        if ($score <= 3.5) return 'BSH';
        return 'BSB';
    }

    private function getNilaiKriteria(): array
    {
        return [
            'BB' => ['nilai' => 'BB', 'skor' => 1],   // Belum Berkembang
            'MB' => ['nilai' => 'MB', 'skor' => 2],   // Mulai Berkembang
            'BSH' => ['nilai' => 'BSH', 'skor' => 3], // Berkembang Sesuai Harapan
            'BSB' => ['nilai' => 'BSB', 'skor' => 4]  // Berkembang Sangat Baik
        ];
    }
}
