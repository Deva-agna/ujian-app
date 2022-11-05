<?php

namespace App\Http\Controllers;

use App\Models\JadwalBM;
use App\Models\Nilai;
use App\Models\Soal;
use App\Models\TahunAjaran;
use App\Models\Ujian;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UjianSelesaiController extends Controller
{
    public function index()
    {
        $tahun_ajaran = TahunAjaran::where('status', true)->first();
        if ($tahun_ajaran) {
            $jadwalBM_s = JadwalBM::where('user_id', Auth::guard('web')->user()->id)->where('tahun_ajaran_id', $tahun_ajaran->id)->get('id');
            $ujian_s = Ujian::with(['jadwalBM.subKelas.kelas', 'jadwalBM.mapel', 'detailUjian'])->whereIn('jadwal_b_m_id', $jadwalBM_s)->where('status', 'completed')->get();
        } else {
            $ujian_s = [];
        }

        if (request()->ajax()) {
            return datatables()->of($ujian_s)
                ->addIndexColumn()
                ->addColumn('mapel', function ($row) {
                    $mapel = $row->jadwalBM->mapel->nama_mapel;
                    return $mapel;
                })
                ->addColumn('kelas', function ($row) {
                    $kelas = $row->jadwalBM->subKelas->kelas->nama_kelas;
                    return $kelas;
                })
                ->addColumn('sub_kelas', function ($row) {
                    $sub_kelas = $row->jadwalBM->subKelas->sub_kelas;
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
                    $status = '<span class="badge badge-pill badge-light-success mr-1">completed</span>';
                    return $status;
                })
                ->addColumn('action', 'ujian.log.log-action')
                ->rawColumns(['mapel', 'kelas', 'sub_kelas', 'waktu_mulai', 'waktu_selesai', 'waktu_ujian', 'type', 'status', 'action'])
                ->make(true);
        }

        return view('ujian.log.log-ujian');
    }

    public function ujianSelesai(Request $request)
    {
        $ujian = Ujian::where('slug', $request->slug)->first();

        $ujian->update([
            'status' => 'completed',
        ]);

        foreach ($ujian->detailUjian as $data) {
            Soal::where('id', $data->soal_id)->where('status_update', true)->update([
                'status_update' => false,
            ]);
        }

        return redirect()->back()->with('sukses', 'Ujian berhasil di tutup!');
    }

    public function logHasilUjian($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();

        if (request()->ajax()) {
            $nilai = Nilai::with(['siswa', 'ujian'])->where('ujian_id', $ujian->id)->get();
            return datatables()->of($nilai)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    $nama = $row->siswa->nama;
                    return $nama;
                })
                ->addColumn('nis', function ($row) {
                    $nis = $row->siswa->nis;
                    return $nis;
                })
                ->addColumn('start', function ($row) {
                    $start = Carbon::parse($row->start)->format('d, M Y H:i');
                    return $start;
                })
                ->addColumn('status', function ($row) {
                    $status = ($row->status) ? '<span class="badge badge-pill badge-light-success mr-1">Selesai</span>' : '<span class="badge badge-pill badge-light-warning mr-1">Belum Selesai</span>';
                    return $status;
                })
                ->addColumn('nilai', function ($row) {
                    $nilai = $row->nilai == '-' ? '-' : number_format($row->nilai, 2);
                    return $nilai;
                })
                ->addColumn('action', 'ujian.log.log-action-preview')
                ->rawColumns(['nama', 'nis', 'start', 'status', 'nilai', 'action'])
                ->make(true);
        }

        return view('ujian.log.log-hasil-ujian', compact('ujian'));
    }

    public function previewJawaban($slug)
    {
        $nilai = Nilai::with(['siswa', 'ujian'])->where('id', $slug)->first();
        return view('ujian.log.preview-jawaban', compact('nilai'));
    }

    public function previewEssay(Nilai $nilai)
    {
        return $nilai;
    }

    public function printJawaban(Nilai $nilai)
    {
        return view('ujian.log.print-jawaban', compact('nilai'));
    }

    public function printJawabanEssay(Nilai $nilai)
    {
        $nilai = $nilai->load('siswa', 'ujian');
        return view('ujian.log.print-jawaban-essay', compact('nilai'));
    }

    // public function coba()
    // {
    //     $pdf = PDF::loadview('data', compact('data'));
    // }
}
