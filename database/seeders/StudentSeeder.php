<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\AkunSiswa;
use App\Models\Kelas;
use Carbon\Carbon;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Create classes first
        $tkA = Kelas::firstOrCreate(
            ['namaKelas' => 'TK-A'],
            [
                'tahunAjaran' => '2025',
                'jumlahSiswa' => 20
            ]
        );

        $tkB = Kelas::firstOrCreate(
            ['namaKelas' => 'TK-B'],
            [
                'tahunAjaran' => '2025',
                'jumlahSiswa' => 20
            ]
        );

        // Student data from the provided table
        $students = [
            // TK-A students
            [
                'namaSiswa' => 'I Wayan Arimbawa',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2023-03-28',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jl. Pelajar Pejuang, Karangasem',
                'namaOrangTua' => 'Darmana Mandala',
                'email' => 'rahayusurya@pt.mil'
            ],
            [
                'namaSiswa' => 'Ni Ketut Astiti',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2022-10-21',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jl. Suryakencana, Tabanan',
                'namaOrangTua' => 'Puji Andriani, S.H.',
                'email' => 'adinata26@yahoo.com'
            ],
            [
                'namaSiswa' => 'I Komang Wardani',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2022-11-07',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jl. Sadang Serang, Karangasem',
                'namaOrangTua' => 'Bakiman Wibowo',
                'email' => 'malik94@pd.int'
            ],
            [
                'namaSiswa' => 'Ni Gede Arya',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2023-07-16',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jalan M.H Thamrin, Kuta, Badung',
                'namaOrangTua' => 'Yance Utami',
                'email' => 'cahyonogunawan@hotmail.com'
            ],
            [
                'namaSiswa' => 'I Wayan Arya',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2022-10-19',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jalan Moch. Ramdan, Ubud, Gianyar',
                'namaOrangTua' => 'Puti Kezia Setiawan, M.M.',
                'email' => 'opungthamrin@gmail.com'
            ],
            [
                'namaSiswa' => 'Ni Luh Arya',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2022-04-09',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jalan Rungkut Industri, Kuta, Badung',
                'namaOrangTua' => 'Cawisono Nasyidah, S.H.',
                'email' => 'rwibowo@ud.org'
            ],
            [
                'namaSiswa' => 'I Gede Santika',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2022-05-31',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Gang Pasteur, Bangli',
                'namaOrangTua' => 'Danuja Purnawati',
                'email' => 'taliamandasari@yahoo.com'
            ],
            [
                'namaSiswa' => 'I Gede Astiti',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2022-07-01',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jalan Pasirkoja, Klungkung',
                'namaOrangTua' => 'Dirja Purwanti',
                'email' => 'zpadmasari@yahoo.com'
            ],
            [
                'namaSiswa' => 'Ni Gede Wardani',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2022-10-16',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Gg. Dipatiukur, Denpasar Selatan, Denpasar',
                'namaOrangTua' => 'Dt. Satya Kusumo, S.E.I',
                'email' => 'eriyanti@pd.ponpes.id'
            ],
            [
                'namaSiswa' => 'Ni Wayan Arya',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2023-06-22',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jl. Jayawijaya, Bangli',
                'namaOrangTua' => 'T. Pranawa Yuniar, S.Psi',
                'email' => 'tedi27@ud.gov'
            ],
            [
                'namaSiswa' => 'I Gede Arya',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2022-02-05',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Gg. KH Amin Jasuta, Klungkung',
                'namaOrangTua' => 'Drs. Dalimin Mangunsong',
                'email' => 'ghaliyatinuraini@gmail.com'
            ],
            [
                'namaSiswa' => 'I Made Adnyana',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2023-03-12',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Gang Asia Afrika, Klungkung',
                'namaOrangTua' => 'Wisnu Tarihoran',
                'email' => 'bambangpermadi@hotmail.com'
            ],
            [
                'namaSiswa' => 'I Nyoman Arimbawa',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2021-08-22',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Gg. Cikutra Timur, Singaraja, Buleleng',
                'namaOrangTua' => 'Dr. Pranata Mahendra, S.E.I',
                'email' => 'kartanuraini@hotmail.com'
            ],
            [
                'namaSiswa' => 'I Desak Astiti',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2023-01-03',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jl. Rajawali Timur, Denpasar Selatan, Denpasar',
                'namaOrangTua' => 'Salsabila Yulianti',
                'email' => 'cmaryati@gmail.com'
            ],
            [
                'namaSiswa' => 'Ni Made Adnyana',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2022-10-27',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jl. Sadang Serang, Klungkung',
                'namaOrangTua' => 'Lanjar Puspasari',
                'email' => 'adityahidayanto@cv.org'
            ],
            [
                'namaSiswa' => 'Ni Putu Arimbawa',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2023-06-21',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jalan Monginsidi, Klungkung',
                'namaOrangTua' => 'Estiawan Winarsih',
                'email' => 'ghaliyatimustofa@hotmail.com'
            ],
            [
                'namaSiswa' => 'I Gede Wardani',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2022-07-21',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jalan Waringin, Karangasem',
                'namaOrangTua' => 'dr. Dadap Kuswoyo, S.IP',
                'email' => 'slamet67@hotmail.com'
            ],
            [
                'namaSiswa' => 'I Putu Astiti',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2022-08-13',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jl. Surapati, Kuta, Badung',
                'namaOrangTua' => 'Jessica Kurniawan, S.H.',
                'email' => 'gastihassanah@pd.my.id'
            ],
            [
                'namaSiswa' => 'Ni Made Jaya',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2022-10-28',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Gg. M.H Thamrin, Kuta, Badung',
                'namaOrangTua' => 'Asirwanda Yulianti',
                'email' => 'prakasaganda@pd.org'
            ],
            [
                'namaSiswa' => 'I Wayan Astiti',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2022-09-24',
                'kelas' => $tkA->id_kelas,
                'alamat' => 'Jalan Sukajadi, Kuta, Badung',
                'namaOrangTua' => 'Violet Hasanah',
                'email' => 'qpuspita@hotmail.com'
            ],

            // TK-B students
            [
                'namaSiswa' => 'I Desak Astiti',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2019-01-28',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Jl. PHH. Mustofa, Kuta, Badung',
                'namaOrangTua' => 'Asmianto Prastuti',
                'email' => 'balijan09@perum.or.id'
            ],
            [
                'namaSiswa' => 'Ni Gede Santika',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2019-08-23',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Jl. Kutisari Selatan, Tabanan',
                'namaOrangTua' => 'Mursita Prakasa',
                'email' => 'purnawatijumadi@hotmail.com'
            ],
            [
                'namaSiswa' => 'I Kadek Wardani',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2020-03-09',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Jl. Veteran, Klungkung',
                'namaOrangTua' => 'Lamar Pratiwi, M.TI.',
                'email' => 'hasan53@yahoo.com'
            ],
            [
                'namaSiswa' => 'Ni Ketut Astiti',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2019-12-23',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Gg. Erlangga, Klungkung',
                'namaOrangTua' => 'Umi Hidayanto',
                'email' => 'koktaviani@pt.mil'
            ],
            [
                'namaSiswa' => 'I Kadek Astiti',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2020-02-04',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Jalan Sentot Alibasa, Klungkung',
                'namaOrangTua' => 'Tasnim Prasasta',
                'email' => 'galih78@hotmail.com'
            ],
            [
                'namaSiswa' => 'I Putu Santika',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2019-11-17',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Gg. Kapten Muslihat, Singaraja, Buleleng',
                'namaOrangTua' => 'Wakiman Mansur',
                'email' => 'kurniawanintan@gmail.com'
            ],
            [
                'namaSiswa' => 'Ni Nyoman Astiti',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2018-11-05',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Jalan Sadang Serang, Denpasar Timur, Denpasar',
                'namaOrangTua' => 'Mahfud Usada',
                'email' => 'dramadan@gmail.com'
            ],
            [
                'namaSiswa' => 'Ni Ketut Jaya',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2020-03-25',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Gang Cihampelas, Ubud, Gianyar',
                'namaOrangTua' => 'Ganda Mustofa',
                'email' => 'tasdikpuspasari@hotmail.com'
            ],
            [
                'namaSiswa' => 'Ni Kadek Sukmawati',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2019-01-05',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Jl. Ciumbuleuit, Denpasar Timur, Denpasar',
                'namaOrangTua' => 'Eka Palastri, S.Gz',
                'email' => 'satyamahendra@gmail.com'
            ],
            [
                'namaSiswa' => 'I Made Santika',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2019-11-19',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Jalan Setiabudhi, Ubud, Gianyar',
                'namaOrangTua' => 'Mahmud Prayoga',
                'email' => 'ira69@cv.mil.id'
            ],
            [
                'namaSiswa' => 'I Wayan Adnyana',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2018-08-01',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Gg. Tubagus Ismail, Kuta, Badung',
                'namaOrangTua' => 'Ir. Saka Prayoga, S.T.',
                'email' => 'wibowobahuwarna@cv.biz.id'
            ],
            [
                'namaSiswa' => 'I Kadek Arimbawa',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2019-06-06',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Jl. Astana Anyar, Klungkung',
                'namaOrangTua' => 'Dadi Wacana, S.Psi',
                'email' => 'setiawannardi@hotmail.com'
            ],
            [
                'namaSiswa' => 'I Ketut Jaya',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2019-02-05',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Gang Astana Anyar, Klungkung',
                'namaOrangTua' => 'Tomi Rajata',
                'email' => 'bahuwarna19@ud.go.id'
            ],
            [
                'namaSiswa' => 'I Putu Sukmawati',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2020-07-06',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Gg. Cihampelas, Klungkung',
                'namaOrangTua' => 'Maya Adriansyah, M.TI.',
                'email' => 'setya15@pt.mil.id'
            ],
            [
                'namaSiswa' => 'Ni Komang Arya',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2019-11-26',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Gang M.H Thamrin, Kuta, Badung',
                'namaOrangTua' => 'Dadi Andriani',
                'email' => 'patriciapurnawati@yahoo.com'
            ],
            [
                'namaSiswa' => 'Ni Putu Arimbawa',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2018-12-27',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Gg. Peta, Denpasar Selatan, Denpasar',
                'namaOrangTua' => 'Irfan Prastuti',
                'email' => 'chandayani@hotmail.com'
            ],
            [
                'namaSiswa' => 'Ni Komang Santika',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2018-10-13',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Jalan Kapten Muslihat, Ubud, Gianyar',
                'namaOrangTua' => 'Edi Mulyani',
                'email' => 'prakasavanya@yahoo.com'
            ],
            [
                'namaSiswa' => 'Ni Wayan Wardani',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2019-10-18',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Jl. Astana Anyar, Denpasar Timur, Denpasar',
                'namaOrangTua' => 'Dipa Kusmawati',
                'email' => 'oagustina@pd.id'
            ],
            [
                'namaSiswa' => 'I Desak Sukmawati',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2018-09-18',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Jl. W.R. Supratman, Denpasar Barat, Denpasar',
                'namaOrangTua' => 'Cecep Maryati',
                'email' => 'puspitajamil@gmail.com'
            ],
            [
                'namaSiswa' => 'Ni Luh Santika',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2019-01-16',
                'kelas' => $tkB->id_kelas,
                'alamat' => 'Gg. Otto Iskandardinata, Ubud, Gianyar',
                'namaOrangTua' => 'Dr. Legawa Simanjuntak',
                'email' => 'cpudjiastuti@gmail.com'
            ],
        ];

        // Insert all students
        foreach ($students as $index => $student) {
            // Calculate age based on birth date
            $birthDate = Carbon::parse($student['tgl_lahir']);
            $age = $birthDate->diffInYears(Carbon::now());

            // Generate NISN (simple sequential number)
            $nisn = '00' . str_pad($index + 1, 6, '0', STR_PAD_LEFT);

            // Generate username from name (simplified)
            $nameParts = explode(' ', $student['namaSiswa']);
            $username = strtolower($nameParts[count($nameParts) - 1]) . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

            AkunSiswa::updateOrCreate(
                ['email' => $student['email']],
                [
                    'id_kelas' => $student['kelas'],
                    'nisn' => $nisn,
                    'namaSiswa' => $student['namaSiswa'],
                    'namaOrangTua' => $student['namaOrangTua'],
                    'tgl_lahir' => $student['tgl_lahir'],
                    'jenis_kelamin' => $student['jenis_kelamin'],
                    'alamat' => $student['alamat'],
                    'username' => $username,
                    'password' => Hash::make('password123'),
                ]
            );
        }
    }
}
