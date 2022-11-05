<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
    ];

    public function subKelas()
    {
        return $this->hasMany(SubKelas::class);
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }
}
