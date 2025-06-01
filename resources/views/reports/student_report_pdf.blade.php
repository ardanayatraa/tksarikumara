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
            <td class="no-border">
                <strong>Nama Anak:</strong> {{ $student->namaSiswa }}<br>
                <strong>Usia:</strong> {{ $student->usia ?? now()->diffInYears($student->tgl_lahir) . ' tahun' }}<br>
                <strong>Periode Penilaian:</strong> {{ \Carbon\Carbon::parse($start)->format('d M Y') }} s/d
                {{ \Carbon\Carbon::parse($end)->format('d M Y') }}<br>
                <strong>Tanggal Cetak:</strong> {{ now()->format('d M Y') }}<br>
                <strong>Nama Guru:</strong> {{ $student->guru ?? '-' }}
            </td>
        </tr>
    </table>

    <h4>Hasil Penilaian</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Penilaian</th>
                <th>Kode Aspek</th>
                <th>Aspek Perkembangan</th>
                <th>Kategori</th>
                <th>Nilai</th>
                <th>Skor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($r['tgl_penilaian'])->format('d M Y') }}</td>
                    <td>{{ $r['kode_aspek'] }}</td>
                    <td>{{ $r['nama_aspek'] }}</td>
                    <td>{{ $r['kategori'] }}</td>
                    <td>{{ $r['nilai'] }}</td>
                    <td>{{ $r['skor'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Kesimpulan Penilaian</h4>
    <ul>
        <li>BSB (Berkembang Sangat Baik): 4</li>
        <li>BSH (Berkembang Sesuai Harapan): 3</li>
        <li>MB (Mulai Berkembang):2</li>
        <li>BB (Belum Berkembang): 1</li>
    </ul>

    <strong>Rekomendasi Guru:</strong><br>
    Anak menunjukkan perkembangan yang baik secara keseluruhan. Perlu pengayaan dalam eksplorasi fungsi benda dan
    keterampilan berbagi secara konsisten.
</body>

</html>
