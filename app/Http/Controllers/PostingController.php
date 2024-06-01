<?php

namespace App\Http\Controllers;

use App\Models\Posting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PostingController extends Controller
{
    public function postcreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('posts')
                ->withErrors($validator)
                ->withInput();
        }
        
        $file = $request->file('image');
        $file->storeAs('public/posts', $file->hashName());

        $status = Posting::create([
            'user_id' => Auth::user()->id,
            'image' => $file->hashName(),
            'content' => $request->content
        ]);

        if (!$status) {
            return redirect()->route('posts')->with('success', 'Something went wrong');
        }

        return redirect()->route('dashboard')->with('success', 'Product added successfully');
    }

    public function like(Posting $id)
    {
        if ($id->likes()->where('user_id', Auth::user()->id)->exists()) {
            $id->likes()->where('user_id', Auth::user()->id)->delete();
        }else{
            $id->likes()->create([
                'user_id' => Auth::user()->id,
            ]);
        }
        return back();
    }

    public function bookmark(Posting $id){

        if ($id->bookmarks()->where('user_id', Auth::user()->id)->exists()) {
            $id->bookmarks()->where('user_id', Auth::user()->id)->delete();
        }else{
            $id->bookmarks()->create([
                'user_id' => Auth::user()->id,
            ]);
        }
        return back();

    }
    public function SettingStore(Request $request)
    {
        $user = Auth::user();
        
        if($request->hasFile('image')){
        $file = $request->file('image');
        $file->storeAs('public/user', $file->hashName());
        $file =  $file->hashName();
        }else{
            $file = $user->image;
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'image'=>  $file,
            'bio' => $request->bio 

        ]);
        

        return redirect()->route('profile');
    }
    public function profilsettings(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            
        ]);
         if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Verifikasi password
        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->withErrors(['password' => 'Password is incorrect'])->withInput();
        }
        return redirect()->route('settings.profil');
    }
}
