<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';
    protected $primaryKey = 'id_penilaian';

    protected $fillable = [
        'id_akunsiswa',
        'id_guru',
        'id_kelas',
        'tgl_penilaian',
        'kelompok_usia_siswa',
        'status',
        'catatan_umum'
    ];

    protected $casts = [
        'tgl_penilaian' => 'date'
    ];

    // Relasi ke NilaiSiswa
    public function nilaiSiswa()
    {
        return $this->hasMany(NilaiSiswa::class, 'penilaian_id', 'id_penilaian');
    }

    // Relasi ke Guru (sesuaikan dengan model yang ada)
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    // Relasi ke Kelas (sesuaikan dengan model yang ada)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    // Method untuk mendapatkan total skor
    public function getTotalSkorAttribute()
    {
        return $this->nilaiSiswa->sum('skor');
    }

    // Method untuk mendapatkan rata-rata skor
    public function getRataSkorAttribute()
    {
        $nilaiSiswa = $this->nilaiSiswa;
        return $nilaiSiswa->count() > 0 ? $nilaiSiswa->avg('skor') : 0;
    }

    // Method untuk mendapatkan jumlah indikator
    public function getJumlahIndikatorAttribute()
    {
        return $this->nilaiSiswa->count();
    }

    // Scope untuk status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk kelompok usia
    public function scopeKelompokUsia($query, $usia)
    {
        return $query->where('kelompok_usia_siswa', $usia);
    }

    // Method untuk finalisasi penilaian
    public function finalisasi()
    {
        $this->update(['status' => 'final']);
    }

    // Method untuk kembalikan ke draft
    public function kembalikanKeDraft()
    {
        $this->update(['status' => 'draft']);
    }
}
