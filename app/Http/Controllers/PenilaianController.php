<?php

namespace App\Http\Controllers;

use App\Models\DetailJawaban;
use App\Models\DetailJawabanEssay;
use App\Models\Nilai;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function penilaianPg(Request $request)
    {
        $nilai = Nilai::where('id', $request->nilai_id)->first();

        if ($nilai->status) {
            return redirect()->route('ujian.done');
        } else {
            $benar = 0;
            $salah = 0;
            for ($i = 0; $i < count($request->jawaban); $i++) {
                if ($check = DetailJawaban::where('id', $request->jawaban[$i])->first()) {
                    if ($check->detailSoal->kunci_jawaban) {
                        $benar += 1;
                    } else {
                        $salah += 1;
                    }
                } else {
                    $salah += 1;
                }
                DetailJawaban::where('id', $request->jawaban[$i])->update([
                    'status' => true,
                ]);
            }

            $hasil = ($benar / count($request->jawaban)) * 100;

            Nilai::where('id', $request->nilai_id)->update([
                'status' => true,
                'nilai' => $hasil,
                'benar' => $benar,
                'salah' => $salah,
            ]);

            return redirect()->route('ujian.done');
        }
    }

    public function penilaianMc(Request $request)
    {
        if ($request->jawaban) {
            $nilai = Nilai::where('id', $request->nilai_id)->first();

            if ($nilai->status) {
                return redirect()->route('ujian.done');
            } else {
                $benar = 0;
                $salah = 0;
                for ($i = 0; $i < count($request->jawaban); $i++) {
                    $check = DetailJawaban::where('id', $request->jawaban[$i])->first();
                    if ($check->detailSoal->kunci_jawaban) {
                        $benar += 1;
                    }

                    DetailJawaban::where('id', $request->jawaban[$i])->update([
                        'status' => true,
                    ]);
                }
                $salah = $request->jumlah_soal - $benar;
                $hasil = ($benar / $request->jumlah_soal) * 100;

                Nilai::where('id', $request->nilai_id)->update([
                    'status' => true,
                    'nilai' => number_format($hasil, 2),
                    'benar' => $benar,
                    'salah' => $salah,
                ]);

                return redirect()->route('ujian.done');
            }
        } else {
            Nilai::where('id', $request->nilai_id)->update([
                'status' => true,
                'nilai' => '0',
                'benar' => '0',
                'salah' => $request->jumlah_soal,
            ]);

            return redirect()->route('ujian.done');
        }
    }

    public function penilaianEssay(Nilai $nilai)
    {
        $nilai = $nilai->load('siswa.subKelas.kelas', 'ujian');
        return view('ujian.log.penilaian-essay', compact('nilai'));
    }

    public function penilaianEssayStore(Request $request)
    {
        $request->validate([
            'nilai.*' => 'required',
        ], [
            'nilai.*.required' => 'Nilai tidak boleh kosong!',
        ]);

        $nilai = 0;

        for ($i = 0; $i < count($request->nilai); $i++) {
            $nilai += $request->nilai[$i];
        }

        if ($nilai > 100) {
            return redirect()->back()->with('error', 'Nilai melebihi ketentuan. Nilai keseluruhan maksimal 100. Harap isi kembali nilai dengan benar!');
        }

        for ($i = 0; $i < count($request->nilai); $i++) {
            DetailJawabanEssay::where('id', $request->detail_jawaban_essay_id[$i])->update([
                'nilai' => $request->nilai[$i],
            ]);
        }

        Nilai::where('id', $request->nilai_id)->update([
            'nilai' => $nilai,
        ]);

        $nilai = Nilai::where('id', $request->nilai_id)->first();

        return redirect()->back()->with('sukses', 'Nilai berhasil dimasukan');
    }
}
