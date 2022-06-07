<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('login.index', [
            'title' => 'Login'
        ]);
    }

    // Proses atutentikasi user
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')
                ->with([
                    alert()->success('Succes','Anda berhasil login')
                ]);
        }

        return back()->with([alert()->error('Login Gagal !','Pastikan Email atau Password benar')]);
    }

    // Fungsi logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
