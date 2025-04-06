<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\KepalaSekolah;
use App\Models\AkunSiswa;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        Admin::create([
            'username' => 'admin123',
            'password' => Hash::make('password'),
            'email' => 'admin@example.com',
            'notlp' => '081234567890',
        ]);

        // Guru
        Guru::create([
            'namaGuru' => 'Guru Satu',
            'nip' => '1234567890',
            'username' => 'guru123',
            'password' => Hash::make('password'),
            'email' => 'guru@example.com',
            'jenis_kelamin' => 'L',
            'notlp' => '081234567891',
        ]);

        // Kepala Sekolah
        KepalaSekolah::create([
            'namaKepalaSekolah' => 'Pak Kepala',
            'nip' => '0987654321',
            'email' => 'kepsek@example.com',
            'notlp' => '081234567892',
            'username' => 'kepsek123',
            'password' => Hash::make('password'),
        ]);

        // Akun Siswa
        AkunSiswa::create([
            'id_kelas' => 1, // Pastikan kelas id 1 udah ada ya
            'nisn' => '0067890123',
            'namaSiswa' => 'Siswa Ganteng',
            'tgl_lahir' => '2007-05-12',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Pendidikan No. 7',
            'email' => 'siswa@example.com',
            'username' => 'siswa123',
            'password' => Hash::make('password'),
        ]);
    }
}
