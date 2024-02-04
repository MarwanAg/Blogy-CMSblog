<?php

namespace App\Http\Controllers\posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\post\PostModel;
use App\Models\post\Comment;
use App\Models\User;
use App\Models\post\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function index(){
        //first section
        $posts=PostModel::all()->take(2); //give limit to take posts (2) - take()
        $postOne=PostModel::take(1)->orderBy('title','desc')->get();
        $postTwo=PostModel::latest()->take(2)->get();

        //business section
        $postBus=PostModel::where('category','Business')->take(2)->get();
        $postBusTwo=PostModel::where('category','Business')->take(3)->orderBy('title','asc')->get();

        //random posts section
        $randomPosts=PostModel::take(4)->orderBy('category','asc')->get();

        //culture section
        $culturePosts=PostModel::take(2)->orderBy('title','desc')->get();
        $culturePostsTwo=PostModel::take(3)->orderBy('title','asc')->get();

        //POLITICS section
        $politicsPost=PostModel::where('category','Politics')->take(9)->orderBy('title','asc')->get();

        //Travel
        $travelPost=PostModel::where('category','Travel')->take(1)->get();
        $travelPost2=PostModel::where('category','Travel')->take(1)->orderBy('id','asc')->get();
        $travelPost3=PostModel::where('category','Travel')->take(2)->orderBy('id','desc')->get();

        $popPosts = PostModel::take(3)->orderBy('id', 'desc')->get();
        return view('posts.index',compact('posts','postOne','postTwo', 'postBus', 'postBusTwo', 'randomPosts', 'culturePosts', 'culturePostsTwo','politicsPost','travelPost','travelPost2','travelPost3','popPosts'));
    }

    public function single($id){
        $single=PostModel::find($id);
        $user=User::find($single->user_id);
        $popPosts=PostModel::take(3)->orderBy('id','desc')->get();

        $categories=DB::table('categories')->join('posts','posts.category','=','categories.name')
        ->select('categories.name AS name','categories.id AS id',DB::raw('COUNT(posts.user_id) AS total'))
        ->groupBy('posts.category')->get();

        //grabbing comments
        $comments=Comment::where('post_id',$id)->get();
        $commentNum=$comments->count();

        //moreBlogs
        $moreBlogs=PostModel::where('category',$single->category)->where('id','!=',$id)->take(4)->get();
        return view('posts.single',compact('single','user','popPosts','categories','comments','moreBlogs','commentNum'));
    }

    public function recent($id){
        $single=PostModel::find($id);
        $popPosts=PostModel::take(3)->orderBy('id','desc')->get();
        return view('footer', ['popPosts' => $popPosts]);
    }

    public function storeComment(Request $request){
        $insertComment=comment::create([
            'comment'=>$request->comment,
            'user_id'=>Auth::user()->id,
            'user_name'=>Auth::user()->name,
            'post_id'=>$request->post_id,
        ]);
        return redirect('posts/single/'.$request->post_id.'')->with('success','comment inserted successfully');
    }

    public function CreatePost(){

        $categories=Category::all();
        if(auth()->user()){
            $popPosts = PostModel::take(3)->orderBy('id', 'desc')->get();
            return view('posts.create-post',compact('categories','popPosts'));
        }else{
            return abort('404');
        }
    }

    public function storePost(Request $request){

        $destinationPath='assets/images/';
        $myimage=$request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath),$myimage);

        $insertPost = PostModel::create([
            'title' => $request->title,
            'category' => $request->category,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            'description' => $request->description,
            'image' => $myimage
        ]);

        return back()->withInput()->with('success','Post inserted successfully');
    }


    public function deletePost($id){

        $deletePost=PostModel::findorFail($id);
        $file_path = public_path('assets/images/'.$deletePost->image.'');
        unlink($file_path); //unlink function delete the files in the specific path
        $deletePost->delete();

        return redirect('/home')->with('delete','Post Deleted successfully');
    }

    public function editPost($id){

        $categories=Category::all();
        $single=PostModel::find($id);

        if(auth()->user()){
            if(Auth::user()->id== $single->user_id){
                $popPosts = PostModel::take(3)->orderBy('id', 'desc')->get();
                return view('posts.edit-post',compact('single','categories','popPosts'));
            }else{
                return abort('404');
            }
        }
    }
    public function updatePost(Request $request,$id){

        $updatePost=PostModel::find($id);
        $updatePost->update($request->all());
        Request()->validate([
            'title'=>'required',
            'description'=>'required',
            'category'=>'required',
        ]);
        if($updatePost){
            return redirect('single/'.$updatePost->id.'')->with('update','Post Updated successfully');
        }
    }

    public function search(Request $request){
        $search=$request->input('search');
        $results=PostModel::select()->where('title','like',"%$search%")->get();
        $popPosts = PostModel::take(3)->orderBy('id', 'desc')->get();

        return view('posts.search',compact('results','popPosts'));
    }

    public function contact(){
        $popPosts = PostModel::take(3)->orderBy('id', 'desc')->get();
        return view('pages.contact',compact('popPosts'));
    }

    public function about(){
        $popPosts = PostModel::take(3)->orderBy('id', 'desc')->get();
        return view('pages.about',compact('popPosts'));
    }
}
