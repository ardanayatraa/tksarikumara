<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'id_akunsiswa',
        'id_penilaian',
        'id_guru',
        'tgl_penilaian',
        'status_pengiriman',
    ];

    public function akunSiswa(): BelongsTo
    {
        return $this->belongsTo(AkunSiswa::class, 'id_akunsiswa');
    }

    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(Penilaian::class, 'id_penilaian');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
}
