<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostingController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
Auth::routes();
Route::get('/home', function () {
    return redirect('/');
}); 


Route::get('/explore', [DashboardController::class, 'explore'])->name('explore');

Route::get('/post', [DashboardController::class, 'post'])->name('posts');
Route::get('/post/like/{id}' , [PostingController::class, 'like'])->name('like');
Route::post('/post', [PostingController::class, 'postcreate'])->name('post.create');
Route::get('/comment/{post}', [DashboardController::class, 'comment'])->name('comments');
Route::post('/comment/{post}', [DashboardController::class, 'commentStore'])->name('comments.post');
Route::post('/comment/replay/{comment}', [DashboardController::class, 'commentReplayStore'])->name('commentsReplay.post');
Route::delete('/comments/{comment}', [DashboardController::class, 'destroy'])->name('comment.delete');
Route::get('/profil', [DashboardController::class, 'profil'])->name('profile');
Route::get('/notifikasi', [DashboardController::class, 'notifikasi'])->name('notifikasi');
Route::post('/setting/profil', [PostingController::class, 'profilsettings'])->name('profile.create');
Route::get('/maincontent', [DashboardController::class, 'maincontent'])->name('maincontent');
Route::get('/settings/profil', [DashboardController::class, 'SettingProfil'])->name('settings.profil');
Route::get('/post/bookmark/{id}' , [PostingController::class, 'bookmark'])->name('bookmark');
Route::get('/post/bookmark' , [DashboardController::class, 'bookmarkstore'])->name('bookmarks');
Route::post('/settings/profil', [PostingController::class, 'SettingStore'])->name('settings.store');