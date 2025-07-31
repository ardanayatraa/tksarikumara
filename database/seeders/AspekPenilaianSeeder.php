<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AspekPenilaian;
use App\Models\IndikatorAspek;
use Illuminate\Support\Str;

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
                'nama'     => 'Nilai Agama dan Moral',
                'kategori' => 'Spiritual',
                'children' => [
                    ['nama' => 'Nilai Agama dan Moral'],
                ],
            ],
            [
                'nama'     => 'Fisik – Motorik',
                'kategori' => 'Motorik',
                'children' => [
                    ['nama' => 'Motorik Kasar'],
                    ['nama' => 'Motorik Halus'],
                    ['nama' => 'Kesehatan & Perilaku Keselamatan'],
                ],
            ],
            [
                'nama'     => 'Kognitif',
                'kategori' => 'Kognitif',
                'children' => [
                    ['nama' => 'Belajar & Memecahkan Masalah'],
                    ['nama' => 'Berpikir Logis'],
                    ['nama' => 'Berpikir Simbolik'],
                ],
            ],
            [
                'nama'     => 'Bahasa',
                'kategori' => 'Bahasa',
                'children' => [
                    ['nama' => 'Memahami Bahasa'],
                    ['nama' => 'Mengungkapkan Bahasa'],
                ],
            ],
            [
                'nama'     => 'Sosial – Emosional',
                'kategori' => 'Sosial',
                'children' => [
                    ['nama' => 'Kesadaran Diri'],
                    ['nama' => 'Tanggung Jawab Diri & Orang Lain'],
                    ['nama' => 'Perilaku Prososial'],
                ],
            ],
            [
                'nama'     => 'Seni',
                'kategori' => 'Seni',
                'children' => [
                    ['nama' => 'Membedakan Bunyi & Suara'],
                    ['nama' => 'Antusias Musik, Orang, & Hewan'],
                    ['nama' => 'Mengikuti Kegiatan Seni'],
                ],
            ],
        ];

        foreach ($aspekData as $aspek) {
            // Generate kode_aspek mengikuti format Livewire component
            $kodeAspek = $this->generateKodeAspek($aspek['nama']);

            // 1) Buat atau update aspek utama
            $parent = AspekPenilaian::updateOrCreate(
                ['kode_aspek' => $kodeAspek],
                ['nama_aspek' => $aspek['nama'], 'kategori' => $aspek['kategori']]
            );

            // 2) Buat/Update tiap indikator-nya
            foreach ($aspek['children'] as $index => $child) {
                // Generate kode indikator: kode_aspek + urutan (A, B, C, dst)
                $kodeIndikator = $kodeAspek . '.' . chr(65 + $index); // A=65, B=66, C=67, dst

                // kita pakai looping umur agar seeder bisa mengubah min/max
                foreach ($ageRanges as $range) {
                    IndikatorAspek::updateOrCreate(
                        // Cuma match by aspek_id + kode_indikator → mencegah duplikat
                        [
                            'aspek_id'       => $parent->id_aspek,
                            'kode_indikator' => $kodeIndikator,
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

    /**
     * Generate kode aspek mengikuti format yang sama dengan Livewire component
     */
    protected function generateKodeAspek($namaAspek)
    {
        // Ambil kata pertama dari nama aspek
        $first = explode(' ', trim($namaAspek))[0];
        $singkatan = strtoupper(Str::substr($first, 0, 3));
        $tahun = now()->year;

        return $singkatan . $tahun;
    }
}
