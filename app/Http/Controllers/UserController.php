<?php

namespace App\Http\Controllers;

use Alert;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

use Hash;

class UserController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Untuk mencari berdasarkan 
    public function search(Request $request)
    {
        $cari = $request->cari;
 
    		// mengambil data dari table pegawai sesuai pencarian data
		$users = DB::table('users')
		->where('nama_unit','like',"%".$cari."%")
        ->paginate();
		
 
    		// mengirim data post ke view index
            return view('dashboard.admin', [
                'title' => 'Dashboard Admin',
    
                'users' => $users
            ]);
    }

    // Menampilkan halaman untuk edit password admin
    public function edit($id)
    {
        $id = $id;

        return view('user.edit', [
            'title' => 'Ubah Password',
            'id' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Proses untuk mengubah password admin
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);

        $user = User::findOrFail($id); 
        
        $user->update([
            'password' => bcrypt(request('password'))
        ]);

        if ($user) {
            return redirect()
                ->back()
                ->with([
                    toast('Password berhasil diubah','success')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    toast('Password gagal diubah','error')
                ]);
        }
    }

    public function changeStatusUserNonaktif($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            $user->status = '1',
        ]);

        if ($user) {
            return redirect()
                ->back()
                ->with([
                    toast('User berhasil dinonaktifkan','success')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    toast('User gagal dinonaktifkan','error')
                ]);
        }
    }

    public function changeStatusUserAktif($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            $user->status = '0',
        ]);

        if ($user) {
            return redirect()
                ->back()
                ->with([
                    toast('User berhasil diaktifkan','success')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    toast('User gagal diaktifkan','error')
                ]);
        }
    }

}
