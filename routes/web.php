<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PasswordController;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [Controller::class, 'index'])->name('/');

Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [PostController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/pertanyaan', [PostCommentController::class, 'pertanyaan'])->middleware('auth')->name('pertanyaan');
Route::post('/pertanyaan.store/{post}', [PostCommentController::class, 'store'])->name('pertanyaan.store');
Route::post('/answer.store{comment}', [PostCommentController::class, 'storeAnswer'])->name('answer.store');
Route::get('/changeStatus/{comment}', [PostCommentController::class, 'changeStatus'])->middleware('auth')->name('changeStatus');
Route::get('/changeStatusNonaktif/{comment}', [PostCommentController::class, 'changeStatusNonaktif'])->middleware('auth')->name('changeStatusNonaktif');
Route::resource('/comment', PostCommentController::class);

Route::get('/dashboard/cari',[PostController::class, 'cari'])->middleware('auth');
Route::get('/search',[PostController::class, 'search']);
Route::get('searchUnit/{user:id_unit}',[PostController::class, 'searchUnit'])->name('unit.search');

Route::resource('/posts', PostController::class)->middleware('auth');
Route::get('{id_unit}/{slug}',[PostController::class, 'singlePost'])->name('show');
Route::get('/autocomplete', [PostController::class, 'autocomplete'])->name('autocomplete');

Route::get('/profil', [UserController::class, 'index'])->middleware('auth');

Route::get('password', [PasswordController::class, 'edit'])->name('password.edit')->middleware('auth');
Route::patch('password', [PasswordController::class, 'update'])->name('password.edit')->middleware('auth');

Route::get('{user:id_unit}', function (Post $post, User $user) {
    return view('unit/show', ['title' => 'Post - Knowledge Base', 'user' => $user, 'posts' => Post::all()]); 
})->name('unit.posts');

Route::resource('/comment', PostCommentController::class)->middleware('auth');
Route::get('comment/{comment:id}', function (Comment $comment) {
    return view('pertanyaan/show', ['title' => 'Pertanyaan - Knowledge Base', 'comment' => $comment, 'comments' => Comment::all()]); 
})->name('showComment');

