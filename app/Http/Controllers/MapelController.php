<?php

namespace App\Http\Controllers;

use App\Models\JadwalBM;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MapelController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $mapel_s = Mapel::get();
            return datatables()->of($mapel_s)
                ->addIndexColumn()
                ->addColumn('mapel', function ($row) {
                    $mapel = '<span class="text-uppercase">' . $row->nama_mapel . '</span>';
                    return $mapel;
                })
                ->addColumn('action', 'mapel.action')
                ->rawColumns(['action', 'mapel'])
                ->make(true);
        }
        return view('mapel.index');
    }

    public function create()
    {
        return view('mapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|unique:mapels',
        ], [
            'nama_mapel.required' => 'Bidang nama mapel wajib diisi.',
            'nama_mapel.unique' => 'Nama Mapel sudah digunakan.'
        ]);

        Mapel::create([
            'nama_mapel' => $request->nama_mapel,
            'slug' => Str::of($request->nama_mapel . '-' . time())->slug('-'),
        ]);

        return redirect()->route('mapel')->with('sukses', 'Data berhasil ditambah!');
    }

    public function edit($slug)
    {
        $mapel = Mapel::where('slug', $slug)->first();
        return view('mapel.edit', compact('mapel'));
    }

    public function update(Request $request)
    {
        $mapel = Mapel::where('slug', $request->slug)->first();

        if ($mapel->nama_mapel != $request->nama_mapel) {
            $request->validate([
                'nama_mapel' => 'required|unique:mapels',
            ], [
                'nama_mapel.required' => 'Bidang nama mapel wajib diisi.',
                'nama_mapel.unique' => 'Nama mapel sudah digunakan.'
            ]);
        }

        Mapel::where('id', $mapel->id)->update([
            'nama_mapel' => $request->nama_mapel,
            'slug' => Str::of($request->nama_mapel . '-' . time())->slug('-'),
        ]);

        return redirect()->route('mapel')->with('sukses', 'Data berhasil diupdate!');
    }

    public function destroy($slug)
    {
        $mapel = Mapel::where('slug', $slug)->first();
        $jadwalBM = JadwalBM::where('mapel_id', $mapel->id)->first();
        if ($jadwalBM) {
            return redirect()->route('mapel')->with('error', 'Data mapel tidak dapat dihapus, karena memiliki relasi dengan tabel lain!');
        } else {
            Mapel::destroy($mapel->id);
            return redirect()->route('mapel')->with('sukses', 'Data berhasil dihapus!');
        }
    }
}
