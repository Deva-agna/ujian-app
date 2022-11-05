<?php

namespace App\Http\Controllers;

use App\Models\JadwalBM;
use App\Models\TahunAjaran;
use App\Models\Ujian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UjianController extends Controller
{
    public function index()
    {
        $tahun_ajaran = TahunAjaran::where('status', true)->first();
        if ($tahun_ajaran) {
            $jadwalBM_s = JadwalBM::where('user_id', Auth::guard('web')->user()->id)->where('tahun_ajaran_id', $tahun_ajaran->id)->get('id');
            $ujian_s = Ujian::with(['jadwalBM.subKelas.kelas', 'jadwalBM.mapel', 'detailUjian'])->whereIn('jadwal_b_m_id', $jadwalBM_s)->where('status', '!=', 'completed')->get();
        } else {
            $ujian_s = [];
        }

        if (request()->ajax()) {
            return datatables()->of($ujian_s)
                ->addIndexColumn()
                ->addColumn('mapel', function ($row) {
                    $mapel = '<span class="text-uppercase">' . $row->jadwalBM->mapel->nama_mapel . '</span>';
                    return $mapel;
                })
                ->addColumn('kelas', function ($row) {
                    $kelas = '<span class="text-uppercase">' . $row->jadwalBM->subKelas->kelas->nama_kelas . '</span>';
                    return $kelas;
                })
                ->addColumn('sub_kelas', function ($row) {
                    $sub_kelas = '<span class="text-uppercase">' . $row->jadwalBM->subKelas->sub_kelas . '</span>';
                    return $sub_kelas;
                })
                ->addColumn('waktu_mulai', function ($row) {
                    $waktu_mulai = Carbon::parse($row->waktu_mulai)->format('d, M Y H:i');
                    return $waktu_mulai;
                })
                ->addColumn('waktu_selesai', function ($row) {
                    $waktu_selesai = Carbon::parse($row->waktu_selesai)->format('d, M Y H:i');
                    return $waktu_selesai;
                })
                ->addColumn('waktu_ujian', function ($row) {
                    $waktu_ujian = $row->waktu_ujian . ' Menit';
                    return $waktu_ujian;
                })
                ->addColumn('type', function ($row) {
                    if ($row->type_ujian == 'pg') {
                        $type = 'Pilihan Ganda';
                    } elseif ($row->type_ujian == 'mc') {
                        $type = 'Multiple Choice';
                    } else {
                        $type = 'Essay';
                    }
                    return $type;
                })
                ->addColumn('status', function ($row) {
                    date_default_timezone_set("Asia/Jakarta");
                    $carbon = Carbon::now();
                    if ($row->status == 'active') {
                        if (strtotime($row->waktu_selesai) > strtotime($carbon)) {
                            $status = '<span class="badge badge-pill badge-light-info mr-1">Active</span>';
                        } else {
                            $status = '<span class="badge badge-pill badge-light-success mr-1">Completed</span>';
                        }
                    } else {
                        $status = '<span class="badge badge-pill badge-light-warning mr-1">Pending</span>';
                    }
                    return $status;
                })
                ->addColumn('action', 'ujian.action')
                ->rawColumns(['mapel', 'kelas', 'sub_kelas', 'waktu_mulai', 'waktu_selesai', 'waktu_ujian', 'type', 'status', 'action'])
                ->make(true);
        }
        return view('ujian.index');
    }

    public function create()
    {
        $tahun_ajaran = TahunAjaran::where('status', true)->first();
        $jadwalBM_s = JadwalBM::with('subKelas.kelas')->where('user_id', Auth::guard('web')->user()->id)->where('tahun_ajaran_id', $tahun_ajaran->id)->get();
        return view('ujian.create', compact('jadwalBM_s'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'jadwal_belajar' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'waktu_ujian' => 'required',
            'type_ujian' => 'required',
        ], [
            'title.required' => 'Bidang judul ujian wajib diisi.',
            'jadwal_belajar.required' => 'Bidang Jadwal Belajar wajib diisi.',
            'waktu_mulai.required' => 'Bidang waktu mulai wajib diisi.',
            'waktu_selesai.required' => 'Bidang waktu selesai wajib diisi.',
            'waktu_ujian.required' => 'Bidang waktu ujian wajib diisi.',
            'type_ujian.required' => 'Bidang type ujian wajib diisi.',
        ]);

        Ujian::create([
            'jadwal_b_m_id' => $request->jadwal_belajar,
            'title' => $request->title,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'waktu_ujian' => $request->waktu_ujian,
            'type_ujian' => $request->type_ujian,
            'token' => Str::random(5),
            'slug' => Str::of(Auth::guard('web')->user()->nama . '-ujian-' . time())->slug('-'),
        ]);

        return redirect()->route('ujian')->with('sukses', 'Data berhasil ditambah!');
    }

    public function edit($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();
        $jadwalBM_s = JadwalBM::where('user_id', Auth::guard('web')->user()->id)->get();
        return view('ujian.edit', compact('ujian', 'jadwalBM_s'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'waktu_ujian' => 'required',
        ], [
            'title.required' => 'Bidang judul ujian wajib diisi.',
            'waktu_mulai.required' => 'Bidang waktu mulai wajib diisi.',
            'waktu_selesai.required' => 'Bidang waktu selesai wajib diisi.',
            'waktu_ujian.required' => 'Bidang waktu ujian wajib diisi.',
        ]);

        if ($request->type_ujian) {
            $request->validate([
                'jadwal_belajar' => 'required',
                'type_ujian' => 'required',
            ], [
                'jadwal_belajar.required' => 'Bidang Jadwal Belajar wajib diisi.',
                'type_ujian.required' => 'Bidang type ujian wajib diisi.',
            ]);

            Ujian::where('slug', $request->slug)->update([
                'jadwal_b_m_id' => $request->jadwal_belajar,
                'type_ujian' => $request->type_ujian,
            ]);
        }

        Ujian::where('slug', $request->slug)->update([
            'title' => $request->title,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'waktu_ujian' => $request->waktu_ujian,
        ]);

        return redirect()->route('ujian')->with('sukses', 'Data berhasil diupdate!');
    }

    public function destroy($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();
        Ujian::destroy($ujian->id);
        return redirect()->route('ujian')->with('sukses', 'Data berhasil dihapus!');
    }

    public function status(Request $request)
    {
        $ujian = Ujian::where('slug', $request->slug)->first();

        date_default_timezone_set("Asia/Jakarta");

        $carbon = Carbon::now();

        if (strtotime($ujian->waktu_mulai) < strtotime($carbon)) {
            return redirect()->back()->with('error', 'Tanggal mulai kadaluarsa, harap atur ulang tanggal mulai!');
        }

        Ujian::where('id', $ujian->id)->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('sukses', 'Ujian berhasil di activekan!');
    }
}