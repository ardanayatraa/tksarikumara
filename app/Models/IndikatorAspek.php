<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorAspek extends Model
{
    protected $table = 'indikator_aspek';
    protected $fillable = ['aspek_id','kode_indikator','nama_indikator','min_umur','max_umur','bobot'];

    public function aspek()
    {
        return $this->belongsTo(AspekPenilaian::class, 'aspek_id', 'id_aspek');
    }
}
