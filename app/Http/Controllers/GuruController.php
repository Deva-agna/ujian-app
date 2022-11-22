<?php

namespace App\Http\Controllers;

use App\Models\JadwalBM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuruController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $guru_s = User::where('role', 'guru')->get();
            return datatables()->of($guru_s)
                ->addIndexColumn()
                ->addColumn('action', 'guru.action')
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('guru.index');
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|unique:users',
            'email' => 'required|unique:users',
            'tanggal_lahir' => 'required',
        ], [
            'nama.required' => 'Kolom nama wajib di isi!',
            'nip.required' => 'Kolom NIP wajib di isi!',
            'email.required' => 'Kolom email wajib di isi!',
            'tanggal_lahir.required' => 'Kolom tanggal lahir wajib di isi!',
            'nip.unique' => 'NIP sudah terdaftar!',
            'email.unique' => 'Email sudah terdaftar!',
        ]);

        $password = date('d-m-Y', strtotime($request->tanggal_lahir));

        $imgName = '';

        if ($request->image) {
            $imgName = $request->image->getClientOriginalName() . '.' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('foto'), $imgName);
        }

        User::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'password' => Hash::make($password),
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telpon' => $request->no_telpon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'img' => $imgName,
            'role' => 'guru',
            'slug' => Str::of($request->nama . '-' . time())->slug('-'),
        ]);

        return redirect()->route('guru')->with('sukses', 'Data berhasil ditambah!');
    }

    public function edit($slug)
    {
        $guru = User::where('slug', $slug)->first();
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request)
    {
        $guru = User::where('slug', $request->slug)->first();

        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'email' => 'required',
            'tanggal_lahir' => 'required',
        ], [
            'nama.required' => 'Kolom nama wajib di isi!',
            'nip.required' => 'Kolom NIP wajib di isi!',
            'tanggal_lahir.required' => 'Kolom tanggal lahir wajib di isi!',
            'email.required' => 'Kolom email wajib di isi!',
        ]);

        if ($guru->email != $request->email) {
            $request->validate([
                'email' => 'required|unique:users',
            ], [
                'email.unique' => 'Email sudah terdaftar!'
            ]);
        }

        if ($guru->nip != $request->nip) {
            $request->validate([
                'nip' => 'required|unique:users',
            ], [
                'nip.unique' => 'NIP Sudah terdaftar!'
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

        return redirect()->route('guru')->with('sukses', 'Data berhasil diupdate!');
    }

    public function destroy($slug)
    {
        $guru = User::where('slug', $slug)->first();

        $jadwalBM = JadwalBM::where('user_id', $guru->id)->first();

        if ($jadwalBM) {
            return redirect()->route('guru')->with('error', 'Data guru dengan nama ' . $guru->nama . ' digunakan pada tabel Jadwal Mengajar!');
        }


        $file = public_path('foto/') . $guru->img;
        if (file_exists($file)) {
            @unlink($file);
        }
        User::destroy($guru->id);
        return redirect()->route('guru')->with('sukses', 'Data berhasil dihapus!');
    }

    public function reset($slug)
    {
        $guru = User::where('slug', $slug)->first();
        $password = date('d-m-Y', strtotime($guru->tanggal_lahir));
        User::where('slug', $slug)->update([
            'password' => Hash::make($password)
        ]);
        return redirect()->route('guru')->with('sukses', 'Password berhasil di reset!');
    }
}
