<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    use HasFactory;

    protected $table = 'indikator';
    protected $primaryKey = 'id_indikator';

    protected $fillable = [
        'aspek_id',
        'sub_aspek_id',
        'kode_indikator',
        'deskripsi_indikator',
        'kelompok_usia',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relasi ke AspekPenilaian
    public function aspekPenilaian()
    {
        return $this->belongsTo(AspekPenilaian::class, 'aspek_id', 'id_aspek');
    }

    // Relasi ke SubAspek
    public function subAspek()
    {
        return $this->belongsTo(SubAspek::class, 'sub_aspek_id', 'id_sub_aspek');
    }

    // Relasi ke NilaiSiswa
    public function nilaiSiswa()
    {
        return $this->hasMany(NilaiSiswa::class, 'indikator_id', 'id_indikator');
    }

    // Scope untuk kelompok usia
    public function scopeKelompokUsia($query, $usia)
    {
        return $query->where('kelompok_usia', $usia);
    }

    // Scope untuk indikator aktif
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor untuk kode lengkap
    public function getKodeLengkapAttribute()
    {
        $kode = $this->aspekPenilaian->kode_aspek;

        if ($this->subAspek) {
            $kode .= '.' . $this->subAspek->kode_sub_aspek;
        }

        $kode .= '.' . $this->kode_indikator;

        return $kode;
    }

    // Accessor untuk nama lengkap dengan hierarki
    public function getNamaLengkapAttribute()
    {
        $nama = $this->aspekPenilaian->nama_aspek;

        if ($this->subAspek) {
            $nama .= ' - ' . $this->subAspek->nama_sub_aspek;
        }

        return $nama;
    }

    // Method untuk mendapatkan label kelompok usia
    public function getKelompokUsiaLabelAttribute()
    {
        return $this->kelompok_usia === '2-3_tahun' ? '2-3 Tahun' : '3-4 Tahun';
    }
}
