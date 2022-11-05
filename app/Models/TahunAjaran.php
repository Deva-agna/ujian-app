<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_ajaran',
        'kurikulum',
        'status',
        'slug',
    ];

    public function jadwalBM()
    {
        return $this->hasMany(JadwalBM::class);
    }
}
