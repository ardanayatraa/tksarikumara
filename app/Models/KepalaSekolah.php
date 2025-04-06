<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepalaSekolah extends Model
{
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
}
