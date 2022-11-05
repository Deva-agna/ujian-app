<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            if (Auth::guard('web')->user()->role == 'guru') {
                return redirect()->intended('/dashboard/guru');
            } else {
                return redirect()->intended('/dashboard/admin');
            }
        } elseif (Auth::guard('siswa')->check()) {
            return redirect('/dashboard/siswa');
        }
        return view('index');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'nip_nis' => 'required',
            'password' => 'required',
        ], [
            'nip_nis.required' => 'Kolom NIP/NIS wajib di isi.',
            'password.required' => 'Kolom password wajib di isi.'
        ]);

        if (Auth::guard('web')->attempt(['nip' => $request->nip_nis, 'password' => $request->password])) {
            if (Auth::guard('web')->user()->role == 'guru') {
                return redirect()->intended('/dashboard/guru');
            } else {
                return redirect()->intended('/dashboard/admin');
            }
        } elseif (Auth::guard('siswa')->attempt(['nis' => $request->nip_nis, 'password' => $request->password, 'status' => true])) {
            return redirect()->intended('/dashboard/siswa');
        }

        return back()->with('error', 'login gagal');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } elseif (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        }
        return redirect('/');
    }
}
