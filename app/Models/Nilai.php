<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'ujian_id',
        'siswa_id',
        'start',
        'end',
        'keterlambatan',
        'nilai',
        'benar',
        'salah',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }
}
