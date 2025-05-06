<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NilaiSiswa;

class AspekPenilaian extends Model
{
    use HasFactory;

    // jika nama tabel bukan plural default "aspek_penilaians"
    protected $table = 'aspek_penilaian';

    // primary key
    protected $primaryKey = 'id_aspek';

    public $timestamps = false;

    protected $fillable = [
        'kode_aspek',
        'nama_aspek',
        'kategori',
    ];

    /**
     * Relasi ke detail nilai siswa.
     */
    public function nilaiSiswa()
    {
        return $this->hasMany(NilaiSiswa::class, 'id_aspek', 'id_aspek');
    }
}
