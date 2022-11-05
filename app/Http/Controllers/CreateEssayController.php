<?php

namespace App\Http\Controllers;

use App\Models\DetailJawabanEssay;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreateEssayController extends Controller
{
    public function store(Request $request)
    {
        for ($i = 0; $i < count($request->jawaban); $i++) {
            $gambar = "";
            if ($request->cek_gambar[$i]) {
                $gambar = $request->gambar[$i]->getClientOriginalName() . '.' . time() . '.' . $request->gambar[$i]->extension();
                $request->gambar[$i]->move(public_path('gambar-jawaban'), $gambar);
            }

            DetailJawabanEssay::where('jawaban_id', $request->jawaban_id[$i])->update([
                'jawaban' => $request->jawaban[$i],
                'gambar' => $gambar,
            ]);
        }

        Nilai::where('id', $request->nilai_id)->update([
            'status' => true,
            'keterlambatan' => $request->keterlambatan,
        ]);

        return view('page.ujian-done');
    }
}
