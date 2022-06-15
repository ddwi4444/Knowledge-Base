<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Comment;

class PostCommentController extends Controller
{
    // Untuk insert pesan
    public function store(Request $req, Post $post)
    {
        Comment::create([
            'id_post' => $post->id,
            'id_unit' => $post->id_unit,
            'nama' => $req->nama,
            'username' => $req->email,
            'comment' => $req->komentar,
            'status' => '0',
            'g-recaptcha-response' => 'required|recaptchav3:register,0.5',
        ]);

        if ($post) {
            return redirect()
                ->back()
                ->with([
                    toast('Pesan anda akan direview','success')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    toast('Pesan anda gagal diposting','error')
                ]);
        }
    }  

    // Untuk insert jawaban pesan dari admin
    public function storeAnswer(Request $req, Comment $comment)
    {
        
        Comment::create([
            'id_post' => $comment->id_post,
            'id_unit' => auth()->user()->id_unit,
            'nama' => auth()->user()->nama_unit,
            'username' => auth()->user()->username,
            'comment' => $req->balasan,
            'id_parent' => $comment->id,
            'status' => '1',            
        ]);

        if($req->status == 1)
        {
            $this->changeStatus($comment->id);
        }
        elseif($req->status == 2)
        {
            $this->changeStatusNonaktif($comment->id);
        }

        

        if ($comment) {
            return redirect()
                ->back()
                ->with([
                    toast('Jawaban anda berhasil diposting','success')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    toast('Jawaban anda gagal diposting','error')
                ]);
        }
    } 
    
    // Untuk menampilkan halaman dashboard pesan/pertanyaan dari mahasiswa
    public function pertanyaan()
    {
        return view('pertanyaan.index', [
            'title' => 'Pertanyaan',

            'comments' => Comment::where('id_unit', auth()->user()->id_unit)->get()
        ]);
    }

    // Untuk menghapus pesan dari mahasiswa
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
    
        if ($comment) {
            return redirect()
                ->route('pertanyaan')
                ->with([
                    toast('Pesan berhasil dihapus','success')
                ]);
        } else {
            return redirect()
                ->route('pertanyaan')
                ->with([
                    toast('Pesan gagal dihapus','error')
                ]);
        }
    }

    public function destroyAnswer($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
    
        if ($comment) {
            return redirect()
                ->back()
                ->with([
                    toast('Pesan berhasil dihapus','success')
                ]);
        } else {
            return redirect()
                ->back()
                ->with([
                    toast('Pesan gagal dihapus','error')
                ]);
        }
    }

    // Untuk mengubah agar pesan tidak tertampil di halaman post
    public function changeStatusNonaktif($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update([
            $comment->status = '2',
        ]);

        if ($comment) {
            return redirect()
                ->back()
                ->with([
                    toast('Pesan tidak ditampilkan','success')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    toast('Pesan gagal tidak ditampilkan','error')
                ]);
        }
    }

    // Untuk mengubah agar pesan tertampil di halaman post
    public function changeStatus($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update([
            $comment->status = '1',
        ]);

        if ($comment) {
            return redirect()
                ->back()
                ->with([
                    toast('Pesan ditampilkan','success')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    toast('Pesan gagal ditampilkan','error')
                ]);
        }
    }
}
