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
            text-align: left;
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
    <h3 style="text-align: center;">Penilaian Perkembangan Anak</h3>

    <table class="no-border mb-4">
        <tr>
            <td class="no-border">
                <strong>Nama Anak:</strong> {{ $student->namaSiswa }}<br>
                <strong>Usia:</strong>
                @php
                    $usia = \Carbon\Carbon::parse($student->tgl_lahir)->age . ' tahun';
                @endphp
                {{ $usia }}<br>
                <strong>Periode Penilaian:</strong>
                {{ \Carbon\Carbon::parse($start)->format('d M Y') }}
                s/d
                {{ \Carbon\Carbon::parse($end)->format('d M Y') }}<br>
                <strong>Tanggal Cetak:</strong> {{ now()->format('d M Y') }}<br>
                <strong>Nama Guru:</strong>
                @if (isset($student->penilaian[0]->guru->namaGuru))
                    {{ $student->penilaian[0]->guru->namaGuru }}
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <h4>Hasil Penilaian</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Aspek</th>
                <th>Aspek Perkembangan</th>
                <th>Kode Indikator</th>
                <th>Indikator</th>
                <th>Kategori</th>
                <th>Nilai</th>
                <th>Skor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $idx => $r)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($r['tgl_penilaian'])->format('d M Y') }}</td>
                    <td>{{ $r['kode_aspek'] }}</td>
                    <td>{{ $r['nama_aspek'] }}</td>
                    <td>{{ $r['kode_indikator'] }}</td>
                    <td>{{ $r['nama_indikator'] }}</td>
                    <td>{{ $r['kategori'] }}</td>
                    <td>{{ $r['nilai'] }}</td>
                    <td>{{ $r['skor'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Kesimpulan Penilaian</h4>
    <ul>
        <li>BSB (Berkembang Sangat Baik): <strong>{{ $summary['BSB'] }}</strong></li>
        <li>BSH (Berkembang Sesuai Harapan): <strong>{{ $summary['BSH'] }}</strong></li>
        <li>MB (Mulai Berkembang): <strong>{{ $summary['MB'] }}</strong></li>
        <li>BB (Belum Berkembang): <strong>{{ $summary['BB'] }}</strong></li>
    </ul>

    <strong>Rekomendasi Guru:</strong>
    <p>
        Anak menunjukkan perkembangan yang baik secara keseluruhan.
        Perlu pengayaan dalam eksplorasi fungsi benda dan keterampilan berbagi secara konsisten.
    </p>
</body>

</html>
