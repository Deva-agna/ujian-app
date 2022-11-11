<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalBM extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_ajaran_id',
        'user_id',
        'sub_kelas_id',
        'mapel_id',
        'slug',
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function ujian()
    {
        return $this->hasMany(Ujian::class);
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subKelas()
    {
        return $this->belongsTo(SubKelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}
