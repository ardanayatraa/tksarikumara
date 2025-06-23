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
        'indikator_aspek_id',
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

     // relasi ke IndikatorAspek (child)
    public function indikator(): BelongsTo
    {
        return $this->belongsTo(IndikatorAspek::class, 'indikator_aspek_id');
    }
}
