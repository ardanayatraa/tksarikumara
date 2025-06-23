<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AspekPenilaian;
use App\Models\IndikatorAspek;

class AspekPenilaianSeeder extends Seeder
{
    public function run(): void
    {
        // rentang umur (jika memang perlu di‐update berkali‐kali)
        $ageRanges = [
            ['min' => 2, 'max' => 3],
            ['min' => 3, 'max' => 4],
            ['min' => 4, 'max' => 5],
            ['min' => 5, 'max' => 6],
        ];

        // definisi aspek utama + anak‐anaknya
        $aspekData = [
            [
                'kode'     => 'I',
                'nama'     => 'Nilai Agama dan Moral',
                'kategori' => 'Spiritual',
                'children' => [
                    ['kode' => 'I.A', 'nama' => 'Nilai Agama dan Moral'],
                ],
            ],
            [
                'kode'     => 'II',
                'nama'     => 'Fisik – Motorik',
                'kategori' => 'Motorik',
                'children' => [
                    ['kode' => 'II.A', 'nama' => 'Motorik Kasar'],
                    ['kode' => 'II.B', 'nama' => 'Motorik Halus'],
                    ['kode' => 'II.C', 'nama' => 'Kesehatan & Perilaku Keselamatan'],
                ],
            ],
            [
                'kode'     => 'III',
                'nama'     => 'Kognitif',
                'kategori' => 'Kognitif',
                'children' => [
                    ['kode' => 'III.A', 'nama' => 'Belajar & Memecahkan Masalah'],
                    ['kode' => 'III.B', 'nama' => 'Berpikir Logis'],
                    ['kode' => 'III.C', 'nama' => 'Berpikir Simbolik'],
                ],
            ],
            [
                'kode'     => 'IV',
                'nama'     => 'Bahasa',
                'kategori' => 'Bahasa',
                'children' => [
                    ['kode' => 'IV.A', 'nama' => 'Memahami Bahasa'],
                    ['kode' => 'IV.B', 'nama' => 'Mengungkapkan Bahasa'],
                ],
            ],
            [
                'kode'     => 'V',
                'nama'     => 'Sosial – Emosional',
                'kategori' => 'Sosial',
                'children' => [
                    ['kode' => 'V.A', 'nama' => 'Kesadaran Diri'],
                    ['kode' => 'V.B', 'nama' => 'Tanggung Jawab Diri & Orang Lain'],
                    ['kode' => 'V.C', 'nama' => 'Perilaku Prososial'],
                ],
            ],
            [
                'kode'     => 'VI',
                'nama'     => 'Seni',
                'kategori' => 'Seni',
                'children' => [
                    ['kode' => 'VI.A', 'nama' => 'Membedakan Bunyi & Suara'],
                    ['kode' => 'VI.B', 'nama' => 'Antusias Musik, Orang, & Hewan'],
                    ['kode' => 'VI.C', 'nama' => 'Mengikuti Kegiatan Seni'],
                ],
            ],
        ];

        foreach ($aspekData as $aspek) {
            // 1) Buat atau update aspek utama
            $parent = AspekPenilaian::updateOrCreate(
                ['kode_aspek' => $aspek['kode']],
                ['nama_aspek' => $aspek['nama'], 'kategori' => $aspek['kategori']]
            );

            // 2) Buat/Update tiap indikator-nya
            foreach ($aspek['children'] as $child) {
                // kita pakai looping umur agar seeder bisa mengubah min/max
                foreach ($ageRanges as $range) {
                    IndikatorAspek::updateOrCreate(
                        // Cuma match by aspek_id + kode_indikator → mencegah duplikat
                        [
                            'aspek_id'       => $parent->id_aspek,
                            'kode_indikator' => $child['kode'],
                        ],
                        // Kemudian set atau update field lainnya
                        [
                            'nama_indikator' => $child['nama'],
                            'min_umur'       => $range['min'],
                            'max_umur'       => $range['max'],
                        ]
                    );
                }
            }
        }
    }
}
