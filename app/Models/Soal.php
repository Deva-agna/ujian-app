<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $fillable = [
        'mapel_id',
        'kelas_id',
        'title',
        'soal',
        'image',
        'type_soal',
        'status_update',
        'slug',
    ];

    public function detailUjian()
    {
        return $this->hasMany(DetailUjian::class);
    }

    public function detailSoal()
    {
        return $this->hasMany(DetailSoal::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
