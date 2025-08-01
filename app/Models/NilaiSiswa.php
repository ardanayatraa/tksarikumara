<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSiswa extends Model
{
    use HasFactory;

    protected $table = 'nilai_siswa';
    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'penilaian_id',
        'indikator_id',
        'nilai',
        'skor',
        'catatan'
    ];

    protected $casts = [
        'skor' => 'integer'
    ];

    // Konstanta untuk nilai
    const NILAI_BB = 'BB';   // Belum Berkembang
    const NILAI_MB = 'MB';   // Mulai Berkembang
    const NILAI_BSH = 'BSH'; // Berkembang Sesuai Harapan
    const NILAI_BSB = 'BSB'; // Berkembang Sangat Baik

    // Konstanta untuk skor
    const SKOR_BB = 1;
    const SKOR_MB = 2;
    const SKOR_BSH = 3;
    const SKOR_BSB = 4;

    // Relasi ke Penilaian
    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'penilaian_id', 'id_penilaian');
    }

    // Relasi ke Indikator
    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'indikator_id', 'id_indikator');
    }

    // Method untuk konversi nilai ke skor
    public static function konversiNilaiKeScore($nilai)
    {
        $mapping = [
            self::NILAI_BB => self::SKOR_BB,
            self::NILAI_MB => self::SKOR_MB,
            self::NILAI_BSH => self::SKOR_BSH,
            self::NILAI_BSB => self::SKOR_BSB,
        ];

        return $mapping[$nilai] ?? self::SKOR_BB;
    }

    // Method untuk konversi skor ke nilai
    public static function konversiSkorKeNilai($skor)
    {
        $mapping = [
            self::SKOR_BB => self::NILAI_BB,
            self::SKOR_MB => self::NILAI_MB,
            self::SKOR_BSH => self::NILAI_BSH,
            self::SKOR_BSB => self::NILAI_BSB,
        ];

        return $mapping[$skor] ?? self::NILAI_BB;
    }

    // Accessor untuk deskripsi nilai
    public function getNilaiDeskripsiAttribute()
    {
        $deskripsi = [
            self::NILAI_BB => 'Belum Berkembang',
            self::NILAI_MB => 'Mulai Berkembang',
            self::NILAI_BSH => 'Berkembang Sesuai Harapan',
            self::NILAI_BSB => 'Berkembang Sangat Baik',
        ];

        return $deskripsi[$this->nilai] ?? '';
    }

    // Mutator untuk otomatis set skor ketika nilai diubah
    public function setNilaiAttribute($value)
    {
        $this->attributes['nilai'] = $value;
        $this->attributes['skor'] = self::konversiNilaiKeScore($value);
    }

    // Scope untuk nilai tertentu
    public function scopeNilai($query, $nilai)
    {
        return $query->where('nilai', $nilai);
    }

    // Scope untuk skor minimum
    public function scopeSkorMinimal($query, $skor)
    {
        return $query->where('skor', '>=', $skor);
    }

    // Method untuk mendapatkan warna badge berdasarkan nilai
    public function getWarnaBadgeAttribute()
    {
        $warna = [
            self::NILAI_BB => 'danger',   // Merah
            self::NILAI_MB => 'warning',  // Kuning
            self::NILAI_BSH => 'info',    // Biru
            self::NILAI_BSB => 'success', // Hijau
        ];

        return $warna[$this->nilai] ?? 'secondary';
    }
}
