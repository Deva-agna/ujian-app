<?php

namespace App\Http\Controllers;

use App\Models\JadwalBM;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\SubKelas;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JadwalBMController extends Controller
{
    public function index()
    {

        $tahun_ajaran = TahunAjaran::where('status', true)->first();

        if ($tahun_ajaran) {
            if (request()->ajax()) {
                $jadwalBM_s = $tahun_ajaran->jadwalBM->load('user', 'subKelas.kelas', 'mapel');
                return datatables()->of($jadwalBM_s)
                    ->addIndexColumn()
                    ->addColumn('nama_guru', function ($row) {
                        $nama_guru = $row->user->nama;
                        return $nama_guru;
                    })
                    ->addColumn('kelas', function ($row) {
                        $kelas = '<span class="text-uppercase">' . $row->subKelas->kelas->nama_kelas . '</span>';
                        return $kelas;
                    })
                    ->addColumn('sub_kelas', function ($row) {
                        $sub_kelas = '<span class="text-uppercase">' . $row->subKelas->sub_kelas . '</span>';
                        return $sub_kelas;
                    })
                    ->addColumn('mapel', function ($row) {
                        $mapel = '<span class="text-uppercase">' . $row->mapel->nama_mapel . '</span>';
                        return $mapel;
                    })
                    ->addColumn('hari', function ($row) {
                        $hari = '<span class="text-uppercase">' . $row->hari . '</span>';
                        return $hari;
                    })
                    ->addColumn('jam', function ($row) {
                        $jam = $row->jam_mulai . ' - ' . $row->jam_selesai;
                        return $jam;
                    })
                    ->addColumn('action', 'jadwalBM.action')
                    ->rawColumns(['nama_guru', 'kelas', 'sub_kelas', 'mapel', 'jam', 'action', 'hari'])
                    ->make(true);
            }
        } else {
            return view('jadwalBM.halaman-informasi');
        }
        return view('jadwalBM.index', compact('tahun_ajaran'));
    }

    public function create()
    {
        $tahun_ajaran = TahunAjaran::where('status', true)->first();
        $guru_s = User::where('role', 'guru')->latest()->get();
        $sub_kelas_s = SubKelas::with('kelas')->orderBy('sub_kelas', 'asc')->get();
        $mapel_s = Mapel::orderBy('nama_mapel', 'asc')->get();
        return view('jadwalBM.create', compact('guru_s', 'sub_kelas_s', 'mapel_s', 'tahun_ajaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'sub_kelas' => 'required',
            'mapel_id' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ], [
            'user_id.required' => 'Bidang Guru Pengajar wajib diisi.',
            'sub_kelas.required' => 'Bidang Kelas yang diampu wajib diisi.',
            'mapel_id.required' => 'Bidang Mapel yang diampu wajib diisi.',
            'hari.required' => 'Bidang hari wajib diisi.',
            'jam_mulai.required' => 'Bidang jam mulai wajib diisi.',
            'jam_selesai.required' => 'Bidang jam selesai wajib diisi.',
        ]);

        JadwalBM::create([
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'user_id' => $request->user_id,
            'sub_kelas_id' => $request->sub_kelas,
            'mapel_id' => $request->mapel_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'slug' => Str::of($request->hari . '-' . time())->slug('-'),
        ]);

        return redirect()->route('jadwalBM')->with('sukses', 'Data berhasil ditambah!');
    }

    public function edit($slug)
    {
        $jadwalBM = JadwalBM::where('slug', $slug)->first();
        $guru_s = User::where('role', 'guru')->latest()->get();
        $sub_kelas_s = SubKelas::with('kelas')->orderBy('sub_kelas', 'asc')->get();
        $mapel_s = Mapel::orderBy('nama_mapel', 'asc')->get();
        return view('jadwalBM.edit', compact('jadwalBM', 'guru_s', 'sub_kelas_s', 'mapel_s'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'sub_kelas' => 'required',
            'mapel_id' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ], [
            'user_id.required' => 'Bidang Guru Pengajar wajib diisi.',
            'sub_kelas.required' => 'Bidang Kelas yang diampu wajib diisi.',
            'mapel_id.required' => 'Bidang Mapel yang diampu wajib diisi.',
            'hari.required' => 'Bidang hari wajib diisi.',
            'jam_mulai.required' => 'Bidang jam mulai wajib diisi.',
            'jam_selesai.required' => 'Bidang jam selesai wajib diisi.',
        ]);

        JadwalBM::where('slug', $request->slug)->update([
            'user_id' => $request->user_id,
            'sub_kelas_id' => $request->sub_kelas,
            'mapel_id' => $request->mapel_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'slug' => Str::of($request->hari . '-' . time())->slug('-'),
        ]);

        return redirect()->route('jadwalBM')->with('sukses', 'Data berhasil diupdate!');
    }

    public function destroy($slug)
    {
        $jadwalBM = JadwalBM::where('slug', $slug)->first();
        if ($jadwalBM->ujian->count() > 0) {
            return redirect()->route('jadwalBM')->with('error', 'Data Jadwal Belajar Mengajar tidak dapat dihapus, karena memiliki relasi dengan tabel lain!');
        }
        JadwalBM::destroy($jadwalBM->id);
        return redirect()->route('jadwalBM')->with('sukses', 'Data berhasil dihapus!');
    }
}
