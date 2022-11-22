<?php

namespace App\Http\Controllers;

use App\Models\DetailSoal;
use App\Models\DetailUjian;
use App\Models\Soal;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SoalPilihanGandaController extends Controller
{
    public function index($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();

        $list_s = DetailUjian::where('ujian_id', $ujian->id)->get();

        return view('ujian.soal-pg.index', compact('ujian', 'list_s'));
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
            $imgSoal = Str::random(10) . '.' . time() . '.' . $request->image_soal->extension();
            $request->image_soal->move(public_path('soal'), $imgSoal);
        }

        if ($request->image_jawaban_a) {
            $imgJawabanA = Str::random(10) . '.' . time() . '.' . $request->image_jawaban_a->extension();
            $request->image_jawaban_a->move(public_path('soal'), $imgJawabanA);
        }

        if ($request->image_jawaban_b) {
            $imgJawabanB = Str::random(10) . '.' . time() . '.' . $request->image_jawaban_b->extension();
            $request->image_jawaban_b->move(public_path('soal'), $imgJawabanB);
        }

        if ($request->image_jawaban_c) {
            $imgJawabanC = Str::random(10) . '.' . time() . '.' . $request->image_jawaban_c->extension();
            $request->image_jawaban_c->move(public_path('soal'), $imgJawabanC);
        }

        if ($request->image_jawaban_d) {
            $imgJawabanD = Str::random(10) . '.' . time() . '.' . $request->image_jawaban_d->extension();
            $request->image_jawaban_d->move(public_path('soal'), $imgJawabanD);
        }

        $soal = Soal::create([
            'jadwal_b_m_id' => $request->jadwalBM_id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'title' => $request->deskripsi,
            'soal' => $request->soal,
            'image' => $imgSoal,
            'type_soal' => 'pg',
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

        return redirect()->route('soal.pg.list', $ujian->slug)->with('sukses', 'Data soal berhasil ditambah');
    }

    public function edit($slug)
    {
        $soal = Soal::with('detailSoal')->where('slug', $slug)->first();
        return view('ujian.soal-pg.edit', compact('soal'));
    }

    public function update(Request $request)
    {
        $soal = Soal::where('slug', $request->slug)->first();
        $imgSoal = $soal->image;

        if ($request->image_soal) {
            $file = public_path('soal/') . $soal->image;
            if (file_exists($file)) {
                @unlink($file);
            }
            $imgSoal = Str::random(10) . '.' . time() . '.' . $request->image_soal->extension();
            $request->image_soal->move(public_path('soal'), $imgSoal);
        } else {
            if ($request->image_old_soal == "") {
                $file = public_path('soal/') . $soal->image;
                if (file_exists($file)) {
                    @unlink($file);
                    $imgSoal = "";
                }
            }
        }
        Soal::where('slug', $request->slug)->update([
            'title' => $request->deskripsi,
            'soal' => $request->soal,
            'image' => $imgSoal,
        ]);

        $jawabanA = DetailSoal::where('id', $request->jawaban_a_id)->first();
        $imgJawabanA = $jawabanA->image;
        if ($request->image_jawaban_a) {
            $file = public_path('soal/') . $jawabanA->image;
            if (file_exists($file)) {
                @unlink($file);
            }
            $imgJawabanA = Str::random(10) . '.' . time() . '.' . $request->image_jawaban_a->extension();
            $request->image_jawaban_a->move(public_path('soal'), $imgJawabanA);
        } else {
            if ($request->image_old_jawaban_a == "") {
                $file = public_path('soal/') . $jawabanA->image;
                if (file_exists($file)) {
                    @unlink($file);
                    $imgJawabanA = "";
                }
            }
        }

        DetailSoal::where('id', $jawabanA->id)->update([
            'jawaban' => $request->jawaban_a,
            'kunci_jawaban' => false,
            'image' => $imgJawabanA,
        ]);

        $jawabanB = DetailSoal::where('id', $request->jawaban_b_id)->first();
        $imgJawabanB = $jawabanB->image;
        if ($request->image_jawaban_b) {
            $file = public_path('soal/') . $jawabanB->image;
            if (file_exists($file)) {
                @unlink($file);
            }
            $imgJawabanB = Str::random(10) . '.' . time() . '.' . $request->image_jawaban_b->extension();
            $request->image_jawaban_b->move(public_path('soal'), $imgJawabanB);
        } else {
            if ($request->image_old_jawaban_b == "") {
                $file = public_path('soal/') . $jawabanB->image;
                if (file_exists($file)) {
                    @unlink($file);
                    $imgJawabanB = "";
                }
            }
        }

        DetailSoal::where('id', $jawabanB->id)->update([
            'jawaban' => $request->jawaban_b,
            'kunci_jawaban' => false,
            'image' => $imgJawabanB,
        ]);

        $jawabanC = DetailSoal::where('id', $request->jawaban_c_id)->first();
        $imgJawabanC = $jawabanC->image;
        if ($request->image_jawaban_c) {
            $file = public_path('soal/') . $jawabanC->image;
            if (file_exists($file)) {
                @unlink($file);
            }
            $imgJawabanC = Str::random(10) . '.' . time() . '.' . $request->image_jawaban_c->extension();
            $request->image_jawaban_c->move(public_path('soal'), $imgJawabanC);
        } else {
            if ($request->image_old_jawaban_c == "") {
                $file = public_path('soal/') . $jawabanC->image;
                if (file_exists($file)) {
                    @unlink($file);
                    $imgJawabanC = "";
                }
            }
        }

        DetailSoal::where('id', $jawabanC->id)->update([
            'jawaban' => $request->jawaban_c,
            'kunci_jawaban' => false,
            'image' => $imgJawabanC,
        ]);

        $jawabanD = DetailSoal::where('id', $request->jawaban_d_id)->first();
        $imgJawabanD = $jawabanD->image;
        if ($request->image_jawaban_d) {
            $file = public_path('soal/') . $jawabanD->image;
            if (file_exists($file)) {
                @unlink($file);
            }
            $imgJawabanD = Str::random(10) . '.' . time() . '.' . $request->image_jawaban_d->extension();
            $request->image_jawaban_d->move(public_path('soal'), $imgJawabanD);
        } else {
            if ($request->image_old_jawaban_d == "") {
                $file = public_path('soal/') . $jawabanD->image;
                if (file_exists($file)) {
                    @unlink($file);
                    $imgJawabanD = "";
                }
            }
        }

        DetailSoal::where('id', $jawabanD->id)->update([
            'jawaban' => $request->jawaban_d,
            'kunci_jawaban' => false,
            'image' => $imgJawabanD,
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

        return redirect()->route('soal.pg.list', $soal->detailUjian[0]->ujian->slug)->with('sukses', 'Data soal berhasil diupdate');
    }

    public function pilih($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();

        if (request('cari')) {
            $soal_s = Soal::where('mapel_id', $ujian->jadwalBM->mapel_id)
                ->where('kelas_id', $ujian->jadwalBM->subKelas->kelas_id)
                ->where('type_soal', 'pg')
                ->where('status_update', false)
                ->where('title', 'like', '%' . request('cari') . '%')
                ->paginate(10)->withQueryString();
        } else {
            $soal_s = Soal::where('mapel_id', $ujian->jadwalBM->mapel_id)
                ->where('kelas_id', $ujian->jadwalBM->subKelas->kelas_id)
                ->where('type_soal', 'pg')
                ->where('status_update', false)->paginate(10)->withQueryString();
        }

        $soalTelahDiPilih = $ujian->detailUjian;

        return view('ujian.soal-pg.soal', compact('ujian', 'soal_s', 'soalTelahDiPilih'));
    }
}
