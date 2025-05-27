<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiSiswa extends Model
{
    protected $table = 'nilai_siswa';

    protected $primaryKey = 'id_nilai';

    // tidak pakai timestamps
    public $timestamps = false;

    protected $fillable = [
        'id_penilaian',
        'id_aspek',
        'nilai',
        'skor',
        'catatan',
    ];

    /**
     * Relasi ke Penilaian (header).
     */
    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(Penilaian::class, 'id_penilaian');
    }

    /**
     * Relasi ke AspekPenilaian (master aspek).
     */
    public function aspek(): BelongsTo
    {
        return $this->belongsTo(AspekPenilaian::class, 'id_aspek');
    }
}
