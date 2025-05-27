<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AspekPenilaian;

class AspekPenilaianSeeder extends Seeder
{
    public function run()
    {
        // nonaktifkan cek foreign key, truncate, lalu aktifkan kembali
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AspekPenilaian::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $ageRanges = [
            ['min' => 2, 'max' => 3],
            ['min' => 3, 'max' => 4],
            ['min' => 4, 'max' => 5],
            ['min' => 5, 'max' => 6],
        ];

        $aspects = [
            [
                'kode'     => 'I',
                'nama'     => 'Nilai Agama dan Moral',
                'kategori' => 'Spiritual',
                'children' => [],
            ],
            [
                'kode'     => 'II',
                'nama'     => 'Fisik - Motorik',
                'kategori' => 'Motorik',
                'children' => [
                    ['kode' => 'II.A', 'nama' => 'Motorik Kasar', 'kategori' => 'Motorik'],
                    ['kode' => 'II.B', 'nama' => 'Motorik Halus', 'kategori' => 'Motorik'],
                    ['kode' => 'II.C', 'nama' => 'Kesehatan dan Perilaku Keselamatan', 'kategori' => 'Kesehatan'],
                ],
            ],
            [
                'kode'     => 'III',
                'nama'     => 'Kognitif',
                'kategori' => 'Kognitif',
                'children' => [
                    ['kode' => 'III.A', 'nama' => 'Belajar dan Memecahkan Masalah', 'kategori' => 'Kognitif'],
                    ['kode' => 'III.B', 'nama' => 'Berpikir Logis', 'kategori' => 'Kognitif'],
                    ['kode' => 'III.C', 'nama' => 'Berpikir Simbolik', 'kategori' => 'Kognitif'],
                ],
            ],
            [
                'kode'     => 'IV',
                'nama'     => 'Bahasa',
                'kategori' => 'Bahasa',
                'children' => [
                    ['kode' => 'IV.A', 'nama' => 'Memahami Bahasa', 'kategori' => 'Bahasa'],
                    ['kode' => 'IV.B', 'nama' => 'Mengungkapkan Bahasa', 'kategori' => 'Bahasa'],
                ],
            ],
            [
                'kode'     => 'V',
                'nama'     => 'Sosial - Emosional',
                'kategori' => 'Sosial',
                'children' => [
                    ['kode' => 'V.A', 'nama' => 'Kesadaran Diri', 'kategori' => 'Sosial'],
                    ['kode' => 'V.B', 'nama' => 'Tanggung Jawab Diri dan Orang Lain', 'kategori' => 'Sosial'],
                    ['kode' => 'V.C', 'nama' => 'Perilaku Prososial', 'kategori' => 'Sosial'],
                ],
            ],
            [
                'kode'     => 'VI',
                'nama'     => 'Seni',
                'kategori' => 'Seni',
                'children' => [
                    ['kode' => 'VI.A', 'nama' => 'Mampu membedakan bunyi dan suara', 'kategori' => 'Seni'],
                    ['kode' => 'VI.B', 'nama' => 'Ingin mengikuti kegiatan musik, orang dan hewan', 'kategori' => 'Seni'],
                    ['kode' => 'VI.C', 'nama' => 'Ingin mengikuti kegiatan seni', 'kategori' => 'Seni'],
                ],
            ],
        ];

        foreach ($ageRanges as $range) {
            $min = $range['min'];
            $max = $range['max'];

            foreach ($aspects as $asp) {
                // buat parent
                $parent = AspekPenilaian::create([
                    'kode_aspek' => $asp['kode'],
                    'nama_aspek' => $asp['nama'],
                    'kategori'   => $asp['kategori'],
                    'parent_id'  => null,
                    'min_umur'   => $min,
                    'max_umur'   => $max,
                ]);

                // buat tiap sub-aspek
                foreach ($asp['children'] as $child) {
                    AspekPenilaian::create([
                        'kode_aspek' => $child['kode'],
                        'nama_aspek' => $child['nama'],
                        'kategori'   => $child['kategori'],
                        'parent_id'  => $parent->id_aspek,
                        'min_umur'   => $min,
                        'max_umur'   => $max,
                    ]);
                }
            }
        }
    }
}
