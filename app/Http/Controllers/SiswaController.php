<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\SubKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $siswa_s = Siswa::with('subKelas.kelas')->where('status', true)->get();
            return datatables()->of($siswa_s)
                ->addIndexColumn()
                ->addColumn('kelas', function ($row) {
                    $kelas = '<span class="text-uppercase">' . $row->subKelas->kelas->nama_kelas . '</span>';
                    return $kelas;
                })
                ->addColumn('ruang', function ($row) {
                    $ruang = '<span class="text-uppercase">' . $row->subKelas->sub_kelas . '</span>';
                    return $ruang;
                })
                ->addColumn('action', 'siswa.action')
                ->rawColumns(['kelas', 'ruang', 'action'])
                ->make(true);
        }
        return view('siswa.index');
    }

    public function create()
    {
        $jumlah_data = request('jumlah_data');
        $sub_kelas_s = SubKelas::with('kelas')->orderBy('sub_kelas', 'asc')->get();
        return view('siswa.create', compact('sub_kelas_s', 'jumlah_data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama.*' => 'required',
            'nis.*' => 'required|unique:siswas,nis',
            'sub_kelas.*' => 'required',
        ], [
            'nama.*.required' => 'Bidang Nama Siswa wajib diisi.',
            'nama.*.regex' => 'Format Nama tidak valid.',
            'nis.*.required' => 'Bidang NIS wajib diisi.',
            'sub_kelas.*.required' => 'Bidang Kelas wajib diisi.',
            'nis.*.unique' => 'Data NIS sudah terdaftar',
        ]);

        for ($i = 0; $i < count($request->nama); $i++) {
            $password = "";
            for ($k = 0; $k < 6; $k++) {
                $password .= chr(rand(65, 90));
            }
            Siswa::create([
                'nama' => $request->nama[$i],
                'nis' => $request->nis[$i],
                'password' => Hash::make($password),
                'view_password' => $password,
                'sub_kelas_id' => $request->sub_kelas[$i],
                'role' => 'siswa',
                'slug' => Str::of($request->nama[$i] . '-' . time())->slug('-'),
            ]);
        }

        return redirect()->route('siswa')->with('sukses', 'Data berhasil ditambah!');
    }

    public function edit($slug)
    {
        $siswa = Siswa::where('slug', $slug)->first();
        $sub_kelas_s = SubKelas::with('kelas')->orderBy('sub_kelas', 'asc')->get();
        return view('siswa.edit', compact('siswa', 'sub_kelas_s'));
    }

    public function update(Request $request)
    {
        $siswa = Siswa::where('slug', $request->slug)->first();

        $request->validate([
            'nama' => 'required|regex:/^[a-zA-Z.\s]+$/',
            'nis' => 'required',
            'sub_kelas' => 'required',
        ], [
            'nama.required' => 'Bidang Nama Siswa wajib diisi.',
            'nama.*.regex' => 'Format Nama tidak valid.',
            'nis.required' => 'Bidang NIS wajib diisi.',
            'sub_kelas.required' => 'Bidang Kelas wajib diisi.',
        ]);

        if ($siswa->nis != $request->nis) {
            $request->validate([
                'nis' => 'unique:siswas'
            ], [
                'nis.unique' => 'Data NIS sudah terdaftar'
            ]);
        }

        Siswa::where('slug', $request->slug)->update([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'sub_kelas_id' => $request->sub_kelas,
            'slug' => Str::of($request->nama . '-' . time())->slug('-'),
        ]);

        return redirect()->route('siswa')->with('sukses', 'Data berhasil diupdate!');
    }

    public function destroy($slug)
    {
        $siswa = Siswa::where('slug', $slug)->first();
        if ($siswa->nilai->count() > 0) {
            return redirect()->route('siswa')->with('error', 'Data Siswa tidak dapat dihapus, karena memiliki relasi dengan tabel lain!');
        }
        Siswa::destroy($siswa->id);
        return redirect()->route('siswa')->with('sukses', 'Data berhasil dihapus!');
    }

    public function reset($slug)
    {
        $password = "";
        for ($i = 0; $i < 6; $i++) {
            $password .= chr(rand(65, 90));
        }
        Siswa::where('slug', $slug)->update([
            'password' => Hash::make($password),
            'view_password' => $password,
        ]);
        return redirect()->back()->with('sukses', 'Password berhasil di reset!');
    }

    public function alumni()
    {
        if (request()->ajax()) {
            $siswa_s = Siswa::where('status', false)->get();
            return datatables()->of($siswa_s)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    $nama = $row->nama;
                    return $nama;
                })
                ->addColumn('nis', function ($row) {
                    $nis = $row->nis;
                    return $nis;
                })
                ->rawColumns(['nama', 'kelas'])
                ->make(true);
        }

        return view('siswa.alumni');
    }
}
