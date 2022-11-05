<?php

namespace App\Http\Controllers;

use App\Models\DetailSoal;
use App\Models\Soal;
use Illuminate\Http\Request;

class DetailSoalController extends Controller
{
    public function listJawaban($slug)
    {
        $soal = Soal::where('slug', $slug)->first();

        return view('ujian.soal-mc.list-jawaban', compact('soal'));
    }

    public function destroyListJawaban(Request $request)
    {
        $jawaban = DetailSoal::where('slug', $request->detail_slug)->first();

        $file = public_path('soal/') . $jawaban->image;
        if (file_exists($file)) {
            @unlink($file);
        }

        DetailSoal::destroy($jawaban->id);

        return redirect()->back()->with('sukses', 'Jawaban berhasil dihapus');
    }

    public function destroyImage($slug)
    {

        $soal = Soal::where('slug', $slug)->first();
        $detailSoal = DetailSoal::where('slug', $slug)->first();

        if ($soal) {
            $file = public_path('soal/') . $soal->image;
            if ($file) {
                @unlink($file);
            }

            Soal::where('id', $soal->id)->update([
                'image' => ""
            ]);

            return redirect()->back()->with('sukses', 'Gambar berhasil dihapus');
        }

        if ($detailSoal) {
            $file = public_path('soal/') . $detailSoal->image;
            if ($file) {
                @unlink($file);
            }

            DetailSoal::where('id', $detailSoal->id)->update([
                'image' => ""
            ]);

            return redirect()->back()->with('sukses', 'Gambar berhasil dihapus');
        }
    }
}
