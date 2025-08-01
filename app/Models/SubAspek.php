<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAspek extends Model
{
    use HasFactory;

    protected $table = 'sub_aspek';
    protected $primaryKey = 'id_sub_aspek';

    protected $fillable = [
        'aspek_id',
        'kode_sub_aspek',
        'nama_sub_aspek',
        'deskripsi',
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

    // Relasi ke Indikator
    public function indikator()
    {
        return $this->hasMany(Indikator::class, 'sub_aspek_id', 'id_sub_aspek');
    }

    // Relasi ke Indikator yang aktif
    public function indikatorAktif()
    {
        return $this->indikator()->where('is_active', true);
    }

    // Scope untuk sub aspek aktif
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor untuk nama lengkap
    public function getNamaLengkapAttribute()
    {
        return $this->kode_sub_aspek . '. ' . $this->nama_sub_aspek;
    }

    // Accessor untuk kode lengkap (dengan aspek)
    public function getKodeLengkapAttribute()
    {
        return $this->aspekPenilaian->kode_aspek . '.' . $this->kode_sub_aspek;
    }
}
