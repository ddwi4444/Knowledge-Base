<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Untuk Redirect ke halaman view login
    public function index()
    {
        return view('login.index', [
            'title' => 'Login'
        ]);
    }

    // 1. Login
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
            if (auth()->user()->type == '0' && auth()->user()->status == '0') 
            {
                return redirect()->intended('dashboard')
                ->with([
                    alert()->success('Login Berhasil','Anda berhasil login')
                ]);
            }
            else if (auth()->user()->type == '1' && auth()->user()->status == '0') 
            {
                return redirect()->intended('dashboard/admin')
                ->with([
                    alert()->success('Login Berhasil','Anda berhasil login sebagai admin')
                ]);
            }
            else if(auth()->user()->status == '1'){
                Auth::logout();
                return back()->with([alert()->error('Akun Nonaktif', 'Silahkan hubungi admin untuk mengaktifkan akun kembali')]);
            }
        }        

        return back()->with([alert()->error('Login Gagal !','Pastikan Email atau Password benar')]);
    }

    // 2. Logout
    // Fungsi logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}