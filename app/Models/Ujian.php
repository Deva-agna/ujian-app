<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_b_m_id',
        'title',
        'waktu_mulai',
        'waktu_selesai',
        'waktu_ujian',
        'type_ujian',
        'token',
        'status',
        'slug',
    ];

    public function jadwalBM()
    {
        return $this->belongsTo(JadwalBM::class);
    }

    public function detailUjian()
    {
        return $this->hasMany(DetailUjian::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}
