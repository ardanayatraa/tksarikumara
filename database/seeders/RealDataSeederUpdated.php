<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\KepalaSekolah;
use App\Models\AkunSiswa;
use App\Models\Kelas;

class RealDataSeederUpdated extends Seeder
{
    public function run(): void
    {
        // Create Admin
        Admin::firstOrCreate(
            ['username' => 'admin123'],
            [
                'password' => Hash::make('password'),
                'email' => 'admin@tkbali.edu',
                'notlp' => '081234567890',
            ]
        );

        // Create Principal (Kepala Sekolah)
        KepalaSekolah::firstOrCreate(
            ['username' => 'kepsek123'],
            [
                'namaKepalaSekolah' => 'I Made Sutrisna, S.Pd',
                'nip' => '196505151990031001',
                'email' => 'kepsek@tkbali.edu',
                'notlp' => '081234567892',
                'password' => Hash::make('password'),
            ]
        );

        // Create Classes - UPDATED: Kelompok Bermain -> TK-A, TK B -> TK-B
        $tkA = Kelas::create([
            'namaKelas' => 'TK-A',
            'tahunAjaran' => '2024/2025',
            'jumlahSiswa' => 20,
        ]);

        $tkB = Kelas::create([
            'namaKelas' => 'TK-B',
            'tahunAjaran' => '2024/2025',
            'jumlahSiswa' => 20,
        ]);

        // Create Teachers
        $guruTKA = Guru::firstOrCreate(
            ['username' => 'guru_tka'],
            [
                'namaGuru' => 'Ni Luh Putu Sari, S.Pd',
                'nip' => '198203151005022001',
                'password' => Hash::make('password'),
                'email' => 'guru.tka@tkbali.edu',
                'jenis_kelamin' => 'P',
                'notlp' => '081234567893',
                'id_kelas' => $tkA->id_kelas,
            ]
        );

        $guruTKB = Guru::firstOrCreate(
            ['username' => 'guru_tkb'],
            [
                'namaGuru' => 'I Ketut Wirawan, S.Pd',
                'nip' => '197908201003011002',
                'password' => Hash::make('password'),
                'email' => 'guru.tkb@tkbali.edu',
                'jenis_kelamin' => 'L',
                'notlp' => '081234567894',
                'id_kelas' => $tkB->id_kelas,
            ]
        );

        // Real student data - UPDATED: Kelompok Bermain -> TK A
        $studentsData = [
            // TK-A Students (Ages 2-3) - Previously Kelompok Bermain
            [
                'nisn' => '2023032801',
                'namaSiswa' => 'I Wayan Arimbawa',
                'namaOrangTua' => 'Darmana Mandala',
                'tgl_lahir' => '2023-03-28',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Pelajar Pejuang, Karangasem',
                'email' => 'rahayusurya@pt.mil',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2022102101',
                'namaSiswa' => 'Ni Ketut Astiti',
                'namaOrangTua' => 'Puji Andriani, S.H.',
                'tgl_lahir' => '2022-10-21',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Suryakencana, Tabanan',
                'email' => 'adinata26@yahoo.com',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2022110701',
                'namaSiswa' => 'I Komang Wardani',
                'namaOrangTua' => 'Bakiman Wibowo',
                'tgl_lahir' => '2022-11-07',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Sadang Serang, Karangasem',
                'email' => 'malik94@pd.int',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2023071601',
                'namaSiswa' => 'Ni Gede Arya',
                'namaOrangTua' => 'Yance Utami',
                'tgl_lahir' => '2023-07-16',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jalan M.H Thamrin, Kuta, Badung',
                'email' => 'cahyonogunawan@hotmail.com',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2022101901',
                'namaSiswa' => 'I Wayan Arya',
                'namaOrangTua' => 'Puti Kezia Setiawan, M.M.',
                'tgl_lahir' => '2022-10-19',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Moch. Ramdan, Ubud, Gianyar',
                'email' => 'opungthamrin@gmail.com',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2022040901',
                'namaSiswa' => 'Ni Luh Arya',
                'namaOrangTua' => 'Cawisono Nasyidah, S.H.',
                'tgl_lahir' => '2022-04-09',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jalan Rungkut Industri, Kuta, Badung',
                'email' => 'rwibowo@ud.org',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2022053101',
                'namaSiswa' => 'I Gede Santika',
                'namaOrangTua' => 'Danuja Purnawati',
                'tgl_lahir' => '2022-05-31',
                'jenis_kelamin' => 'L',
                'alamat' => 'Gang Pasteur, Bangli',
                'email' => 'taliamandasari@yahoo.com',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2022070101',
                'namaSiswa' => 'I Gede Astiti',
                'namaOrangTua' => 'Dirja Purwanti',
                'tgl_lahir' => '2022-07-01',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Pasirkoja, Klungkung',
                'email' => 'zpadmasari@yahoo.com',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2022101601',
                'namaSiswa' => 'Ni Gede Wardani',
                'namaOrangTua' => 'Dt. Satya Kusumo, S.E.I',
                'tgl_lahir' => '2022-10-16',
                'jenis_kelamin' => 'P',
                'alamat' => 'Gg. Dipatiukur, Denpasar Selatan, Denpasar',
                'email' => 'eriyanti@pd.ponpes.id',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2023062201',
                'namaSiswa' => 'Ni Wayan Arya',
                'namaOrangTua' => 'T. Pranawa Yuniar, S.Psi',
                'tgl_lahir' => '2023-06-22',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Jayawijaya, Bangli',
                'email' => 'tedi27@ud.gov',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2022020501',
                'namaSiswa' => 'I Gede Arya',
                'namaOrangTua' => 'Drs. Dalimin Mangunsong',
                'tgl_lahir' => '2022-02-05',
                'jenis_kelamin' => 'L',
                'alamat' => 'Gg. KH Amin Jasuta, Klungkung',
                'email' => 'ghaliyatinuraini@gmail.com',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2023031201',
                'namaSiswa' => 'I Made Adnyana',
                'namaOrangTua' => 'Wisnu Tarihoran',
                'tgl_lahir' => '2023-03-12',
                'jenis_kelamin' => 'L',
                'alamat' => 'Gang Asia Afrika, Klungkung',
                'email' => 'bambangpermadi@hotmail.com',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2021082201',
                'namaSiswa' => 'I Nyoman Arimbawa',
                'namaOrangTua' => 'Dr. Pranata Mahendra, S.E.I',
                'tgl_lahir' => '2021-08-22',
                'jenis_kelamin' => 'L',
                'alamat' => 'Gg. Cikutra Timur, Singaraja, Buleleng',
                'email' => 'kartanuraini@hotmail.com',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2023010301',
                'namaSiswa' => 'I Desak Astiti',
                'namaOrangTua' => 'Salsabila Yulianti',
                'tgl_lahir' => '2023-01-03',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Rajawali Timur, Denpasar Selatan, Denpasar',
                'email' => 'cmaryati@gmail.com',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2022102701',
                'namaSiswa' => 'Ni Made Adnyana',
                'namaOrangTua' => 'Lanjar Puspasari',
                'tgl_lahir' => '2022-10-27',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Sadang Serang, Klungkung',
                'email' => 'adityahidayanto@cv.org',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2023062101',
                'namaSiswa' => 'Ni Putu Arimbawa',
                'namaOrangTua' => 'Estiawan Winarsih',
                'tgl_lahir' => '2023-06-21',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jalan Monginsidi, Klungkung',
                'email' => 'ghaliyatimustofa@hotmail.com',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2022072101',
                'namaSiswa' => 'I Gede Wardani',
                'namaOrangTua' => 'dr. Dadap Kuswoyo, S.IP',
                'tgl_lahir' => '2022-07-21',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Waringin, Karangasem',
                'email' => 'slamet67@hotmail.com',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2022081301',
                'namaSiswa' => 'I Putu Astiti',
                'namaOrangTua' => 'Jessica Kurniawan, S.H.',
                'tgl_lahir' => '2022-08-13',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Surapati, Kuta, Badung',
                'email' => 'gastihassanah@pd.my.id',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2022102801',
                'namaSiswa' => 'Ni Made Jaya',
                'namaOrangTua' => 'Asirwanda Yulianti',
                'tgl_lahir' => '2022-10-28',
                'jenis_kelamin' => 'P',
                'alamat' => 'Gg. M.H Thamrin, Kuta, Badung',
                'email' => 'prakasaganda@pd.org',
                'kelas' => 'TK-A'
            ],
            [
                'nisn' => '2022092401',
                'namaSiswa' => 'I Wayan Astiti',
                'namaOrangTua' => 'Violet Hasanah',
                'tgl_lahir' => '2022-09-24',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Sukajadi, Kuta, Badung',
                'email' => 'qpuspita@hotmail.com',
                'kelas' => 'TK-A'
            ],

            // TK-B Students (Ages 5-6) - Remains TK-B
            [
                'nisn' => '2019012801',
                'namaSiswa' => 'I Desak Astiti',
                'namaOrangTua' => 'Asmianto Prastuti',
                'tgl_lahir' => '2019-01-28',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. PHH. Mustofa, Kuta, Badung',
                'email' => 'balijan09@perum.or.id',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2019082301',
                'namaSiswa' => 'Ni Gede Santika',
                'namaOrangTua' => 'Mursita Prakasa',
                'tgl_lahir' => '2019-08-23',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Kutisari Selatan, Tabanan',
                'email' => 'purnawatijumadi@hotmail.com',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2020030901',
                'namaSiswa' => 'I Kadek Wardani',
                'namaOrangTua' => 'Lamar Pratiwi, M.TI.',
                'tgl_lahir' => '2020-03-09',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Veteran, Klungkung',
                'email' => 'hasan53@yahoo.com',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2019122301',
                'namaSiswa' => 'Ni Ketut Astiti',
                'namaOrangTua' => 'Umi Hidayanto',
                'tgl_lahir' => '2019-12-23',
                'jenis_kelamin' => 'P',
                'alamat' => 'Gg. Erlangga, Klungkung',
                'email' => 'koktaviani@pt.mil',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2020020401',
                'namaSiswa' => 'I Kadek Astiti',
                'namaOrangTua' => 'Tasnim Prasasta',
                'tgl_lahir' => '2020-02-04',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Sentot Alibasa, Klungkung',
                'email' => 'galih78@hotmail.com',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2019111701',
                'namaSiswa' => 'I Putu Santika',
                'namaOrangTua' => 'Wakiman Mansur',
                'tgl_lahir' => '2019-11-17',
                'jenis_kelamin' => 'L',
                'alamat' => 'Gg. Kapten Muslihat, Singaraja, Buleleng',
                'email' => 'kurniawanintan@gmail.com',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2018110501',
                'namaSiswa' => 'Ni Nyoman Astiti',
                'namaOrangTua' => 'Mahfud Usada',
                'tgl_lahir' => '2018-11-05',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jalan Sadang Serang, Denpasar Timur, Denpasar',
                'email' => 'dramadan@gmail.com',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2020032501',
                'namaSiswa' => 'Ni Ketut Jaya',
                'namaOrangTua' => 'Ganda Mustofa',
                'tgl_lahir' => '2020-03-25',
                'jenis_kelamin' => 'P',
                'alamat' => 'Gang Cihampelas, Ubud, Gianyar',
                'email' => 'tasdikpuspasari@hotmail.com',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2019010501',
                'namaSiswa' => 'Ni Kadek Sukmawati',
                'namaOrangTua' => 'Eka Palastri, S.Gz',
                'tgl_lahir' => '2019-01-05',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Ciumbuleuit, Denpasar Timur, Denpasar',
                'email' => 'satyamahendra@gmail.com',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2019111901',
                'namaSiswa' => 'I Made Santika',
                'namaOrangTua' => 'Mahmud Prayoga',
                'tgl_lahir' => '2019-11-19',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Setiabudhi, Ubud, Gianyar',
                'email' => 'ira69@cv.mil.id',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2018080101',
                'namaSiswa' => 'I Wayan Adnyana',
                'namaOrangTua' => 'Ir. Saka Prayoga, S.T.',
                'tgl_lahir' => '2018-08-01',
                'jenis_kelamin' => 'L',
                'alamat' => 'Gg. Tubagus Ismail, Kuta, Badung',
                'email' => 'wibowobahuwarna@cv.biz.id',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2019060601',
                'namaSiswa' => 'I Kadek Arimbawa',
                'namaOrangTua' => 'Dadi Wacana, S.Psi',
                'tgl_lahir' => '2019-06-06',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Astana Anyar, Klungkung',
                'email' => 'setiawannardi@hotmail.com',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2019020501',
                'namaSiswa' => 'I Ketut Jaya',
                'namaOrangTua' => 'Tomi Rajata',
                'tgl_lahir' => '2019-02-05',
                'jenis_kelamin' => 'L',
                'alamat' => 'Gang Astana Anyar, Klungkung',
                'email' => 'bahuwarna19@ud.go.id',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2020070601',
                'namaSiswa' => 'I Putu Sukmawati',
                'namaOrangTua' => 'Maya Adriansyah, M.TI.',
                'tgl_lahir' => '2020-07-06',
                'jenis_kelamin' => 'L',
                'alamat' => 'Gg. Cihampelas, Klungkung',
                'email' => 'setya15@pt.mil.id',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2019112601',
                'namaSiswa' => 'Ni Komang Arya',
                'namaOrangTua' => 'Dadi Andriani',
                'tgl_lahir' => '2019-11-26',
                'jenis_kelamin' => 'P',
                'alamat' => 'Gang M.H Thamrin, Kuta, Badung',
                'email' => 'patriciapurnawati@yahoo.com',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2018122701',
                'namaSiswa' => 'Ni Putu Arimbawa',
                'namaOrangTua' => 'Irfan Prastuti',
                'tgl_lahir' => '2018-12-27',
                'jenis_kelamin' => 'P',
                'alamat' => 'Gg. Peta, Denpasar Selatan, Denpasar',
                'email' => 'chandayani@hotmail.com',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2018101301',
                'namaSiswa' => 'Ni Komang Santika',
                'namaOrangTua' => 'Edi Mulyani',
                'tgl_lahir' => '2018-10-13',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jalan Kapten Muslihat, Ubud, Gianyar',
                'email' => 'prakasavanya@yahoo.com',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2019101801',
                'namaSiswa' => 'Ni Wayan Wardani',
                'namaOrangTua' => 'Dipa Kusmawati',
                'tgl_lahir' => '2019-10-18',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Astana Anyar, Denpasar Timur, Denpasar',
                'email' => 'oagustina@pd.id',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2018091801',
                'namaSiswa' => 'I Desak Sukmawati',
                'namaOrangTua' => 'Cecep Maryati',
                'tgl_lahir' => '2018-09-18',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. W.R. Supratman, Denpasar Barat, Denpasar',
                'email' => 'puspitajamil@gmail.com',
                'kelas' => 'TK-B'
            ],
            [
                'nisn' => '2019011601',
                'namaSiswa' => 'Ni Luh Santika',
                'namaOrangTua' => 'Dr. Legawa Simanjuntak',
                'tgl_lahir' => '2019-01-16',
                'jenis_kelamin' => 'P',
                'alamat' => 'Gg. Otto Iskandardinata, Ubud, Gianyar',
                'email' => 'cpudjiastuti@gmail.com',
                'kelas' => 'TK-B'
            ],
        ];

        // Create students
        foreach ($studentsData as $index => $studentData) {
            $kelasId = $studentData['kelas'] === 'TK-A' ? $tkA->id_kelas : $tkB->id_kelas;

            AkunSiswa::firstOrCreate(
                ['email' => $studentData['email']],
                [
                    'id_kelas' => $kelasId,
                    'nisn' => $studentData['nisn'],
                    'namaSiswa' => $studentData['namaSiswa'],
                    'namaOrangTua' => $studentData['namaOrangTua'],
                    'tgl_lahir' => $studentData['tgl_lahir'],
                    'jenis_kelamin' => $studentData['jenis_kelamin'],
                    'alamat' => $studentData['alamat'],
                    'username' => 'siswa' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'password' => Hash::make('password123'),
                ]
            );
        }

        // Update class student counts
        $tkA->update(['jumlahSiswa' => 20]);
        $tkB->update(['jumlahSiswa' => 20]);
    }
}
