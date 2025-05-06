<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $primaryKey = 'id_notifikasi';

    // jika tabel tidak pakai created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'id_akunsiswa',
        'id_penilaian',
        'id_guru',
        'tgl_pengiriman',
        'status_pengiriman',
    ];

    /**
     * Relasi ke AkunSiswa.
     */
    public function akunSiswa(): BelongsTo
    {
        return $this->belongsTo(AkunSiswa::class, 'id_akunsiswa');
    }

    /**
     * Relasi ke Penilaian.
     */
    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(Penilaian::class, 'id_penilaian');
    }

    /**
     * Relasi ke Guru.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
}
