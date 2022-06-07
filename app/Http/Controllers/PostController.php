<?php

namespace App\Http\Controllers;

use Alert;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.index', [
            'title' => 'Dashboard',

            'posts' => Post::where('id_unit', auth()->user()->id_unit)->get()
        ]);
    }

    // Fitur untuk autocomplete input tags pada form pembuatan post
    public function autocomplete(Request $request)
    {
        $search = $request->get('term');

        $result = Post::where('tags', 'LIKE', '%'. $search. '%')->limit(3)->get();
 
        return response()->json($result);
    } 

    // Untuk mencari berdasarkan judul
    public function cari(Request $request)
    {
        $cari = $request->cari;
 
    		// mengambil data dari table pegawai sesuai pencarian data
		$posts = DB::table('posts')
		->where('judul_post','like',"%".$cari."%")
        ->where('id_unit', auth()->user()->id_unit)
        ->paginate();
		
 
    		// mengirim data post ke view index
            return view('dashboard.index', [
                'title' => 'Dashboard',
    
                'posts' => $posts
            ]);
    }

    // Untuk mencari berdasarkan judul pada home page
    public function search(Request $request)
    {
        $search = $request->search;
 
    		// mengambil data dari table pegawai sesuai pencarian data
		$posts = DB::table('posts')
		->where('judul_post','like',"%".$search."%")
        ->orwhere('tags','like',"%".$search."%")
		->paginate();
 
    		// mengirim data post ke view index
            return view('welcome', [
                'title' => 'Knowledge Base',
    
                'posts' => $posts,
                'users' => User::all(),
                'comments' => Comment::all(),
            ]);
    }

    public function searchUnit(Request $request, User $user)
    {
        $search = $request->search;
 
		$posts = DB::table('posts')
		->where('judul_post','like',"%".$search."%")
        ->orwhere('tags','like',"%".$search."%")
		->paginate();
 
    		// mengirim data post ke view index
            return view('unit.show', [
                'title' => 'Knowledge Base',
    
                'user' => $user,
                'posts' => $posts,
                'users' => User::all(),
                'comments' => Comment::all(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create', [
            'title' => 'Buat Post'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'judul_post' => 'required',
            'isi_post' => 'required',
            'image' => 'required|max:1024|mimes:jpg,png,jpeg|image',
            'tags' => 'required',
        ]);

        $uploadImage = $request->image->store('image', ['disk' => 'public']);

        $post = Post::create([
            'id_unit' => auth()->user()->id_unit,
            'judul_post' => $request->judul_post,
            'image' => $uploadImage,
            'isi_post' => $request->isi_post,
            'tags' => $request->tags,
            'slug' => Str::slug($request->judul_post)
        ]);

        if ($post) {
            return redirect()
                ->route('dashboard')
                ->with([
                    toast('Post berhasil dibuat','success')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    toast('Post gagal dibuat','error')
                ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('post.edit', compact('post'),[
            'title' => 'Edit Post'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul_post' => 'required',
            'isi_post' => 'required',
            'image' => 'nullable|max:1024|mimes:jpg,png,jpeg|image',
            'tags' => 'required',
        ]);

        $post = Post::findOrFail($id);  
        
        if($request->hasFile('image')){ 
            $uploadImage = $request->image->store('image', ['disk' => 'public']);

            $post->update([
                'id_unit' => auth()->user()->id_unit,
                'judul_post' => $request->judul_post,
                'image' => $uploadImage,
                'isi_post' => $request->isi_post,
                'tags' => $request->tags,
                'slug' => Str::slug($request->judul_post)
            ]);
        }

        $post->update([
            'id_unit' => auth()->user()->id_unit,
            'judul_post' => $request->judul_post,
            'isi_post' => $request->isi_post,
            'tags' => $request->tags,
            'slug' => Str::slug($request->judul_post)
        ]);

        

        if ($post) {
            return redirect()
                ->route('dashboard')
                ->with([
                    toast('Post berhasil diupdate','success')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    toast('Post gagal diupdate','error')
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
    
        if ($post) {
            return redirect()
                ->route('dashboard')
                ->with([
                    toast('Post berhasil dihapus','success')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    toast('Post gagal dihapus','error')
                ]);
        }
    }
    
    public function singlePost(Request $request)
    {
        $param = $request->slug;
        $post = Post::where('slug',$request->slug)->first();
        $relatedPosts = Post::where('tags','like',"%".$request->tags."%")->get();

        return view('post/show', ['title' => 'FaQ - Knowledge Base', 
        'relatedPosts' => $relatedPosts,
        'comments' => Comment::all(), 
        'post' => $post]);
    }    
}
