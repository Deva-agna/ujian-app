<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'sub_kelas_id',
        'nama',
        'nis',
        'password',
        'view_password',
        'role',
        'status',
        'lulus',
        'slug',
    ];

    public function subKelas()
    {
        return $this->belongsTo(SubKelas::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}
