<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Perkembangan Siswa</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.4; padding: 20px;">
    <h2 style="color: #4A90E2;">Laporan Perkembangan Siswa</h2>

    <p>
        <strong>Nama:</strong> {{ $student->namaSiswa }}<br>
        <strong>Periode:</strong> {{ \Carbon\Carbon::parse($start)->format('d M Y') }} sampai
        {{ \Carbon\Carbon::parse($end)->format('d M Y') }}
    </p>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th style="border: 1px solid #ccc; padding: 8px; text-align:left;">Tanggal</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align:left;">Aspek</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align:center;">Nilai</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align:right;">Skor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $r)
                <tr>
                    <td style="border: 1px solid #ccc; padding: 8px;">
                        {{ \Carbon\Carbon::parse($r['tgl_penilaian'])->format('d M Y') }}
                    </td>
                    <td style="border: 1px solid #ccc; padding: 8px;">
                        {{ $r['nama_aspek'] }}
                    </td>
                    <td style="border: 1px solid #ccc; padding: 8px; text-align:center;">
                        {{ $r['nilai'] }}
                    </td>
                    <td style="border: 1px solid #ccc; padding: 8px; text-align:right;">
                        {{ $r['skor'] }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="border: 1px solid #ccc; padding: 8px; text-align:center; color:#888;">
                        Tidak ada data ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top: 20px;">Terima kasih,<br>{{ config('app.name') }}</p>
</body>

</html>
