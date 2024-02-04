<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\post\Category;
use Illuminate\Http\Request;
use App\Models\post\PostModel;
use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Hash;


class AdminsController extends Controller
{
    public function viewLogin(){
        return view('admins.login-admins');
    }

    public function checkLogin(Request $request){

        Request()->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        $remember_me = $request->has('remember_me')?true:false;
        if(auth()->guard('admin')->attempt(['email'=>$request->input("email"),'password'=>$request->input("password")], $remember_me)){
            return redirect()->route('admins.dashboard');
        }
        return redirect()->back()->with(['error'=>'error loggin in']);
    }

    public function index(){

        $posts = PostModel::all();
        $postCount = $posts->count();

        $categories = Category::all();
        $categoryCount = $categories->count();

        $admins = Admin::all();
        $adminCount = $admins->count();

        return view('admins.index',compact('postCount','categoryCount','adminCount'));
    }

    public function admins(){
        $admins = Admin::all();
        return view('admins.admins',compact('admins'));
    }

    public function createAdmins(){
        return view('admins.create-admins');
    }
    public function storeAdmins(Request $request){
        Request()->validate([
            'email'=>'required|max:60',
            'name'=>'required|max:40',
            'password'=>'required|max:128',
        ]);

        $insertAdmin=Admin::create([
            'email'=>$request->email,
            'name'=>$request->name,
            'password'=>Hash::make($request->password),
        ]);
        return redirect('admin/show-admins')->with('success','Admin Created successfully');
    }

    public function categories(){
        $categories = Category::all();
        return view('admins.categories',compact('categories'));
    }

    public function createCategories(){
        return view('admins.create-categories');
    }

    public function storeCategories(Request $request){
        Request()->validate([
            'name'=>'required|max:25',
        ]);

        $insertCaterory=Category::create([
            'name'=>$request->name,
        ]);
        return redirect('admin/show-categories')->with('success','Category Created successfully');
    }

    public function deleteCategories($id){
        $category = Category::find($id);
        $category->delete();
        return redirect('admin/show-categories')->with('delete','Category Deleted successfully');
    }

    public function editCategories($id){
        $categories = Category::find($id);
        return view('admins.edit-categories',compact('categories'));
    }

    public function updateCategories(Request $request, $id){
        try{
        Request()->validate([
            'name'=>'required|max:25',
        ]);

        $updateCaterory = Category::find($id);
        $updateCaterory->update($request->all());

        return redirect('admin/show-categories')->with('update','Category Updated successfully');
        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'Error updating category: ' . $e->getMessage());
        }
    }

    public function posts(){
        $posts = PostModel::all();
        return view('admins.posts',compact('posts'));
    }

    public function deletePosts($id){
        $posts = PostModel::find($id);

        //for delete images
        $file_path = public_path('assets/images/'.$posts->image.'');
        unlink($file_path); //unlink function delete the files in the specific path

        $posts->delete();
        return redirect('admin/show-posts')->with('delete','Post Deleted successfully');
    }
}
