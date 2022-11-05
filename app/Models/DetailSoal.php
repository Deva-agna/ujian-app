<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'soal_id',
        'jawaban',
        'image',
        'kunci_jawaban',
        'slug',
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}
