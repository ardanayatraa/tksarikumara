<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AspekPenilaian;

class AspekPenilaianSeeder extends Seeder
{
    public function run()
    {
        $ageRanges = [
            ['min' => 2, 'max' => 3],
            ['min' => 3, 'max' => 4],
            ['min' => 4, 'max' => 5],
            ['min' => 5, 'max' => 6],
        ];

        foreach ($ageRanges as $range) {
            $min = $range['min'];
            $max = $range['max'];

            // I. Nilai Agama dan Moral
            AspekPenilaian::create([
                'kode_aspek' => 'I',
                'nama_aspek' => 'Nilai Agama dan Moral',
                'kategori'   => 'Spiritual',
                'parent_id'  => null,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);

            // II. Fisik – Motorik
            $fisik = AspekPenilaian::create([
                'kode_aspek' => 'II',
                'nama_aspek' => 'Fisik - Motorik',
                'kategori'   => 'Motorik',
                'parent_id'  => null,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'II.A',
                'nama_aspek' => 'Motorik Kasar',
                'kategori'   => 'Motorik',
                'parent_id'  => $fisik->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'II.B',
                'nama_aspek' => 'Motorik Halus',
                'kategori'   => 'Motorik',
                'parent_id'  => $fisik->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'II.C',
                'nama_aspek' => 'Kesehatan dan Perilaku Keselamatan',
                'kategori'   => 'Kesehatan',
                'parent_id'  => $fisik->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);

            // III. Kognitif
            $kognitif = AspekPenilaian::create([
                'kode_aspek' => 'III',
                'nama_aspek' => 'Kognitif',
                'kategori'   => 'Kognitif',
                'parent_id'  => null,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'III.A',
                'nama_aspek' => 'Belajar dan Memecahkan Masalah',
                'kategori'   => 'Kognitif',
                'parent_id'  => $kognitif->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'III.B',
                'nama_aspek' => 'Berpikir Logis',
                'kategori'   => 'Kognitif',
                'parent_id'  => $kognitif->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'III.C',
                'nama_aspek' => 'Berpikir Simbolik',
                'kategori'   => 'Kognitif',
                'parent_id'  => $kognitif->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);

            // IV. Bahasa
            $bahasa = AspekPenilaian::create([
                'kode_aspek' => 'IV',
                'nama_aspek' => 'Bahasa',
                'kategori'   => 'Bahasa',
                'parent_id'  => null,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'IV.A',
                'nama_aspek' => 'Memahami Bahasa',
                'kategori'   => 'Bahasa',
                'parent_id'  => $bahasa->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'IV.B',
                'nama_aspek' => 'Mengungkapkan Bahasa',
                'kategori'   => 'Bahasa',
                'parent_id'  => $bahasa->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);

            // V. Sosial - Emosional
            $sosial = AspekPenilaian::create([
                'kode_aspek' => 'V',
                'nama_aspek' => 'Sosial - Emosional',
                'kategori'   => 'Sosial',
                'parent_id'  => null,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'V.A',
                'nama_aspek' => 'Kesadaran Diri',
                'kategori'   => 'Sosial',
                'parent_id'  => $sosial->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'V.B',
                'nama_aspek' => 'Tanggung Jawab Diri dan Orang Lain',
                'kategori'   => 'Sosial',
                'parent_id'  => $sosial->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'V.C',
                'nama_aspek' => 'Perilaku Prososial',
                'kategori'   => 'Sosial',
                'parent_id'  => $sosial->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);

            // VI. Seni
            $seni = AspekPenilaian::create([
                'kode_aspek' => 'VI',
                'nama_aspek' => 'Seni',
                'kategori'   => 'Seni',
                'parent_id'  => null,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'VI.A',
                'nama_aspek' => 'Mampu membedakan bunyi dan suara',
                'kategori'   => 'Seni',
                'parent_id'  => $seni->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'VI.B',
                'nama_aspek' => 'Ingin mengikuti kegiatan musik, orang dan hewan',
                'kategori'   => 'Seni',
                'parent_id'  => $seni->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
            AspekPenilaian::create([
                'kode_aspek' => 'VI.C',
                'nama_aspek' => 'Ingin mengikuti kegiatan seni',
                'kategori'   => 'Seni',
                'parent_id'  => $seni->id_aspek,
                'min_umur'   => $min,
                'max_umur'   => $max,
            ]);
        }
    }
}
