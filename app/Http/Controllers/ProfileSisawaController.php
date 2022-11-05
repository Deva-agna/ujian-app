<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileSisawaController extends Controller
{
    public function index()
    {
        return view('page.profile-siswa.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'password_lama' => ['required'],
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => 'required',
        ], [
            'password_lama.required' => 'Bidang password lama tidak boleh kosong!',
            'password.required' => 'Bidang password baru tidak boleh kosong!',
            'password.min' => 'Password minimal 6 karakter!',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok',
            'password_confirmation.required' => 'Bidang ulangi password tidak boleh kosong!',
        ]);

        if (Hash::check($request->password_lama, auth()->user()->password)) {
            Siswa::where('id', auth()->user()->id)->update([
                'password' => Hash::make($request->password),
                'view_password' => '-',
            ]);
            return redirect()->route('profile.siswa')->with('sukses', 'Password Berhasil di Update!');
        }
        throw ValidationException::withMessages([
            'password_lama' => 'password yang kamu masukan tidak sesuai',
        ]);
    }
}
