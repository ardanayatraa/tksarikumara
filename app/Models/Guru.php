<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Authenticatable
{
    use Notifiable;

    protected $table = 'guru';

    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'namaGuru',
        'nip',
        'foto',
        'username',
        'password',
        'email',
        'jenis_kelamin',
        'notlp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
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
