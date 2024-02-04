<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\post\PostModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function editProfile($id){
        $user=User::find($id);
        if(auth()->user()){
            if(Auth::user()->id== $user->id){
                $popPosts = PostModel::take(3)->orderBy('id', 'desc')->get();
                return view('users.update-profile',compact('user','popPosts'));
            }else{
                return abort('404');
            }
        }
        return view('users.update-profile',compact('user'));
    }

    public function updateProfile(Request $request,$id){

        $updateUser=User::find($id);
        Request()->validate([
            'name'=>'required|max:20|min:6',
            'email'=>'required|max:30',
            'bio'=>'required|max:250',
        ]);
        $updateUser->update($request->all());
        if($updateUser){
            return redirect('/users/edit/'.$updateUser->id.'')->with('update.user','User Information Updated successfully');
        }
    }

    public function profile($id){
        $profile=User::find($id);
        $latestPosts=PostModel::where('user_id',$id)->take(4)->orderBy('created_at','desc')->get();
        $popPosts = PostModel::take(3)->orderBy('id', 'desc')->get();
        return view('users.profile',compact('profile','latestPosts','popPosts'));
    }
}
