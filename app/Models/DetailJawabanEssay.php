<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJawabanEssay extends Model
{
    use HasFactory;

    protected $fillable = [
        'jawaban_id',
        'jawaban',
        'gambar',
        'nilai',
        'slug',
    ];

    public function jawaban()
    {
        return $this->belongsTo(Jawaban::class);
    }
}
