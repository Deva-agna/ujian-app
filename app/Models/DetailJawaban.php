<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJawaban extends Model
{
    use HasFactory;

    protected $fillable = [
        'jawaban_id',
        'detail_soal_id',
        'status',
    ];

    public function detailSoal()
    {
        return $this->belongsTo(DetailSoal::class);
    }
}
