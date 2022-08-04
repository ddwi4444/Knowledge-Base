<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;

class PasswordController extends Controller
{
    // Menampilkan halaman untuk edit password
    public function edit()
    {
        return view('password.edit', [
            'title' => 'Ubah Password'
        ]);
    }

    // Proses untuk mengubah password
    public function update()
    {
        request()->validate([
            'old_password' => 'required',
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);

        $currentPassword = auth()->user()->password;
        $old_password = request('old_password');

        if (Hash::check($old_password, $currentPassword)){
            auth()->user()->update([
                'password' => bcrypt(request('password')),
            ]);

            return redirect()
            ->back()
            ->with([
                toast('Password berhasil diubah','success')
            ]);


        } else {
            return back()->withErrors(['old_password' => 'Password yang anda masukkan salah']);
        }
    }
}