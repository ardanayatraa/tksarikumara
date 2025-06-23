<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Perkembangan Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f0f0f0;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2 style="color: #4A90E2;">Laporan Perkembangan Siswa</h2>

    <p>
        <strong>Nama:</strong> {{ $student->namaSiswa }}<br>
        <strong>Periode:</strong>
        {{ \Carbon\Carbon::parse($start)->format('d M Y') }}
        s/d
        {{ \Carbon\Carbon::parse($end)->format('d M Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kode Aspek</th>
                <th>Aspek</th>
                <th>Kode Indikator</th>
                <th>Indikator</th>
                <th>Kategori</th>
                <th>Nilai</th>
                <th>Skor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $r)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($r['tgl_penilaian'])->format('d M Y') }}</td>
                    <td>{{ $r['kode_aspek'] }}</td>
                    <td>{{ $r['nama_aspek'] }}</td>
                    <td>{{ $r['kode_indikator'] }}</td>
                    <td>{{ $r['nama_indikator'] }}</td>
                    <td>{{ $r['kategori'] }}</td>
                    <td style="text-align:center;">{{ $r['nilai'] }}</td>
                    <td style="text-align:right;">{{ $r['skor'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:#888;">
                        Tidak ada data ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4>Kesimpulan Penilaian</h4>
    <ul>
        <li>BSB (Berkembang Sangat Baik): <strong>{{ $summary['BSB'] }}</strong></li>
        <li>BSH (Berkembang Sesuai Harapan): <strong>{{ $summary['BSH'] }}</strong></li>
        <li>MB (Mulai Berkembang): <strong>{{ $summary['MB'] }}</strong></li>
        <li>BB (Belum Berkembang): <strong>{{ $summary['BB'] }}</strong></li>
    </ul>

    <p>Laporan lengkap terlampir pada file PDF.</p>

    <p>Terima kasih,<br>{{ config('app.name') }}</p>
</body>

</html>
