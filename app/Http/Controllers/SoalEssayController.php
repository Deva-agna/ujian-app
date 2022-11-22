<?php

namespace App\Http\Controllers;

use App\Models\DetailUjian;
use App\Models\Soal;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SoalEssayController extends Controller
{
    public function index($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();

        $list_s = DetailUjian::where('ujian_id', $ujian->id)->get();

        return view('ujian.soal-essay.index', compact('ujian', 'list_s'));
    }

    public function create($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();
        return view('ujian.soal-essay.create', compact('ujian'));
    }

    public function store(Request $request)
    {
        $ujian = Ujian::where('id', $request->ujian_id)->first();

        $imgSoal = "";

        if ($request->image_soal) {
            $imgSoal = Str::random(10) . '.' . time() . '.' . $request->image_soal->extension();
            $request->image_soal->move(public_path('soal'), $imgSoal);
        }

        $soal = Soal::create([
            'jadwal_b_m_id' => $request->jadwalBM_id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'title' => $request->deskripsi,
            'soal' => $request->soal,
            'image' => $imgSoal,
            'type_soal' => 'essay',
            'slug' => Str::of(Str::random(20) . '-' . time())->slug('-'),
        ]);

        DetailUjian::create([
            'ujian_id' => $request->ujian_id,
            'soal_id' => $soal->id
        ]);

        return redirect()->route('soal.essay.list', $ujian->slug)->with('sukses', 'Data soal berhasil ditambah');
    }

    public function edit($slug)
    {
        $soal = Soal::where('slug', $slug)->first();
        return view('ujian.soal-essay.edit', compact('soal'));
    }

    public function update(Request $request)
    {
        $soal = Soal::where('slug', $request->slug)->first();

        $imgSoal = $soal->image;

        if ($request->image_soal) {
            $file = public_path('soal/') . $imgSoal;
            if (file_exists($file)) {
                @unlink($file);
            }
            $imgSoal = Str::random(10) . '.' . time() . '.' . $request->image_soal->extension();
            $request->image_soal->move(public_path('soal'), $imgSoal);
        } else {
            if ($request->image_old_soal == "") {
                $file = public_path('soal/') . $imgSoal;
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

        return redirect()->route('soal.essay.list', $soal->detailUjian[0]->ujian->slug)->with('sukses', 'Data soal berhasil diupdate');
    }

    public function pilih($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();
        if (request('cari')) {
            $soal_s = Soal::where('mapel_id', $ujian->jadwalBM->mapel_id)
                ->where('kelas_id', $ujian->jadwalBM->subKelas->kelas_id)
                ->where('type_soal', 'essay')
                ->where('status_update', false)
                ->where('title', 'like', '%' . request('cari') . '%')
                ->paginate(10)->withQueryString();
        } else {
            $soal_s = Soal::where('mapel_id', $ujian->jadwalBM->mapel_id)
                ->where('kelas_id', $ujian->jadwalBM->subKelas->kelas_id)
                ->where('type_soal', 'essay')
                ->where('status_update', false)->paginate(10)->withQueryString();
        }
        $soalTelahDiPilih = $ujian->detailUjian;

        return view('ujian.soal-essay.soal', compact('ujian', 'soal_s', 'soalTelahDiPilih'));
    }
}
