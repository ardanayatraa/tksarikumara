<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AkunSiswa;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use App\Models\IndikatorAspek;
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

        // Update existing assessments with more realistic data
        $penilaianRecords = Penilaian::with(['nilaiSiswa', 'akunSiswa'])->get();

        foreach ($penilaianRecords as $penilaian) {
            $studentProfile = $profiledStudents[$penilaian->id_akunsiswa];
            $week = $penilaian->minggu_ke;
            $studentAge = Carbon::parse($penilaian->akunSiswa->tgl_lahir)->age;

            foreach ($penilaian->nilaiSiswa as $nilai) {
                // Update score based on student profile and week
                $newScore = $this->calculateRealisticScore(
                    $studentProfile,
                    $week,
                    $studentAge,
                    $nilai->indikator->aspek->kode_aspek
                );

                $scoreKey = $this->getScoreKey($newScore);
                $scoreData = $this->getNilaiKriteria()[$scoreKey];

                // Generate detailed, contextual notes
                $catatan = $this->generateDetailedNote(
                    $studentProfile,
                    $scoreKey,
                    $week,
                    $nilai->indikator->nama_indikator,
                    $penilaian->akunSiswa->namaSiswa
                );

                $nilai->update([
                    'nilai' => $scoreData['nilai'],
                    'skor' => $scoreData['skor'],
                    'catatan' => $catatan,
                ]);
            }
        }

        echo "Detailed assessment data updated successfully!\n";
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

        // Age adjustment
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

        // Add realistic variation
        $variation = (rand(-8, 12) / 100);

        $finalScore = $baseScore + $ageBonus + $weeklyProgress + $aspekAdjustment + $variation;

        return max(1, min(4, round($finalScore)));
    }

    private function getAspekAdjustment($aspekKode, $profile): float
    {
        $adjustments = [
            'advanced' => [
                'I' => 0.3, 'II.A' => 0.4, 'II.B' => 0.3, 'II.C' => 0.2,
                'III.A' => 0.5, 'III.B' => 0.4, 'III.C' => 0.3,
                'IV.A' => 0.4, 'IV.B' => 0.5,
                'V.A' => 0.3, 'V.B' => 0.2, 'V.C' => 0.3,
                'VI.A' => 0.3, 'VI.B' => 0.4, 'VI.C' => 0.3
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

    private function generateDetailedNote($profile, $scoreKey, $week, $indikatorName, $studentName): string
    {
        $firstName = explode(' ', $studentName)[0];

        $noteTemplates = [
            'advanced' => [
                'BB' => "{$firstName} menunjukkan potensi baik dalam {$indikatorName}, namun perlu konsistensi lebih.",
                'MB' => "{$firstName} berkembang dengan baik dalam {$indikatorName} dan menunjukkan antusiasme tinggi.",
                'BSH' => "{$firstName} menguasai {$indikatorName} dengan sangat baik dan dapat membantu teman lain.",
                'BSB' => "{$firstName} menunjukkan kemampuan luar biasa dalam {$indikatorName} dan menjadi contoh bagi teman-teman."
            ],
            'typical' => [
                'BB' => "{$firstName} memerlukan bimbingan tambahan dalam {$indikatorName}.",
                'MB' => "{$firstName} mulai menunjukkan kemajuan dalam {$indikatorName} dengan bimbingan guru.",
                'BSH' => "{$firstName} dapat melakukan {$indikatorName} dengan baik sesuai tahapan usianya.",
                'BSB' => "{$firstName} menunjukkan kemampuan yang baik dalam {$indikatorName}."
            ],
            'needs_support' => [
                'BB' => "{$firstName} memerlukan perhatian khusus dan bimbingan intensif dalam {$indikatorName}.",
                'MB' => "{$firstName} menunjukkan kemajuan kecil dalam {$indikatorName} dengan dukungan ekstra.",
                'BSH' => "{$firstName} berhasil mencapai kemajuan yang baik dalam {$indikatorName} dengan bantuan.",
                'BSB' => "{$firstName} menunjukkan kemajuan menggembirakan dalam {$indikatorName}."
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
            'BB' => ['nilai' => 'BB', 'skor' => 1],
            'MB' => ['nilai' => 'MB', 'skor' => 2],
            'BSH' => ['nilai' => 'BSH', 'skor' => 3],
            'BSB' => ['nilai' => 'BSB', 'skor' => 4]
        ];
    }
}
