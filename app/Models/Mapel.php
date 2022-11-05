<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_mapel',
        'slug',
    ];

    public function jadwalBM()
    {
        return $this->hasMany(JadwalBM::class);
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }
}
