<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use App\Models\Posting;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $posts = Posting::orderBy('created_at', 'desc')->get();
        $userRecomended = User::orderBy('created_at', 'desc')->take(5)->get();
        
        return view('dashboard', compact('posts','userRecomended' ));
    }   
    public function bookmarkstore()
    {
        $bookmarks = Bookmark::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('fiturdashboard.boookmark', compact('bookmarks'));
        
    } 
    public function maincontent()
    {
        return view('layout.content');
    }
    public function SettingProfil()
    {    $user = Auth::user();
        return view('fiturdashboard.profilsetting', compact('user'));
    }
    
    public function notifikasi()
    {
        return view('fiturdashboard.notifications');
    }
    public function post()
    {
        return view('fiturdashboard.posting');
    }
    public function profil()
    {
        return view('fiturdashboard.porfil');
    }
    public function comment(Posting $post)
    {
        // $post = $post->comments()->whereNull('parent_comment_id')->with('childComments.user')->get();
        return view('fiturdashboard.comment', compact('post'));
    }

    public function commentStore(Request $request, Posting $post)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $comment = $post->comments()->create([ 
            'user_id' => Auth::user()->id,
            'content' => $request->content
        ]);

        return back();
    }

    public function commentReplayStore(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $comment = $comment->parentComment()->create([
            'user_id' => Auth::user()->id,  
            'content' => $request->content,
            'post_id' => $comment->post_id,
            'parent_comment_id' => $comment->id
        ]);

        return back();
    }

    public function explore(Request $request){
        if ($request->has('search')) {
            $user = User::where('name', 'LIKE', '%' . $request->search . '%')->get();
        } else{
            $user = [];
            
        }
        $userRecomended = User::orderBy('created_at', 'desc')->take(5)->get();

            return view('fiturdashboard.explore', compact('user','userRecomended'));
    }




    public function destroy(Comment $comment){
    $comment->delete();

    return back();
    }

}
