<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Perkembangan Anak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background-color: #f0f0f0;
        }

        .no-border {
            border: none !important;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">Format Penilaian Perkembangan Anak</h3>

    <table>
        <tr>
            <td class="no-border"><strong>Nama Anak:</strong> {{ $student->namaSiswa }}<br>
                <strong>Usia:</strong> {{ $student->usia }}<br>
                <strong>Tanggal Penilaian:</strong> {{ now()->format('d M Y') }}<br>
                <strong>Nama Guru:</strong> {{ $student->guru }}
            </td>
        </tr>
    </table>

    <h4>Hasil Penilaian</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Aspek Perkembangan</th>
                <th>Skor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r['nama_aspek'] }}</td>
                    <td>{{ $r['skor'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Kesimpulan Penilaian</h4>
    <ul>
        <li>BSB (Berkembang Sangat Baik): {{ $summary['BSB'] }}</li>
        <li>BSH (Berkembang Sesuai Harapan): {{ $summary['BSH'] }}</li>
        <li>MB (Mulai Berkembang): {{ $summary['MB'] }}</li>
        <li>BB (Belum Berkembang): {{ $summary['BB'] }}</li>
    </ul>

    <strong>Rekomendasi Guru:</strong><br>
    Anak menunjukkan perkembangan yang baik secara keseluruhan. Perlu pengayaan dalam eksplorasi fungsi benda dan
    keterampilan berbagi secara konsisten.
</body>

</html>
