<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penilaian;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semester';
    protected $primaryKey = 'id_semester';


    protected $fillable = [
        'nama_semester',
        'tahun_awal',
        'tahun_akhir',
    ];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_semester', 'id_semester');
    }
}
