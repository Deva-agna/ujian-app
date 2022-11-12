<?php

namespace App\Http\Controllers;

use App\Models\DetailSoal;
use App\Models\DetailUjian;
use App\Models\Soal;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SoalMultipleChoiceController extends Controller
{
    public function index($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();

        $list_s = DetailUjian::where('ujian_id', $ujian->id)->get();

        return view('ujian.soal-mc.index', compact('ujian', 'list_s'));
    }

    public function create($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();
        return view('ujian.soal-mc.create', compact('ujian'));
    }

    public function store(Request $request)
    {
        $ujian = Ujian::where('id', $request->ujian_id)->first();

        $imageInputSoal = $request->image_soal;
        $inputSoal = $request->soal;
        $cekImage = $request->cek_image;
        $imageInputJawaban = $request->image_jawaban;
        $jawaban = $request->jawaban;
        $kunci_jawaban = $request->kunci_jawaban;

        $imageSoal = "";
        $imageJawaban = "";

        if ($imageInputSoal) {
            $imageSoal = Str::random(10) . '.' . time() . '.' . $imageInputSoal->extension();
            $imageInputSoal->move(public_path('soal'), $imageSoal);
        }

        $soal = Soal::create([
            'jadwal_b_m_id' => $request->jadwalBM_id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'title' => $request->deskripsi,
            'soal' => $inputSoal,
            'image' => $imageSoal,
            'type_soal' => 'mc',
            'slug' => Str::of(Str::random(20) . '-' . time())->slug('-'),
        ]);

        for ($i = 0; $i < count($jawaban); $i++) {
            if ($cekImage[$i]) {
                $imageJawaban = Str::random(10) . '.' . time() . '.' . $imageInputJawaban[$i]->extension();
                $imageInputJawaban[$i]->move(public_path('soal'), $imageJawaban);
            }
            DetailSoal::create([
                'soal_id' => $soal->id,
                'jawaban' => $jawaban[$i],
                'image' => $imageJawaban,
                'kunci_jawaban' => $kunci_jawaban[$i],
                'slug' => Str::of(Str::random(20) . '-' . time())->slug('-'),
            ]);

            $imageJawaban = "";
        }

        DetailUjian::create([
            'ujian_id' => $ujian->id,
            'soal_id' => $soal->id
        ]);

        return redirect()->route('soal.mc.list', $ujian->slug)->with('sukses', 'Data soal berhasil ditambah');
    }

    public function edit($slug)
    {
        $soal = Soal::where('slug', $slug)->first();
        return view('ujian.soal-mc.edit', compact('soal'));
    }

    public function update(Request $request)
    {
        $soal = Soal::where('slug', $request->slug)->first();

        $imageInputSoal = $request->image_soal;
        $inputSoal = $request->soal;
        $cekImage = $request->cek_image;
        $imageInputJawaban = $request->image_jawaban;
        $jawaban = $request->jawaban;
        $kunci_jawaban = $request->kunci_jawaban;
        $image_old_soal = $request->image_old_soal;
        $image_old_jawaban = $request->image_old_jawaban;


        $imageSoal = $image_old_soal;
        $imageJawaban = "";

        if ($imageInputSoal) {
            $file = public_path('soal/') . $image_old_soal;
            if ($file) {
                @unlink($file);
            }
            $imageSoal = Str::random(10) . '.' . time() . '.' . $imageInputSoal->extension();
            $imageInputSoal->move(public_path('soal'), $imageSoal);
        }

        Soal::where('slug', $request->slug)->update([
            'title' => $request->deskripsi,
            'soal' => $inputSoal,
            'image' => $imageSoal,
        ]);

        for ($i = 0; $i < count($jawaban); $i++) {
            if ($cekImage[$i]) {
                $file = public_path('soal/') . $image_old_jawaban[$i];
                if ($file) {
                    @unlink($file);
                }
                $imageJawaban = Str::random(10) . '.' . time() . '.' . $imageInputJawaban[$i]->extension();
                $imageInputJawaban[$i]->move(public_path('soal'), $imageJawaban);
            } else {
                $imageJawaban = $image_old_jawaban[$i];
            }
            DetailSoal::where('slug', $request->jawaban_slug[$i])->update([
                'jawaban' => $jawaban[$i],
                'image' => $imageJawaban,
                'kunci_jawaban' => $kunci_jawaban[$i],
            ]);

            $imageJawaban = "";
        }

        return redirect()->route('soal.mc.list', $soal->detailUjian[0]->ujian->slug)->with('sukses', 'Data soal berhasil diupdate!');
    }

    public function pilih($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();

        if (request('cari')) {
            $soal_s = Soal::where('mapel_id', $ujian->jadwalBM->mapel_id)
                ->where('kelas_id', $ujian->jadwalBM->subKelas->kelas_id)
                ->where('type_soal', 'mc')
                ->where('status_update', false)
                ->where('title', 'like', '%' . request('cari') . '%')
                ->paginate(10)->withQueryString();
        } else {
            $soal_s = Soal::where('mapel_id', $ujian->jadwalBM->mapel_id)
                ->where('kelas_id', $ujian->jadwalBM->subKelas->kelas_id)
                ->where('type_soal', 'mc')
                ->where('status_update', false)->paginate(10)->withQueryString();
        }

        $soalTelahDiPilih = $ujian->detailUjian;

        return view('ujian.soal-mc.soal', compact('ujian', 'soal_s', 'soalTelahDiPilih'));
    }

    public function addJawaban($slug)
    {
        $soal = Soal::where('slug', $slug)->first();
        return view('ujian.soal-mc.add-jawaban', compact('soal'));
    }

    public function storeJawaban(Request $request)
    {
        $soal = Soal::where('slug', $request->slug)->first();

        $image = "";

        if ($request->image_jawaban) {
            $image = Str::random(10) . '.' . time() . '.' . $request->image_jawaban->extension();
            $request->image_jawaban->move(public_path('soal'), $image);
        }

        DetailSoal::create([
            'soal_id' => $soal->id,
            'jawaban' => $request->jawaban,
            'image' => $image,
            'slug' => Str::of(Str::random(20) . '-' . time())->slug('-'),
        ]);

        return redirect()->route('soal.mc.list', $soal->detailUjian[0]->ujian->slug)->with('sukses', 'Jawaban berhasil ditambah');
    }
}
