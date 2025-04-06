<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    protected $table = 'guru';

    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'namaGuru',
        'nip',
        'username',
        'password',
        'email',
        'jenis_kelamin',
        'notlp',
    ];

    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'id_guru');
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'id_guru');
    }
}
