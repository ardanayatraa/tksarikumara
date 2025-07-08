<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiSiswa extends Model
{
    protected $table = 'nilai_siswa';

    protected $primaryKey = 'id_nilai';

    public $timestamps = false;

    protected $fillable = [
        'id_penilaian',
        'indikator_aspek_id',
        'nilai',
        'skor',
        'catatan',
    ];

    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(Penilaian::class, 'id_penilaian', 'id_penilaian');
    }

    public function indikator(): BelongsTo
    {
        return $this->belongsTo(IndikatorAspek::class, 'indikator_aspek_id', 'id');
    }
}
