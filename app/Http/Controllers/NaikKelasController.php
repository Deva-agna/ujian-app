<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\SubKelas;
use Illuminate\Http\Request;

class NaikKelasController extends Controller
{
    public function index()
    {
        $sub_kelas_s = SubKelas::with('kelas')->orderBy('sub_kelas', 'asc')->get();
        return view('naik-kelas.index', compact('sub_kelas_s'));
    }

    public function view($slug)
    {
        $sub_kelas = SubKelas::with(['kelas', 'siswa'])->where('slug', $slug)->first();
        return view('naik-kelas.table', compact('sub_kelas'));
    }

    public function store(Request $request)
    {
        if ($request->kelas_tujuan == 'lulus') {
            for ($i = 0; $i < count($request->siswa); $i++) {
                Siswa::where('slug', $request->siswa[$i])->update([
                    'sub_kelas_id' => null,
                    'status' => false,
                ]);
            }
        } else {
            $sub_kelas = SubKelas::where('slug', $request->kelas_tujuan)->first();
            for ($i = 0; $i < count($request->siswa); $i++) {
                Siswa::where('slug', $request->siswa[$i])->update([
                    'sub_kelas_id' => $sub_kelas->id,
                ]);
            }
        }

        return redirect()->back()->with('sukses', 'Pengubahan status kelas berhasil!');
    }
}
