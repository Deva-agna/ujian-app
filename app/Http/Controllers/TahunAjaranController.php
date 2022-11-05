<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TahunAjaranController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $tahun_ajaran_s = TahunAjaran::get();
            return datatables()->of($tahun_ajaran_s)
                ->addIndexColumn()
                ->addColumn('action', 'tahun-ajaran.action')
                ->addColumn('status', function ($row) {
                    $status =  $row->status ? '<div class="waves-effect badge badge-light-success"><i class="fa-solid fa-circle"></i></div>' : '<div class="badge badge-light-secondary"><i class="fa-solid fa-circle"></i></div>';
                    return $status;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('tahun-ajaran.index');
    }

    public function create()
    {
        return view('tahun-ajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|unique:tahun_ajarans',
            'kurikulum' => 'required',
        ], [
            'tahun_ajaran.required' => 'Harap pilih tahun ajaran!',
            'tahun_ajaran.unique' => 'Tahun ajaran yang dipilih sudah tersedia!',
            'kurikulum.required' => 'Harap isi bidang kurikulum!',
        ]);

        TahunAjaran::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'kurikulum' => $request->kurikulum,
            'slug' => Str::of($request->tahun_ajaran . '-' . time())->slug('-'),
        ]);

        return redirect()->route('tahun.ajaran')->with('sukses', 'Data berhasil ditambah!');
    }

    public function edit(TahunAjaran $tahun_ajaran)
    {
        return view('tahun-ajaran.edit', compact('tahun_ajaran'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'kurikulum' => 'required',
        ], [
            'kurikulum.required' => 'Harap isi bidang kurikulum!',
        ]);

        TahunAjaran::where('slug', $request->slug)->update([
            'kurikulum' => $request->kurikulum,
        ]);

        return redirect()->route('tahun.ajaran')->with('sukses', 'Data berhasil diubah!');
    }

    public function active(TahunAjaran $tahun_ajaran)
    {
        $ujian = Ujian::where('status', 'active')->first();

        if ($ujian) {
            return redirect()->back()->with('error', 'Tahun ajaran tidak dapat diaktifkan dikarenakan ada ujian yang masih "Aktiv"!');
        }

        TahunAjaran::where('status', true)->update([
            'status' => false,
        ]);
        TahunAjaran::where('id', $tahun_ajaran->id)->update([
            'status' => true,
        ]);

        return redirect()->back()->with('sukses', 'Tahun ajaran berhasil diaktivkan!');
    }

    public function destroy(TahunAjaran $tahun_ajaran)
    {

        if ($tahun_ajaran->jadwalBM->count() > 0) {
            return redirect()->back()->with('error', 'Tahun ajaran tidak dapat dihapus, dikarenakan memiliki relasi ke data jadwal belajar mengajar! ');
        }

        TahunAjaran::destroy($tahun_ajaran->id);
        return redirect()->back()->with('sukses', 'Data berhasil dihapus!');
    }
}
