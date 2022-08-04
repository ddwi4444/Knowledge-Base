<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class Controller extends BaseController
{
    // Menampilkan halaman home
    public function index()
    {
        return view('welcome', [
            'title' => 'Home',
            'users' => User::all(),
            'posts' => Post::paginate(20),
            'comments' => Comment::all(),
        ]);
    }
}
