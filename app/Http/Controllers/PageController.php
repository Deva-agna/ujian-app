<?php

namespace App\Http\Controllers;

use App\Models\DetailJawaban;
use App\Models\DetailJawabanEssay;
use App\Models\DetailSoal;
use App\Models\DetailUjian;
use App\Models\Jawaban;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Ujian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function dashboardAdmin()
    {
        $guru = User::where('role', 'guru')->count();
        $siswa = Siswa::count();
        $kelas = Kelas::count();
        $mapel = Mapel::count();
        return view('page.dashboard-admin', compact('guru', 'siswa', 'kelas', 'mapel'));
    }

    public function profile()
    {
        return view('page.profile.data-diri');
    }

    public function profileEdit()
    {
        return view('page.profile.edit-profile');
    }

    public function profileUpdate(Request $request)
    {
        $guru = User::where('slug', $request->slug)->first();

        $request->validate([
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'email' => 'required',
            'nip' => 'required',
        ], [
            'nama.required' => 'Bidang nama wajib diisi.',
            'tanggal_lahir.required' => 'Bidang tanggal lahir wajib diisi.',
            'email.required' => 'Bidang email wajib diisi.',
            'nip.required' => 'Bidang nip wajib diisi.',
        ]);

        if ($guru->email != $request->email) {
            $request->validate([
                'email' => 'email|unique:users',
            ], [
                'email.email' => 'Format email tidak sesuai.',
                'email.unique' => 'Email sudah terdaftar.'
            ]);
        }

        if ($guru->nip != $request->nip) {
            $request->validate([
                'nip' => 'unique:users',
            ], [
                'nip.unique' => 'Nip sudah terdaftar.'
            ]);
        }

        $tanggal_lahir_lama = date('d-m-Y', strtotime($request->tanggal_lahir_old));
        $tanggal_lahir_baru = date('d-m-Y', strtotime($request->tanggal_lahir));

        if (Hash::check($tanggal_lahir_lama, $guru->password)) {
            User::where('slug', $request->slug)->update([
                'password' => Hash::make($tanggal_lahir_baru),
            ]);
        }

        if ($request->image) {
            $file = public_path('foto/') . $request->imgOld;
            if (file_exists($file)) {
                @unlink($file);
            }

            $imgName = $request->image->getClientOriginalName() . '.' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('foto'), $imgName);

            User::where('slug', $request->slug)->update([
                'img' => $imgName,
            ]);
        }

        User::where('slug', $request->slug)->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telpon' => $request->no_telpon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'slug' => Str::of($request->nama . '-' . time())->slug('-'),
        ]);

        return redirect()->route('profile')->with('sukses', 'Data berhasil diupdate!');
    }

    public function profileEditPassword()
    {
        return view('page.profile.ubah-password');
    }

    public function profileUpdatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => ['required'],
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => 'required',
        ], [
            'password_lama.required' => 'Bidang password lama wajib diisi.',
            'password.required' => 'Bidang password bru wajib diisi.',
            'password_confirmation.required' => 'Bidang konfirmasi password bru wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.'
        ]);

        if (Hash::check($request->password_lama, auth()->user()->password)) {
            User::where('id', $request->id)->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('profile')->with('sukses', 'Password Berhasil di Update!');
        }
        throw ValidationException::withMessages([
            'password_lama' => 'Password yang kamu masukan tidak sesuai',
        ]);
    }


    // Page Ujian

    public function halamanUjianIndex()
    {
        $siswa = Siswa::with(['subKelas.jadwalBM'])->where('id', Auth::guard('siswa')->user()->id)->first();

        $id_jadwalBM = [];
        foreach ($siswa->subKelas->jadwalBM as $key => $data) {
            $id_jadwalBM[$key] = $data->id;
        }

        $ujian = Ujian::with(['jadwalBM.mapel', 'nilai' => function ($query) {
            $query->where('siswa_id', auth()->user()->id);
        }])->where('status', 'active')->whereIn('jadwal_b_m_id', $id_jadwalBM)->orderBy('waktu_mulai', 'desc')->get();

        // return $ujian;

        return view('page.halaman-ujian.index', compact('ujian'));
    }

    public function pageKonfirmasiToken($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();
        $nilai = Nilai::with(['jawaban.soal.detailSoal', 'jawaban.detailJawaban.detailSoal'])->where('siswa_id', Auth::guard('siswa')->user()->id)->where('ujian_id', $ujian->id)->first();

        if ($nilai) {
            if ($nilai->status) {
                return redirect()->route('ujian.done');
            } else {
                if ($ujian->type_ujian == 'pg') {
                    return redirect()->route('halaman.ujian.pg', $nilai->slug);
                } elseif ($ujian->type_ujian == 'mc') {
                    return redirect()->route('halaman.ujian.pg.kompleks', $nilai->slug);
                } else {
                    return redirect()->route('halaman.ujian.esai.uraian', $nilai->slug);
                }
            }
        } else {
            return view('page.halaman-ujian.page-konfirmasi', compact('ujian'));
        }
    }

    public function checkToken(Request $request)
    {
        $now = Carbon::now();

        $request->validate([
            'token' => 'required',
        ], [
            'token.required' => 'Bidang token harus di isi!',
        ]);

        $ujian = Ujian::where('slug', $request->slug)->first();

        if ($ujian->token == $request->token) {
            $nilai = Nilai::with(['jawaban.soal.detailSoal', 'jawaban.detailJawaban.detailSoal'])->where('siswa_id', Auth::guard('siswa')->user()->id)->where('ujian_id', $ujian->id)->first();
            if ($nilai) {
                if ($ujian->type_ujian == 'pg') {
                    return redirect()->route('halaman.ujian.pg', $nilai->slug);
                } elseif ($ujian->type_ujian == 'mc') {
                    return redirect()->route('halaman.ujian.pg.kompleks', $nilai->slug);
                } else {
                    return redirect()->route('halaman.ujian.esai.uraian', $nilai->slug);
                }
            } else {
                $nilai = Nilai::create([
                    'ujian_id' => $ujian->id,
                    'siswa_id' => Auth::guard('siswa')->user()->id,
                    'start' => $now,
                    'slug' => Str::of(Auth::guard('siswa')->user()->nama . '-' . time())->slug('-'),
                ]);
                $soal_s = DetailUjian::where('ujian_id', $ujian->id)->inRandomOrder()->get();

                foreach ($soal_s as $soal) {
                    $jawaban_id =  Jawaban::create([
                        'soal_id' => $soal->soal_id,
                        'nilai_id' => $nilai->id,
                    ]);

                    if ($ujian->type_ujian == 'essay') {
                        DetailJawabanEssay::create([
                            'jawaban_id' => $jawaban_id->id,
                            'slug' => Str::of(Str::random(20) . '-' . time())->slug('-'),
                        ]);
                    } else {
                        $detailSoal = DetailSoal::where('soal_id', $soal->soal_id)->get();

                        $data = [];

                        foreach ($detailSoal as $key =>  $jawaban) {
                            $data[] = [
                                'jawaban_id' => $jawaban_id->id,
                                'detail_soal_id' => $jawaban->id
                            ];
                        }

                        DetailJawaban::insert($data);
                    }
                }

                if ($ujian->type_ujian == 'pg') {
                    return redirect()->route('halaman.ujian.pg', $nilai->slug);
                } elseif ($ujian->type_ujian == 'mc') {
                    return redirect()->route('halaman.ujian.pg.kompleks', $nilai->slug);
                } else {
                    return redirect()->route('halaman.ujian.esai.uraian', $nilai->slug);
                }
            }
        } else {
            return redirect()->back()->with('error', 'Token yang anda masukan salah! Harap hubungi guru yang berkaitan untuk informasi token yang digunakan!');
        }
    }

    public function lihatPeserta($slug)
    {
        $ujian = Ujian::where('slug', $slug)->first();
        return view('page.lihat-peserta', compact('ujian'));
    }

    public function ujianDone()
    {
        return view('page.ujian-done');
    }

    public function halamanUjianPG(Nilai $nilai)
    {
        return view('page.halaman-ujian.page-soal', compact('nilai'));
    }

    public function halamanUjianPGKompleks(Nilai $nilai)
    {
        return view('page.halaman-ujian.page-mc-soal', compact('nilai'));
    }

    public function halamanUjianEsai(Nilai $nilai)
    {
        return view('page.halaman-ujian.page-esay-soal', compact('nilai'));
    }
}
