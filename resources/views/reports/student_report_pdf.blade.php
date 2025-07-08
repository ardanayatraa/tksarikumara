<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tabel Penilaian Individu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h3 {
            background-color: #cfe2ff;
            padding: 8px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .no-border td {
            border: none;
            padding: 2px 4px;
        }

        ul {
            padding-left: 16px;
        }

        ul li {
            margin-bottom: 4px;
        }
    </style>
</head>

<body>
    <h3># Penilaian Individu Per Minggu</h3>

    <table class="no-border">
        <tr>
            <td><strong>Nama Siswa</strong></td>
            <td>: {{ $student->namaSiswa }}</td>
            <td><strong>Usia</strong></td>
            <td>: {{ \Carbon\Carbon::parse($student->tgl_lahir)->age }} Tahun</td>
        </tr>
        <tr>
            <td><strong>Kelas</strong></td>
            <td>: {{ $student->kelas->namaKelas ?? '-' }}</td>
            <td><strong>Tahun Ajaran</strong></td>
            <td>: {{ $tahun_ajaran ?? '2024/2025' }}</td>
        </tr>
        <tr>
            <td><strong>Nama Guru</strong></td>
            <td>: {{ $student->penilaian[0]->guru->namaGuru ?? '-' }}</td>
            <td><strong>Tanggal Cetak</strong></td>
            <td>: {{ now()->format('d M Y') }}</td>
        </tr>
    </table>

    <h4>Hasil Penilaian</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Aspek</th>
                <th>Aspek Penilaian</th>
                <th>Indikator</th>
                <th>Skor</th>
                <th>Skala</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalKategori = ['BSB' => 0, 'BSH' => 0, 'MB' => 0, 'BB' => 0];
            @endphp

            @foreach ($rekap as $index => $aspek)
                @php
                    $skor = round($aspek['skor'] ?? 0, 2);
                    $skala = match (true) {
                        $skor >= 3.5 => 'BSB',
                        $skor >= 2.5 => 'BSH',
                        $skor >= 1.5 => 'MB',
                        $skor > 0 => 'BB',
                        default => '-',
                    };
                    if (isset($totalKategori[$skala])) {
                        $totalKategori[$skala]++;
                    }
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $aspek['kode_aspek'] }}</td>
                    <td>{{ $aspek['nama_aspek'] }}</td>
                    <td>
                        <ul>
                            @foreach ($aspek['indikator'] as $indikator)
                                <li>{{ $indikator }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ number_format($skor, 2) }}</td>
                    <td>{{ $skala }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Kesimpulan Penilaian</h4>
    <ul>
        <li><strong>BSB (Berkembang Sangat Baik):</strong> {{ $totalKategori['BSB'] }}</li>
        <li><strong>BSH (Berkembang Sesuai Harapan):</strong> {{ $totalKategori['BSH'] }}</li>
        <li><strong>MB (Mulai Berkembang):</strong> {{ $totalKategori['MB'] }}</li>
        <li><strong>BB (Belum Berkembang):</strong> {{ $totalKategori['BB'] }}</li>
    </ul>

    <h4>Rekomendasi Guru</h4>
    @php
        // ambil dari catatan penilaian terakhir jika tersedia
        $catatan = $student->penilaian[0]->catatan ?? null;
    @endphp
    <p>
        {{ $catatan ?: 'Anak menunjukkan perkembangan yang baik secara keseluruhan. Perlu penguatan pada aspek yang berada di kategori MB atau BB dengan metode pembelajaran menyenangkan dan partisipatif.' }}
    </p>
</body>

</html>
