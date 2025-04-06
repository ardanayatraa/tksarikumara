<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AkunSiswa extends Model
{
    protected $table = 'akun_siswa';

    protected $primaryKey = 'id_akunsiswa';

    protected $fillable = [
        'id_kelas',
        'nisn',
        'namaSiswa',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat',
        'email',
        'username',
        'password',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'id_akunsiswa');
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'id_akunsiswa');
    }
}
