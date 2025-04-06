<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiSiswa extends Model
{
    protected $table = 'nilai_siswa';

    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'id_penilaian',
        'aspek_penilaian',
        'kategori',
        'skor',
    ];

    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(Penilaian::class, 'id_penilaian');
    }
}
