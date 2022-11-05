<?php

namespace App\Http\Controllers;

use App\Models\DetailSoal;
use App\Models\DetailUjian;
use App\Models\Soal;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SoalController extends Controller
{
    public function index($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();

        $list_s = DetailUjian::where('ujian_id', $ujian->id)->get();

        return view('ujian.list-soal.index', compact('ujian', 'list_s'));
    }

    public function create($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();
        return view('ujian.soal-pg.create', compact('ujian'));
    }

    public function store(Request $request)
    {
        $ujian = Ujian::where('id', $request->ujian_id)->first();

        $imgSoal = "";
        $imgJawabanA = "";
        $imgJawabanB = "";
        $imgJawabanC = "";
        $imgJawabanD = "";

        if ($request->image_soal) {
            $imgSoal = $request->image_soal->getClientOriginalName() . '.' . time() . '.' . $request->image_soal->extension();
            $request->image_soal->move(public_path('soal'), $imgSoal);
        }

        if ($request->image_jawaban_a) {
            $imgJawabanA = $request->image_jawaban_a->getClientOriginalName() . '.' . time() . '.' . $request->image_jawaban_a->extension();
            $request->image_jawaban_a->move(public_path('soal'), $imgJawabanA);
        }

        if ($request->image_jawaban_b) {
            $imgJawabanB = $request->image_jawaban_b->getClientOriginalName() . '.' . time() . '.' . $request->image_jawaban_b->extension();
            $request->image_jawaban_b->move(public_path('soal'), $imgJawabanB);
        }

        if ($request->image_jawaban_c) {
            $imgJawabanC = $request->image_jawaban_c->getClientOriginalName() . '.' . time() . '.' . $request->image_jawaban_c->extension();
            $request->image_jawaban_c->move(public_path('soal'), $imgJawabanC);
        }

        if ($request->image_jawaban_d) {
            $imgJawabanD = $request->image_jawaban_d->getClientOriginalName() . '.' . time() . '.' . $request->image_jawaban_d->extension();
            $request->image_jawaban_d->move(public_path('soal'), $imgJawabanD);
        }

        $soal = Soal::create([
            'jadwal_b_m_id' => $request->jadwalBM_id,
            'soal' => $request->soal,
            'image' => $imgSoal,
            'slug' => Str::of(Str::random(20) . '-' . time())->slug('-'),
        ]);

        $jawabanA = DetailSoal::create([
            'soal_id' => $soal->id,
            'jawaban' => $request->jawaban_a,
            'image' => $imgJawabanA,
            'slug' => Str::of(Str::random(20) . '-' . time())->slug('-'),
        ]);

        $jawabanB = DetailSoal::create([
            'soal_id' => $soal->id,
            'jawaban' => $request->jawaban_b,
            'image' => $imgJawabanB,
            'slug' => Str::of(Str::random(20) . '-' . time())->slug('-'),
        ]);

        $jawabanC = DetailSoal::create([
            'soal_id' => $soal->id,
            'jawaban' => $request->jawaban_c,
            'image' => $imgJawabanC,
            'slug' => Str::of(Str::random(20) . '-' . time())->slug('-'),
        ]);

        $jawabanD = DetailSoal::create([
            'soal_id' => $soal->id,
            'jawaban' => $request->jawaban_d,
            'image' => $imgJawabanD,
            'slug' => Str::of(Str::random(20) . '-' . time())->slug('-'),
        ]);

        if ($request->kunci_jawaban == "a") {
            DetailSoal::where('id', $jawabanA->id)->update([
                'kunci_jawaban' => true
            ]);
        } elseif ($request->kunci_jawaban == "b") {
            DetailSoal::where('id', $jawabanB->id)->update([
                'kunci_jawaban' => true
            ]);
        } elseif ($request->kunci_jawaban == "c") {
            DetailSoal::where('id', $jawabanC->id)->update([
                'kunci_jawaban' => true
            ]);
        } elseif ($request->kunci_jawaban == "d") {
            DetailSoal::where('id', $jawabanD->id)->update([
                'kunci_jawaban' => true
            ]);
        }

        DetailUjian::create([
            'ujian_id' => $request->ujian_id,
            'soal_id' => $soal->id
        ]);

        return redirect()->route('soal.list', $ujian->slug)->with('sukses', 'Data soal berhasil ditambah');
    }

    public function edit($slug)
    {
        $soal = Soal::where('slug', $slug)->first();
        return view('ujian.soal-pg.edit', compact('soal'));
    }

    public function update(Request $request)
    {
        $soal = Soal::where('slug', $request->slug)->first();

        if ($request->image_soal) {
            $file = public_path('soal/') . $request->image_old_soal;
            if (file_exists($file)) {
                @unlink($file);
            }

            $imgSoal = $request->image_soal->getClientOriginalName() . '.' . time() . '.' . $request->image_soal->extension();
            $request->image_soal->move(public_path('soal'), $imgSoal);

            Soal::where('slug', $request->slug)->update([
                'image' => $imgSoal,
            ]);
        }

        if ($request->image_jawaban_a) {

            $file = public_path('soal/') . $request->image_old_jawaban_a;
            if (file_exists($file)) {
                @unlink($file);
            }

            $imgJawabanA = $request->image_jawaban_a->getClientOriginalName() . '.' . time() . '.' . $request->image_jawaban_a->extension();
            $request->image_jawaban_a->move(public_path('soal'), $imgJawabanA);

            DetailSoal::where('id', $request->jawaban_a_id)->update([
                'image' => $imgJawabanA,
            ]);
        }

        if ($request->image_jawaban_b) {

            $file = public_path('soal/') . $request->image_old_jawaban_b;
            if (file_exists($file)) {
                @unlink($file);
            }

            $imgJawabanB = $request->image_jawaban_b->getClientOriginalName() . '.' . time() . '.' . $request->image_jawaban_b->extension();
            $request->image_jawaban_b->move(public_path('soal'), $imgJawabanB);

            DetailSoal::where('id', $request->jawaban_b_id)->update([
                'image' => $imgJawabanB,
            ]);
        }

        if ($request->image_jawaban_c) {

            $file = public_path('soal/') . $request->image_old_jawaban_c;
            if (file_exists($file)) {
                @unlink($file);
            }

            $imgJawabanC = $request->image_jawaban_c->getClientOriginalName() . '.' . time() . '.' . $request->image_jawaban_c->extension();
            $request->image_jawaban_c->move(public_path('soal'), $imgJawabanC);

            DetailSoal::where('id', $request->jawaban_c_id)->update([
                'image' => $imgJawabanC,
            ]);
        }

        if ($request->image_jawaban_d) {

            $file = public_path('soal/') . $request->image_old_jawaban_d;
            if (file_exists($file)) {
                @unlink($file);
            }

            $imgJawabanD = $request->image_jawaban_d->getClientOriginalName() . '.' . time() . '.' . $request->image_jawaban_d->extension();
            $request->image_jawaban_d->move(public_path('soal'), $imgJawabanD);

            DetailSoal::where('id', $request->jawaban_d_id)->update([
                'image' => $imgJawabanD,
            ]);
        }

        Soal::where('slug', $request->slug)->update([
            'soal' => $request->soal,
        ]);

        DetailSoal::where('id', $request->jawaban_a_id)->update([
            'jawaban' => $request->jawaban_a,
            'kunci_jawaban' => false
        ]);

        DetailSoal::where('id', $request->jawaban_b_id)->update([
            'jawaban' => $request->jawaban_b,
            'kunci_jawaban' => false
        ]);

        DetailSoal::where('id', $request->jawaban_c_id)->update([
            'jawaban' => $request->jawaban_c,
            'kunci_jawaban' => false
        ]);

        DetailSoal::where('id', $request->jawaban_d_id)->update([
            'jawaban' => $request->jawaban_d,
            'kunci_jawaban' => false
        ]);

        if ($request->kunci_jawaban == "a") {
            DetailSoal::where('id', $request->jawaban_a_id)->update([
                'kunci_jawaban' => true
            ]);
        } elseif ($request->kunci_jawaban == "b") {
            DetailSoal::where('id', $request->jawaban_b_id)->update([
                'kunci_jawaban' => true
            ]);
        } elseif ($request->kunci_jawaban == "c") {
            DetailSoal::where('id', $request->jawaban_c_id)->update([
                'kunci_jawaban' => true
            ]);
        } elseif ($request->kunci_jawaban == "d") {
            DetailSoal::where('id', $request->jawaban_d_id)->update([
                'kunci_jawaban' => true
            ]);
        }

        return redirect()->route('soal.list', $soal->detailUjian[0]->ujian->slug)->with('sukses', 'Data soal berhasil diupdate');
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

            return redirect()->route('soal.edit', $soal->slug);
        }

        if ($detailSoal) {
            $file = public_path('soal/') . $detailSoal->image;
            if ($file) {
                @unlink($file);
            }

            DetailSoal::where('id', $detailSoal->id)->update([
                'image' => ""
            ]);

            return redirect()->route('soal.edit', $detailSoal->soal->slug);
        }
    }
}
