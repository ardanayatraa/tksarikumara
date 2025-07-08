<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tabel Penilaian Individu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        h3 {
            background-color: #cfe2ff;
            padding: 8px;
            font-size: 14px;
            page-break-after: avoid;
        }

        h4 {
            page-break-after: avoid;
            margin-top: 16px;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            page-break-inside: avoid;
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
            page-break-inside: avoid;
        }

        ul li {
            margin-bottom: 4px;
        }

        /* Prevent page breaks */
        .keep-together {
            page-break-inside: avoid;
        }

        .section {
            page-break-inside: avoid;
            margin-bottom: 20px;
        }

        /* Header info always stays together */
        .header-info {
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        /* Main results table */
        .results-table {
            page-break-inside: auto;
        }

        .results-table tbody tr {
            page-break-inside: avoid;
        }

        /* Keep conclusion and recommendations together if possible */
        .conclusion-section {
            page-break-inside: avoid;
        }

        /* Force new page if needed */
        .new-page {
            page-break-before: always;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="header-info">
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
            <tr>
                <td><strong>Periode</strong></td>
                <td colspan="3">:
                    @php
                        $bulanNama = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember',
                        ];
                    @endphp
                    {{ $bulanNama[$month] ?? $month }} {{ $year }} - Minggu ke-{{ $week }}
                    @if ($start && $end)
                        ({{ \Carbon\Carbon::parse($start)->format('d M') }} -
                        {{ \Carbon\Carbon::parse($end)->format('d M Y') }})
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h4>Hasil Penilaian</h4>
        <table class="results-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Aspek</th>
                    <th>Aspek Penilaian</th>
                    <th>Indikator</th>
                    <th>Skor Total</th>
                    <th>Skala</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalKategori = ['BSB' => 0, 'BSH' => 0, 'MB' => 0, 'BB' => 0];
                @endphp

                @foreach ($rekap as $index => $aspek)
                    @php
                        $skor = $aspek['skor'] ?? 0;
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
                                @foreach (array_unique($aspek['indikator']) as $indikator)
                                    <li>{{ $indikator }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ number_format($skor, 1) }}</td>
                        <td>{{ $skala }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="conclusion-section">
        <h4>Kesimpulan Penilaian</h4>
        <ul class="keep-together">
            <li><strong>BSB (Berkembang Sangat Baik):</strong> {{ $totalKategori['BSB'] }} aspek</li>
            <li><strong>BSH (Berkembang Sesuai Harapan):</strong> {{ $totalKategori['BSH'] }} aspek</li>
            <li><strong>MB (Mulai Berkembang):</strong> {{ $totalKategori['MB'] }} aspek</li>
            <li><strong>BB (Belum Berkembang):</strong> {{ $totalKategori['BB'] }} aspek</li>
        </ul>

        <h4>Rekomendasi Guru</h4>
        <div class="keep-together">
            @php
                $rekomendasi = [
                    'BSB' =>
                        'Pertahankan dan kembangkan kemampuan yang sudah sangat baik ini. Anak dapat menjadi contoh bagi teman-temannya.',
                    'BSH' =>
                        'Kemampuan sudah berkembang dengan baik sesuai harapan. Lanjutkan dengan stimulasi yang konsisten.',
                    'MB' =>
                        'Berikan stimulasi lebih intensif dan bervariasi. Gunakan metode pembelajaran yang menyenangkan dan sesuai minat anak.',
                    'BB' =>
                        'Perlu perhatian khusus dan stimulasi yang lebih intensif. Konsultasikan dengan orangtua untuk program stimulasi di rumah.',
                ];
            @endphp

            @foreach ($totalKategori as $skala => $jumlah)
                @if ($jumlah > 0)
                    <p><strong>{{ $skala }}:</strong> {{ $rekomendasi[$skala] }}</p>
                @endif
            @endforeach
        </div>

        <div class="keep-together" style="margin-top: 30px;">
            <p><strong>Catatan:</strong></p>
            <ul>
                <li>Skor Total adalah jumlah nilai dari semua indikator dalam aspek tersebut</li>
                <li>Skala Penilaian: BSB (≥3.5), BSH (2.5-3.4), MB (1.5-2.4), BB (<1.5)< /li>
                <li>Laporan ini mencakup penilaian minggu ke-{{ $week }} bulan
                    {{ $bulanNama[$month] ?? $month }} {{ $year }}</li>
            </ul>
        </div>
    </div>
</body>

</html>
