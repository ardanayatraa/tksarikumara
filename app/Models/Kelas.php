<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $primaryKey = 'id_kelas';

    protected $fillable = [
        'namaKelas',
        'tahunAjaran',
        'jumlahSiswa',
    ];

    public function akunSiswa(): HasMany
    {
        return $this->hasMany(AkunSiswa::class, 'id_kelas');
    }
}
