<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    protected $fillable = [
        'soal_id',
        'nilai_id',
    ];

    public function nilai()
    {
        return $this->belongsTo(Nilai::class);
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }

    public function detailJawaban()
    {
        return $this->hasMany(DetailJawaban::class);
    }

    public function detailJawabanEssay()
    {
        return $this->hasOne(DetailJawabanEssay::class);
    }
}
