<?php

namespace App\Http\Controllers;

use App\Models\DetailSoal;
use App\Models\DetailUjian;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DetailUjianController extends Controller
{
    public function storeSoal(Request $request)
    {
        DetailUjian::create([
            'ujian_id' => $request->ujian_id,
            'soal_id' => $request->soal_id,
        ]);

        return redirect()->back()->with('sukses', 'Soal berhasil ditambahkan!');
    }

    public function duplikatSoal(Request $request)
    {
        $soal = Soal::where('id', $request->soal_id)->first();

        $newNameImageSoal = "";
        if ($soal->image) {
            $oldPathSoalImage = public_path('soal/') . $soal->image;
            $fileExtension = File::extension($oldPathSoalImage);
            $newNameImageSoal = Str::random(20) . '.' . time() . ' . ' . $fileExtension;
            $newPathWithName = public_path('soal/') .  $newNameImageSoal;
            File::copy($oldPathSoalImage, $newPathWithName);
        }

        $soalDuplikat = Soal::create([
            'jadwal_b_m_id' => $soal->jadwal_b_m_id,
            'mapel_id' => $soal->mapel_id,
            'kelas_id' => $soal->kelas_id,
            'title' => $soal->title,
            'soal' => $soal->soal,
            'image' => $newNameImageSoal,
            'type_soal' => $soal->type_soal,
            'slug' => Str::of(Str::random(20) . '-' . time())->slug('-'),
        ]);

        foreach ($soal->detailSoal as $jawaban) {

            $newNameImageJawaban = "";
            if ($jawaban->image) {
                $oldPathJawabanImage = public_path('soal/') . $jawaban->image;
                $fileExtension = File::extension($oldPathJawabanImage);
                $newNameImageJawaban = Str::random(20) . '.' . time() . ' . ' . $fileExtension;
                $newPathWithName = public_path('soal/') .  $newNameImageJawaban;
                File::copy($oldPathJawabanImage, $newPathWithName);
            }

            DetailSoal::create([
                'soal_id' => $soalDuplikat->id,
                'jawaban' => $jawaban->jawaban,
                'image' => $newNameImageJawaban,
                'kunci_jawaban' => $jawaban->kunci_jawaban,
                'slug' => Str::of(Str::random(20) . '-' . time())->slug('-'),
            ]);
        }

        DetailUjian::create([
            'ujian_id' => $request->ujian_id,
            'soal_id' => $soalDuplikat->id,
        ]);

        return redirect()->back()->with('sukses', 'Soal berhasil diduplikat!');
    }

    public function destroyList(Request $request)
    {
        $soal = Soal::where('slug', $request->slug_soal)->first();
        $detailUjian = DetailUjian::where('soal_id', $soal->id)->first();

        if ($soal->status_update) {
            $file = public_path('soal/') . $soal->image;
            if ($file) {
                @unlink($file);
            }
            DetailUjian::destroy($detailUjian->id);
            foreach ($soal->detailSoal as $data) {
                if ($fileJawaban = public_path('soal/') . $data->image) {
                    @unlink($fileJawaban);
                }
                DetailSoal::destroy($data->id);
            }
            Soal::destroy($soal->id);
        } else {
            DetailUjian::destroy($detailUjian->id);
        }

        return redirect()->back()->with('sukses', 'Soal berhasil dihapus dari list!');
    }
}
