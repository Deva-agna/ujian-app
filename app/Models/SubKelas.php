<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id',
        'kode_sub_kelas',
        'sub_kelas',
        'slug',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function jadwalBM()
    {
        return $this->hasMany(JadwalBM::class);
    }
}
