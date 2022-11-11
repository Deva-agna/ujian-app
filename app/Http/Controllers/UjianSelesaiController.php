<?php

namespace App\Http\Controllers;

use App\Models\JadwalBM;
use App\Models\Nilai;
use App\Models\Siswa;
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
                ->addColumn('ujian_ditutup', function ($row) {
                    $ujian_ditutup = Carbon::parse($row->updated_at)->format('d/m/Y H:i');
                    return $ujian_ditutup;
                })
                ->addColumn('title', function ($row) {
                    $title = '<div style="font-size:12px;"><span class="text-uppercase">' . $row->title . '</span><hr style="margin:0;">';
                    $title .= '<span class="text-uppercase" style="font-size:11px;">' . $row->jadwalBM->mapel->nama_mapel . '</span><hr style="margin:0;">';
                    $title .= '<span class="text-uppercase" style="font-size:11px;">' . Carbon::parse($row->waktu_mulai)->format('d/m H:i') . ' - ' . Carbon::parse($row->waktu_selesai)->format('d/m H:i') . '</span></div>';
                    return $title;
                })
                ->addColumn('sub_kelas', function ($row) {
                    $sub_kelas = '<div style="font-size:12px;"><span class="text-uppercase">' . $row->jadwalBM->subKelas->kelas->nama_kelas . '</span><hr style="margin:0;">';
                    $sub_kelas .= '<span class="text-uppercase">' . $row->jadwalBM->subKelas->sub_kelas . '</span></div>';
                    return $sub_kelas;
                })
                ->addColumn('waktu_ujian', function ($row) {
                    $waktu_ujian = $row->waktu_ujian . ' Menit';
                    return $waktu_ujian;
                })
                ->addColumn('action', 'ujian.log.log-action')
                ->rawColumns(['ujian_ditutup', 'title', 'sub_kelas', 'waktu_ujian', 'action'])
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

    // Function Siswa

    public function listUjianSelesai()
    {
        $siswa = Siswa::with(['subKelas.jadwalBM'])->where('id', Auth::guard('siswa')->user()->id)->first();

        $id_jadwalBM = [];
        foreach ($siswa->subKelas->jadwalBM as $key => $data) {
            $id_jadwalBM[$key] = $data->id;
        }

        $ujian = Ujian::with(['jadwalBM.mapel', 'nilai' => function ($query) {
            $query->where('siswa_id', auth()->user()->id);
        }])->where('status', 'completed')->whereIn('jadwal_b_m_id', $id_jadwalBM)->get();

        if (request()->ajax()) {
            return datatables()->of($ujian)
                ->addIndexColumn()
                ->addColumn('ujian_ditutup', function ($row) {
                    $ujian_ditutup = Carbon::parse($row->updated_at)->format('d/m/Y H:i');
                    return $ujian_ditutup;
                })
                ->addColumn('ujian', function ($row) {
                    $ujian = '<div>';
                    $ujian .= '<span style="font-size: 14px;">' .  $row->title . '</span>';
                    $ujian .= '<hr style="margin: 0;">';
                    $ujian .= '<span style="font-size: 12px;">' .  $row->jadwalBM->mapel->nama_mapel . '</span>';
                    $ujian .= '<hr style="margin: 0;">';
                    $ujian .= '<span style="font-size: 12px;">' .  Carbon::parse($row->waktu_mulai)->format('d/m H:i') . ' - ' . Carbon::parse($row->waktu_selesai)->format('d/m H:i') . '</span>';
                    $ujian .= '</div>';
                    return $ujian;
                })
                ->addColumn('action', 'ujian-selesai-siswa.action-index')
                ->rawColumns(['ujian', 'ujian_ditutup', 'action'])
                ->make(true);
        }

        return view('ujian-selesai-siswa.index', compact('ujian'));
    }

    public function previewJawabanSiswa(Nilai $nilai)
    {
        return view('ujian-selesai-siswa.preview-jawaban', compact('nilai'));
    }
    public function previewJawabanEssaySiswa(Nilai $nilai)
    {
        return view('ujian-selesai-siswa.preview-jawaban-essay', compact('nilai'));
    }
}
