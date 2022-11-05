<?php

namespace App\Http\Controllers;

use App\Models\JadwalBM;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\SubKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SubKelasController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $sub_kelas_s = SubKelas::with('kelas')->get();
            return datatables()->of($sub_kelas_s)
                ->addIndexColumn()
                ->addColumn('kelas', function ($row) {
                    $kelas = '<span class="text-uppercase">' . $row->kelas->nama_kelas . '</span>';
                    return $kelas;
                })
                ->addColumn('sub_kelas', function ($row) {
                    $sub_kelas = '<span class="text-uppercase">' . $row->sub_kelas . '</span>';
                    return $sub_kelas;
                })
                ->addColumn('action', 'sub-kelas.action')
                ->rawColumns(['action', 'kelas', 'sub_kelas'])
                ->make(true);
        }
        return view('sub-kelas.index');
    }

    public function create()
    {
        $kelas_s = Kelas::orderBy('nama_kelas', 'asc')->get();
        return view('sub-kelas.create', compact('kelas_s'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required',
            'sub_kelas' => 'required',
        ], [
            'kelas.required' => 'Harap pilih kelas.',
            'sub_kelas.required' => 'Bidang nama ruang wajib diisi.',
        ]);

        $sub_kelas = SubKelas::where('kelas_id', $request->kelas)->where('sub_kelas', $request->sub_kelas)->first();

        if (!$sub_kelas) {
            $kode = 'R' . time();

            SubKelas::create([
                'kelas_id' => $request->kelas,
                'kode_sub_kelas' => $kode,
                'sub_kelas' => $request->sub_kelas,
                'slug' => Str::of($request->sub_kelas . '-' . time())->slug('-'),
            ]);

            return redirect()->route('sub.kelas')->with('sukses', 'Data berhasil ditambah!');
        }

        throw ValidationException::withMessages([
            'sub_kelas' => 'Nama ruang sudah digunakan.',
        ]);
    }

    public function edit($slug)
    {
        $sub_kelas = SubKelas::where('slug', $slug)->first();
        return view('sub-kelas.edit', compact('sub_kelas'));
    }

    public function update(Request $request)
    {
        $sub_kelas = SubKelas::where('slug', $request->slug)->first();

        if ($sub_kelas->sub_kelas != $request->sub_kelas) {
            $request->validate([
                'sub_kelas' => 'required|unique:sub_kelas',
            ], [
                'sub_kelas.required' => 'Bidang nama ruang wajib diisi.',
                'sub_kelas.unique' => 'Nama ruang sudah digunakan.'
            ]);
        }

        SubKelas::where('id', $sub_kelas->id)->update([
            'sub_kelas' => $request->sub_kelas,
            'slug' => Str::of($request->sub_kelas . '-' . time())->slug('-'),
        ]);

        return redirect()->route('sub.kelas')->with('sukses', 'Data berhasil diupdate!');
    }

    public function destroy($slug)
    {
        $sub_kelas = SubKelas::where('slug', $slug)->first();
        $siswa = Siswa::where('sub_kelas_id', $sub_kelas->id)->first();
        $jadwalBM = JadwalBM::where('sub_kelas_id', $sub_kelas->id)->first();

        if ($siswa) {
            return redirect()->route('sub.kelas')->with('error', 'Data kelas tidak dapat dihapus, karena memiliki relasi dengan tabel lain!');
        } elseif ($jadwalBM) {
            return redirect()->route('sub.kelas')->with('error', 'Data kelas tidak dapat dihapus, karena memiliki relasi dengan tabel lain!');
        } else {
            SubKelas::destroy($sub_kelas->id);
            return redirect()->route('sub.kelas')->with('sukses', 'Data berhasil dihapus!');
        }
    }
}
