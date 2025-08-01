<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Pastikan ini ada untuk Str::substr

class AspekPenilaian extends Model
{
    use HasFactory;

    protected $table = 'aspek_penilaian';
    protected $primaryKey = 'id_aspek';

    protected $fillable = [
        'kode_aspek',
        'nama_aspek',
        'has_sub_aspek',
        'deskripsi',
        'is_active' // Ditambahkan kembali
    ];

    protected $casts = [
        'has_sub_aspek' => 'boolean',
        'is_active' => 'boolean' // Ditambahkan kembali
    ];

    // Event untuk generate kode aspek otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->generateKodeAspek();
        });

        static::updating(function ($model) {
            if ($model->isDirty('nama_aspek')) {
                $model->generateKodeAspek();
            }
        });
    }

    /**
     * Generate kode aspek berdasarkan nama aspek
     */
    protected function generateKodeAspek()
    {
        if (!$this->nama_aspek) {
            $this->kode_aspek = '';
            return;
        }
        // Ambil kata pertama dari nama aspek
        $first = explode(' ', trim($this->nama_aspek))[0];
        $singkatan = strtoupper(Str::substr($first, 0, 3));
        $tahun = now()->year;
        $this->kode_aspek = $singkatan . $tahun;
    }

    /**
     * Relasi ke SubAspek
     */
    public function subAspek()
    {
        return $this->hasMany(SubAspek::class, 'aspek_id', 'id_aspek');
    }

    /**
     * Relasi ke Indikator (langsung tanpa sub aspek)
     */
    public function indikator()
    {
        return $this->hasMany(Indikator::class, 'aspek_id', 'id_aspek');
    }

    /**
     * Relasi ke Indikator yang aktif
     */
    public function indikatorAktif()
    {
        return $this->indikator()->where('is_active', true);
    }

    /**
     * Scope untuk aspek aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Accessor untuk nama lengkap
     */
    public function getNamaLengkapAttribute()
    {
        return $this->kode_aspek . '. ' . $this->nama_aspek;
    }
}
