<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use App\Models\AkunSiswa;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\IndikatorAspek;
use Carbon\Carbon;

class PenilaianSeeder extends Seeder
{
    public function run(): void
    {
        // Get all students
        $students = AkunSiswa::all();

        // Get all classes
        $classes = Kelas::all();

        // Get a teacher for the assessments
        $guru = Guru::first();
        if (!$guru) {
            $this->command->error('No teacher found. Please run AccountSeeder first.');
            return;
        }

        // Get all indicators grouped by aspect
        $indikatorsByAspek = IndikatorAspek::with('aspek')->get()->groupBy('aspek_id');

        // Current semester and academic year
        $semester = 1;
        $tahunAjaran = date('Y') . '/' . (date('Y') + 1);

        // For each student
        foreach ($students as $student) {
            $kelas = $student->kelas;

            if (!$kelas) {
                continue; // Skip if student has no class
            }

            // For each week in a semester (typically 20 weeks)
            for ($minggu = 1; $minggu <= 20; $minggu++) {
                // Only create assessments for some weeks to make it realistic
                // For example, weeks 1, 2, 4, 5, 8, 10, 12, 15, 18, 20
                if (!in_array($minggu, [1, 2, 4, 5, 8, 10, 12, 15, 18, 20])) {
                    continue;
                }

                // Create assessment header
                $penilaian = Penilaian::create([
                    'id_akunsiswa' => $student->id_akunsiswa,
                    'id_guru' => $guru->id_guru,
                    'id_kelas' => $kelas->id_kelas,
                    'tgl_penilaian' => Carbon::now()->subWeeks(20 - $minggu)->format('Y-m-d'),
                    'minggu_ke' => $minggu,
                    'semester' => $semester,
                    'tahun_ajaran' => $tahunAjaran,
                ]);

                // For each aspect, randomly select some indicators to assess
                foreach ($indikatorsByAspek as $aspekId => $indikators) {
                    // Get age-appropriate indicators for the student
                    $studentAge = Carbon::parse($student->tgl_lahir)->age;

                    $ageAppropriateIndikators = $indikators->filter(function ($indikator) use ($studentAge) {
                        return $studentAge >= $indikator->min_umur && $studentAge <= $indikator->max_umur;
                    });

                    if ($ageAppropriateIndikators->isEmpty()) {
                        continue;
                    }

                    // Randomly select 1-3 indicators from this aspect
                    $selectedIndikators = $ageAppropriateIndikators->random(min(3, $ageAppropriateIndikators->count()));

                    foreach ($selectedIndikators as $indikator) {
                        // Randomly decide if the indicator is achieved (70% chance of success)
                        $isAchieved = (rand(1, 100) <= 70);

                        // Create assessment detail
                        NilaiSiswa::create([
                            'id_penilaian' => $penilaian->id_penilaian,
                            'indikator_aspek_id' => $indikator->id,
                            'nilai' => $isAchieved ? $indikator->bobot : 0,
                            'skor' => $isAchieved ? $indikator->bobot : 0,
                            'catatan' => $isAchieved ? 'Tercapai dengan baik' : 'Perlu ditingkatkan',
                        ]);
                    }
                }
            }

            $this->command->info("Created assessments for student: {$student->namaSiswa}");
        }

        $this->command->info('Semester assessment data seeded successfully!');
    }
}
