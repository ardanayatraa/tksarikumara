<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AspekPenilaian;
use App\Models\SubAspek;
use App\Models\Indikator;

class AspekSeeder extends Seeder
{
    public function run()
    {
        // ========================================
        // 1. ASPEK PENILAIAN
        // ========================================
        $aspek1 = AspekPenilaian::firstOrCreate(
            ['nama_aspek' => 'Nilai Agama dan Moral'],
            [
                'has_sub_aspek' => false,
                'deskripsi' => 'Penilaian terhadap nilai-nilai agama dan moral anak'
            ]
        );

        $aspek2 = AspekPenilaian::firstOrCreate(
            ['nama_aspek' => 'Fisik - Motorik'],
            [
                'has_sub_aspek' => true,
                'deskripsi' => 'Penilaian terhadap perkembangan fisik dan motorik anak'
            ]
        );

        $aspek3 = AspekPenilaian::firstOrCreate(
            ['nama_aspek' => 'Kognitif'],
            [
                'has_sub_aspek' => true,
                'deskripsi' => 'Penilaian terhadap perkembangan kognitif anak'
            ]
        );

        $aspek4 = AspekPenilaian::firstOrCreate(
            ['nama_aspek' => 'Bahasa'],
            [
                'has_sub_aspek' => true,
                'deskripsi' => 'Penilaian terhadap perkembangan bahasa anak'
            ]
        );

        $aspek5 = AspekPenilaian::firstOrCreate(
            ['nama_aspek' => 'Sosial - Emosional'],
            [
                'has_sub_aspek' => true,
                'deskripsi' => 'Penilaian terhadap perkembangan sosial dan emosional anak'
            ]
        );

        $aspek6 = AspekPenilaian::firstOrCreate(
            ['nama_aspek' => 'Seni'],
            [
                'has_sub_aspek' => true,
                'deskripsi' => 'Penilaian terhadap perkembangan seni anak'
            ]
        );

        // ========================================
        // 2. SUB ASPEK
        // ========================================
        // Sub Aspek untuk Fisik-Motorik
        $subFisikA = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek2->id_aspek, 'kode_sub_aspek' => 'A'],
            [
                'nama_sub_aspek' => 'Motorik Kasar',
                'deskripsi' => 'Kemampuan gerak tubuh yang menggunakan otot-otot besar'
            ]
        );

        $subFisikB = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek2->id_aspek, 'kode_sub_aspek' => 'B'],
            [
                'nama_sub_aspek' => 'Motorik Halus',
                'deskripsi' => 'Kemampuan gerak tubuh yang menggunakan otot-otot kecil'
            ]
        );

        $subFisikC = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek2->id_aspek, 'kode_sub_aspek' => 'C'],
            [
                'nama_sub_aspek' => 'Kesehatan dan Perilaku Keselamatan',
                'deskripsi' => 'Kemampuan menjaga kesehatan dan keselamatan diri'
            ]
        );

        // Sub Aspek untuk Kognitif
        $subKognitifA = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek3->id_aspek, 'kode_sub_aspek' => 'A'],
            [
                'nama_sub_aspek' => 'Belajar dan Memecahkan Masalah',
                'deskripsi' => 'Kemampuan belajar dan memecahkan masalah'
            ]
        );

        $subKognitifB = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek3->id_aspek, 'kode_sub_aspek' => 'B'],
            [
                'nama_sub_aspek' => 'Berfikir Logis',
                'deskripsi' => 'Kemampuan berfikir secara logis'
            ]
        );

        $subKognitifC = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek3->id_aspek, 'kode_sub_aspek' => 'C'],
            [
                'nama_sub_aspek' => 'Berfikir Simbolik',
                'deskripsi' => 'Kemampuan berfikir secara simbolik'
            ]
        );

        // Sub Aspek untuk Bahasa
        $subBahasaA = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek4->id_aspek, 'kode_sub_aspek' => 'A'],
            [
                'nama_sub_aspek' => 'Memahami Bahasa',
                'deskripsi' => 'Kemampuan memahami bahasa'
            ]
        );

        $subBahasaB = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek4->id_aspek, 'kode_sub_aspek' => 'B'],
            [
                'nama_sub_aspek' => 'Mengungkapkan Bahasa',
                'deskripsi' => 'Kemampuan mengungkapkan bahasa'
            ]
        );

        // Sub Aspek untuk Sosial-Emosional
        $subSosialA = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek5->id_aspek, 'kode_sub_aspek' => 'A'],
            [
                'nama_sub_aspek' => 'Kesadaran Diri',
                'deskripsi' => 'Kemampuan kesadaran diri'
            ]
        );

        $subSosialB = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek5->id_aspek, 'kode_sub_aspek' => 'B'],
            [
                'nama_sub_aspek' => 'Tanggung Jawab Diri dan Orang Lain',
                'deskripsi' => 'Kemampuan bertanggung jawab terhadap diri dan orang lain'
            ]
        );

        $subSosialC = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek5->id_aspek, 'kode_sub_aspek' => 'C'],
            [
                'nama_sub_aspek' => 'Perilaku Prososial',
                'deskripsi' => 'Kemampuan berperilaku prososial'
            ]
        );

        // Sub Aspek untuk Seni
        $subSeniA = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek6->id_aspek, 'kode_sub_aspek' => 'A'],
            [
                'nama_sub_aspek' => 'Mampu Membedakan Bunyi dan Suara',
                'deskripsi' => 'Kemampuan membedakan bunyi dan suara'
            ]
        );

        $subSeniB = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek6->id_aspek, 'kode_sub_aspek' => 'B'],
            [
                'nama_sub_aspek' => 'Ingin Mengikuti Kegiatan Musik, Orang dan Hewan',
                'deskripsi' => 'Keinginan mengikuti kegiatan musik, orang dan hewan'
            ]
        );

        $subSeniC = SubAspek::firstOrCreate(
            ['aspek_id' => $aspek6->id_aspek, 'kode_sub_aspek' => 'C'],
            [
                'nama_sub_aspek' => 'Ingin Mengikuti Kegiatan Seni',
                'deskripsi' => 'Keinginan mengikuti kegiatan seni'
            ]
        );

        // ========================================
        // 3. INDIKATOR UNTUK USIA 2-4 TAHUN
        // ========================================
        $indikators = [
            // ========================================
            // I. NILAI AGAMA DAN MORAL
            // ========================================
            // Usia 2-3 tahun
            [
                'aspek_id' => $aspek1->id_aspek,
                'sub_aspek_id' => null,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Berusaha meniru gerakan doa',
                'kelompok_usia' => '2-3_tahun',
            ],
            [
                'aspek_id' => $aspek1->id_aspek,
                'sub_aspek_id' => null,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Mulai memahami waktu pengucapan salam dan maaf',
                'kelompok_usia' => '2-3_tahun',
            ],
            // Usia 3-4 tahun
            [
                'aspek_id' => $aspek1->id_aspek,
                'sub_aspek_id' => null,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mulai mengerti perilaku yang berlawanan seperti benar dan salah',
                'kelompok_usia' => '3-4_tahun',
            ],
            [
                'aspek_id' => $aspek1->id_aspek,
                'sub_aspek_id' => null,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Meniru bacaan doa',
                'kelompok_usia' => '3-4_tahun',
            ],
            // ========================================
            // II. FISIK - MOTORIK
            // ========================================
            // A. Motorik Kasar - Usia 2-3 tahun
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Lari dan jinjit',
                'kelompok_usia' => '2-3_tahun',
            ],
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikA->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Menari sesuai irama',
                'kelompok_usia' => '2-3_tahun',
            ],
            // A. Motorik Kasar - Usia 3-4 tahun
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Berlari',
                'kelompok_usia' => '3-4_tahun',
            ],
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikA->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Meniru gerakan',
                'kelompok_usia' => '3-4_tahun',
            ],
            // B. Motorik Halus - Usia 2-3 tahun
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengguting kertas tanpa pola',
                'kelompok_usia' => '2-3_tahun',
            ],
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikB->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Meremas kain dan kertas dengan kelima jari',
                'kelompok_usia' => '2-3_tahun',
            ],
            // B. Motorik Halus - Usia 3-4 tahun
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Menggoyangkan benda berukuran sedang',
                'kelompok_usia' => '3-4_tahun',
            ],
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikB->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Menguntin garis lurus sesuai pola',
                'kelompok_usia' => '3-4_tahun',
            ],
            // C. Kesehatan dan Perilaku Keselamatan - Usia 2-3 tahun
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Berat badan sesuai usianya',
                'kelompok_usia' => '2-3_tahun',
            ],
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikC->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Tinggi badan sesuai usianya',
                'kelompok_usia' => '2-3_tahun',
            ],
            // C. Kesehatan dan Perilaku Keselamatan - Usia 3-4 tahun
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Berat badan sesuai usianya',
                'kelompok_usia' => '3-4_tahun',
            ],
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikC->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Tinggi badan sesuai usianya',
                'kelompok_usia' => '3-4_tahun',
            ],
            // ========================================
            // III. KOGNITIF
            // ========================================
            // A. Belajar dan Memecahkan Masalah - Usia 2-3 tahun
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengarah dan memegang benda yang ditunjuk orang',
                'kelompok_usia' => '2-3_tahun',
            ],
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifA->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Mencoba memecahkan masalah dengan meniru orang',
                'kelompok_usia' => '2-3_tahun',
            ],
            // A. Belajar dan Memecahkan Masalah - Usia 3-4 tahun
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengerti adanya bagian pola yang hilang',
                'kelompok_usia' => '3-4_tahun',
            ],
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifA->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Dapat menyebutkan berbagai nama makanan beserta rasanya',
                'kelompok_usia' => '3-4_tahun',
            ],
            // B. Berfikir Logis - Usia 2-3 tahun
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Dapat menyebutkan bagian suatu gambar',
                'kelompok_usia' => '2-3_tahun',
            ],
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifB->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Mengenal bagian tubuh',
                'kelompok_usia' => '2-3_tahun',
            ],
            // B. Berfikir Logis - Usia 3-4 tahun
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mencoba ikut tepuk tangan yang berpola',
                'kelompok_usia' => '3-4_tahun',
            ],
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifB->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Mengetahui ilmu banyak sedikit',
                'kelompok_usia' => '3-4_tahun',
            ],
            // C. Berfikir Simbolik - Usia 2-3 tahun
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Memberikan nama karya yang dibuat',
                'kelompok_usia' => '2-3_tahun',
            ],
            // C. Berfikir Simbolik - Usia 3-4 tahun
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Menyebutkan tugas dan perannya',
                'kelompok_usia' => '3-4_tahun',
            ],
            // ========================================
            // IV. BAHASA
            // ========================================
            // A. Memahami Bahasa - Usia 2-3 tahun
            [
                'aspek_id' => $aspek4->id_aspek,
                'sub_aspek_id' => $subBahasaA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Dapat menyanyikan lagu anak sederhana',
                'kelompok_usia' => '2-3_tahun',
            ],
            // A. Memahami Bahasa - Usia 3-4 tahun
            [
                'aspek_id' => $aspek4->id_aspek,
                'sub_aspek_id' => $subBahasaA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Berpura-pura membaca cerita bergambar dengan kata sendiri',
                'kelompok_usia' => '3-4_tahun',
            ],
            // B. Mengungkapkan Bahasa - Usia 2-3 tahun
            [
                'aspek_id' => $aspek4->id_aspek,
                'sub_aspek_id' => $subBahasaB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Dapat mengungkapkan kata tanya dengan tepat',
                'kelompok_usia' => '2-3_tahun',
            ],
            // B. Mengungkapkan Bahasa - Usia 3-4 tahun
            [
                'aspek_id' => $aspek4->id_aspek,
                'sub_aspek_id' => $subBahasaB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Menyatakan keinginan dengan kalimat sederhana',
                'kelompok_usia' => '3-4_tahun',
            ],
            // ========================================
            // V. SOSIAL - EMOSIONAL
            // ========================================
            // A. Kesadaran Diri - Usia 2-3 tahun
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Salam ketika akan pergi',
                'kelompok_usia' => '2-3_tahun',
            ],
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialA->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Bereaksi percaya kepada orang dewasa',
                'kelompok_usia' => '2-3_tahun',
            ],
            // A. Kesadaran Diri - Usia 3-4 tahun
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengikuti aktivitas dalam suatu kegiatan besar',
                'kelompok_usia' => '3-4_tahun',
            ],
            // B. Tanggung Jawab Diri dan Orang Lain - Usia 2-3 tahun
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Bisa mengungkapkan keinginan buang air kecil dan besar',
                'kelompok_usia' => '2-3_tahun',
            ],
            // B. Tanggung Jawab Diri dan Orang Lain - Usia 3-4 tahun
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Bisa melakukan buang air kecil dan besar',
                'kelompok_usia' => '3-4_tahun',
            ],
            // C. Perilaku Prososial - Usia 2-3 tahun
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Bermain secara kooperatif dalam kelompok',
                'kelompok_usia' => '2-3_tahun',
            ],
            // C. Perilaku Prososial - Usia 3-4 tahun
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengenal bermacam suara kendaraan',
                'kelompok_usia' => '3-4_tahun',
            ],
            // ========================================
            // VI. SENI
            // ========================================
            // A. Mampu Membedakan Bunyi dan Suara - Usia 2-3 tahun
            [
                'aspek_id' => $aspek6->id_aspek,
                'sub_aspek_id' => $subSeniA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Memperhatikan dan mengetahui antar suara nyanyi dan berbicara',
                'kelompok_usia' => '2-3_tahun',
            ],
            // A. Mampu Membedakan Bunyi dan Suara - Usia 3-4 tahun
            [
                'aspek_id' => $aspek6->id_aspek,
                'sub_aspek_id' => $subSeniA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengenal bermacam suara kendaraan',
                'kelompok_usia' => '3-4_tahun',
            ],
            // B. Ingin Mengikuti Kegiatan Musik, Orang dan Hewan - Usia 2-3 tahun
            [
                'aspek_id' => $aspek6->id_aspek,
                'sub_aspek_id' => $subSeniB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Menyanyi hingga selesai sesuai irama',
                'kelompok_usia' => '2-3_tahun',
            ],
            // B. Ingin Mengikuti Kegiatan Musik, Orang dan Hewan - Usia 3-4 tahun
            [
                'aspek_id' => $aspek6->id_aspek,
                'sub_aspek_id' => $subSeniB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mendengar dan menyanyi lagu',
                'kelompok_usia' => '3-4_tahun',
            ],
            // C. Ingin Mengikuti Kegiatan Seni - Usia 2-3 tahun
            [
                'aspek_id' => $aspek6->id_aspek,
                'sub_aspek_id' => $subSeniC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Menggambar benda secara spesifik',
                'kelompok_usia' => '2-3_tahun',
            ],
            // C. Ingin Mengikuti Kegiatan Seni - Usia 3-4 tahun
            [
                'aspek_id' => $aspek6->id_aspek,
                'sub_aspek_id' => $subSeniC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Membentuk sesuatu dengan plastisin',
                'kelompok_usia' => '3-4_tahun',
            ],
        ];

        // Insert semua indikator untuk usia 2-4 tahun
        foreach ($indikators as $indikator) {
            Indikator::firstOrCreate(
                [
                    'aspek_id' => $indikator['aspek_id'],
                    'sub_aspek_id' => $indikator['sub_aspek_id'],
                    'kode_indikator' => $indikator['kode_indikator'],
                    'kelompok_usia' => $indikator['kelompok_usia']
                ],
                [
                    'deskripsi_indikator' => $indikator['deskripsi_indikator']
                ]
            );
        }

        // ========================================
        // 4. INDIKATOR UNTUK USIA 4-6 TAHUN
        // ========================================
        $indikators_4_6 = [
            // ========================================
            // I. NILAI AGAMA DAN MORAL (4-6 TAHUN)
            // ========================================
            // Usia 4-5 tahun
            [
                'aspek_id' => $aspek1->id_aspek,
                'sub_aspek_id' => null,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Tahu apa agama yang diyakininya',
                'kelompok_usia' => '4-5_tahun',
            ],
            // Usia 5-6 tahun
            [
                'aspek_id' => $aspek1->id_aspek,
                'sub_aspek_id' => null,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengenal lebih spesifik agama yang dianutnya',
                'kelompok_usia' => '5-6_tahun',
            ],
            // ========================================
            // II. FISIK - MOTORIK (4-6 TAHUN)
            // ========================================
            // A. Motorik Kasar - Usia 4-5 tahun
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Meniru gerakan sekitarnya',
                'kelompok_usia' => '4-5_tahun',
            ],
            // A. Motorik Kasar - Usia 5-6 tahun
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Melakukan gerakan tubuh secara bebas',
                'kelompok_usia' => '5-6_tahun',
            ],
            // B. Motorik Halus - Usia 4-5 tahun
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengkoordinasi mata dan tangan membentuk gerakan yang sulit',
                'kelompok_usia' => '4-5_tahun',
            ],
            // B. Motorik Halus - Usia 5-6 tahun
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengeksplore media sekitarnya',
                'kelompok_usia' => '5-6_tahun',
            ],
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikB->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Menggunakan alat makan dan minum dengan benar',
                'kelompok_usia' => '5-6_tahun',
            ],
            // C. Kesehatan dan Perilaku Keselamatan - Usia 4-5 tahun
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Berat badan sesuai usianya',
                'kelompok_usia' => '4-5_tahun',
            ],
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikC->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Tinggi badan sesuai usianya',
                'kelompok_usia' => '4-5_tahun',
            ],
            // C. Kesehatan dan Perilaku Keselamatan - Usia 5-6 tahun
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Berat badan sesuai usianya',
                'kelompok_usia' => '5-6_tahun',
            ],
            [
                'aspek_id' => $aspek2->id_aspek,
                'sub_aspek_id' => $subFisikC->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Tinggi badan sesuai usianya',
                'kelompok_usia' => '5-6_tahun',
            ],
            // ========================================
            // III. KOGNITIF (4-6 TAHUN)
            // ========================================
            // A. Belajar dan Memecahkan Masalah - Usia 4-5 tahun
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengenal benda sesuai fungsinya',
                'kelompok_usia' => '4-5_tahun',
            ],
            // A. Belajar dan Memecahkan Masalah - Usia 5-6 tahun
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Menunjuk benda yang bersifat menyelidik dan eksploratif',
                'kelompok_usia' => '5-6_tahun',
            ],
            // B. Berfikir Logis - Usia 4-5 tahun
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengenal bagian tubuh',
                'kelompok_usia' => '4-5_tahun',
            ],
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifB->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Mampu menyebutkan nama gambar',
                'kelompok_usia' => '4-5_tahun',
            ],
            // B. Berfikir Logis - Usia 5-6 tahun
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Tepuk tangan mengikuti pola',
                'kelompok_usia' => '5-6_tahun',
            ],
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifB->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Mengetahui ilmu banyak dan sedikit',
                'kelompok_usia' => '5-6_tahun',
            ],
            // C. Berfikir Simbolik - Usia 4-5 tahun
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Memberikan nama karya yang dibuat',
                'kelompok_usia' => '4-5_tahun',
            ],
            // C. Berfikir Simbolik - Usia 5-6 tahun
            [
                'aspek_id' => $aspek3->id_aspek,
                'sub_aspek_id' => $subKognitifC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Menyebutkan tugas dan perannya',
                'kelompok_usia' => '5-6_tahun',
            ],
            // ========================================
            // IV. BAHASA (4-6 TAHUN)
            // ========================================
            // A. Memahami Bahasa - Usia 4-5 tahun
            [
                'aspek_id' => $aspek4->id_aspek,
                'sub_aspek_id' => $subBahasaA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Dapat menyanyikan lagu anak sederhana',
                'kelompok_usia' => '4-5_tahun',
            ],
            // A. Memahami Bahasa - Usia 5-6 tahun
            [
                'aspek_id' => $aspek4->id_aspek,
                'sub_aspek_id' => $subBahasaA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Membaca cerita bergambar dengan kata sendiri secara pura-pura',
                'kelompok_usia' => '5-6_tahun',
            ],
            // B. Mengungkapkan Bahasa - Usia 4-5 tahun
            [
                'aspek_id' => $aspek4->id_aspek,
                'sub_aspek_id' => $subBahasaB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Bertanya dengan tepat',
                'kelompok_usia' => '4-5_tahun',
            ],
            // B. Mengungkapkan Bahasa - Usia 5-6 tahun
            [
                'aspek_id' => $aspek4->id_aspek,
                'sub_aspek_id' => $subBahasaB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Menyatakan keinginan dengan kalimat sederhana',
                'kelompok_usia' => '5-6_tahun',
            ],
            // ========================================
            // V. SOSIAL - EMOSIONAL (4-6 TAHUN)
            // ========================================
            // A. Kesadaran Diri - Usia 4-5 tahun
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Salam ketika akan pergi',
                'kelompok_usia' => '4-5_tahun',
            ],
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialA->id_sub_aspek,
                'kode_indikator' => '2',
                'deskripsi_indikator' => 'Bereaksi percaya kepada orang dewasa',
                'kelompok_usia' => '4-5_tahun',
            ],
            // A. Kesadaran Diri - Usia 5-6 tahun
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengikuti aktivitas dalam suatu kegiatan besar',
                'kelompok_usia' => '5-6_tahun',
            ],
            // B. Bertanggung Jawab Diri dan Orang Lain - Usia 4-5 tahun
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Bisa mengungkapkan keinginan buang air kecil dan besar',
                'kelompok_usia' => '4-5_tahun',
            ],
            // B. Bertanggung Jawab Diri dan Orang Lain - Usia 5-6 tahun
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Bisa melakukan buang air kecil dan besar',
                'kelompok_usia' => '5-6_tahun',
            ],
            // C. Perilaku Prososial - Usia 4-5 tahun
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Bermain secara kooperatif dalam kelompok',
                'kelompok_usia' => '4-5_tahun',
            ],
            // C. Perilaku Prososial - Usia 5-6 tahun
            [
                'aspek_id' => $aspek5->id_aspek,
                'sub_aspek_id' => $subSosialC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Membangun kerja sama',
                'kelompok_usia' => '5-6_tahun',
            ],
            // ========================================
            // VI. SENI (4-6 TAHUN)
            // ========================================
            // A. Mampu Membedakan Bunyi dan Suara - Usia 4-5 tahun
            [
                'aspek_id' => $aspek6->id_aspek,
                'sub_aspek_id' => $subSeniA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengetahui suara nyanyi atau berbicara',
                'kelompok_usia' => '4-5_tahun',
            ],
            // A. Mampu Membedakan Bunyi dan Suara - Usia 5-6 tahun
            [
                'aspek_id' => $aspek6->id_aspek,
                'sub_aspek_id' => $subSeniA->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mengenal berbagai macam suara kendaraan',
                'kelompok_usia' => '5-6_tahun',
            ],
            // B. Ingin Mengikuti Kegiatan Musik, Orang dan Hewan - Usia 4-5 tahun
            [
                'aspek_id' => $aspek6->id_aspek,
                'sub_aspek_id' => $subSeniB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Menyanyi hingga selesai sesuai irama',
                'kelompok_usia' => '4-5_tahun',
            ],
            // B. Ingin Mengikuti Kegiatan Musik, Orang dan Hewan - Usia 5-6 tahun
            [
                'aspek_id' => $aspek6->id_aspek,
                'sub_aspek_id' => $subSeniB->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Mendengar dan menyanyi lagu',
                'kelompok_usia' => '5-6_tahun',
            ],
            // C. Ingin Mengikuti Kegiatan Seni - Usia 4-5 tahun
            [
                'aspek_id' => $aspek6->id_aspek,
                'sub_aspek_id' => $subSeniC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Menggambar benda secara spesifik',
                'kelompok_usia' => '4-5_tahun',
            ],
            // C. Ingin Mengikuti Kegiatan Seni - Usia 5-6 tahun
            [
                'aspek_id' => $aspek6->id_aspek,
                'sub_aspek_id' => $subSeniC->id_sub_aspek,
                'kode_indikator' => '1',
                'deskripsi_indikator' => 'Membentuk sesuatu dengan plastisin',
                'kelompok_usia' => '5-6_tahun',
            ],
        ];

        // Insert semua indikator untuk usia 4-6 tahun
        foreach ($indikators_4_6 as $indikator) {
            Indikator::firstOrCreate(
                [
                    'aspek_id' => $indikator['aspek_id'],
                    'sub_aspek_id' => $indikator['sub_aspek_id'],
                    'kode_indikator' => $indikator['kode_indikator'],
                    'kelompok_usia' => $indikator['kelompok_usia']
                ],
                [
                    'deskripsi_indikator' => $indikator['deskripsi_indikator']
                ]
            );
        }

        echo "Seeder berhasil dijalankan!\n";
        echo "Total Aspek: 6\n";
        echo "Total Sub Aspek: 15\n";
        echo "Total Indikator: " . (count($indikators) + count($indikators_4_6)) . "\n";
    }
}
