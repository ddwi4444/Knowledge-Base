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
                ->route('dashboard/admin')
                ->with([
                    toast('Password berhasil diubah','success')
                ]);
        } else {
            return redirect()
                ->roue('dashboard/admin')
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

    // View Create User
    public function createUser()
    {
        return view('user.create', [
            'title' => 'Buat User',
        ]);
    }

    // Untuk membuat user
    public function storeUser(Request $req, User $user)
    {
        $this->validate($req, [
            'nama_unit' => 'required',
            'isi_post' => 'required',
            'password_confirmation' => ['required', 'string', 'min:5', 'confirmed'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
            'id_unit' => 'required',
        ]);

        $user = User::create([
            'id_unit' => $req->id_unit,
            'nama_unit' => $req->nama_unit,
            'username' => $req->username,
            'password' => Hash::make($req->password),
            'type' => '0',
            'status' => '0'
        ]);

        if ($user) {
            return redirect()
                ->route('dashboard/admin')
                ->with([
                    toast('User berhasil dibuat','success')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    toast('User gagal dibuat','error')
                ]);
        }
    } 
    
    // Menampilkan halaman untuk edit username atau nama unit
    public function indexEditUser($id, User $user)
    {
        $id = $id;
        $user = User::findOrFail($id);

        return view('user.editUser', [
            'title' => 'Edit User',
            'id' => $id,
            'user' =>$user
        ]);
    }

    // Proses untuk edit username dan password user
    public function editUserStore(Request $request, $id)
    {
        $this->validate($request, [
            'username' => 'required',
            'nama_unit' => 'required'
        ]);

        $user = User::findOrFail($id); 
        
        $user->update([
            'username' => $request->username,
            'nama_unit' => $request->nama_unit
        ]);

        if ($user) {
            return redirect()
                ->route('dashboard/admin')
                ->with([
                    toast('Password berhasil diubah','success')
                ]);
        } else {
            return redirect()
                ->roue('dashboard/admin')
                ->withInput()
                ->with([
                    toast('Password gagal diubah','error')
                ]);
        }
    }

}
