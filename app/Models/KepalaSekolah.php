<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class KepalaSekolah extends Authenticatable
{
    use Notifiable;

    protected $table = 'kepala_sekolah';

    protected $primaryKey = 'id_kepalasekolah';

    protected $fillable = [
        'namaKepalaSekolah',
        'nip',
        'email',
        'notlp',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
