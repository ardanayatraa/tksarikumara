<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penilaian extends Model
{
    protected $table = 'penilaian';

    protected $primaryKey = 'id_penilaian';

    protected $fillable = [
        'id_akunsiswa',
        'id_guru',
        'id_kelas',
        'tgl_penilaian',
        'minggu_ke',
        'semester',
        'tahun_ajaran',
    ];

    public function akunSiswa(): BelongsTo
    {
        return $this->belongsTo(AkunSiswa::class, 'id_akunsiswa', 'id_akunsiswa');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function nilaiSiswa(): HasMany
    {
        return $this->hasMany(NilaiSiswa::class, 'id_penilaian', 'id_penilaian');
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'id_penilaian', 'id_penilaian');
    }
}
