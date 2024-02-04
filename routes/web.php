<?php

use App\Http\Controllers\categories\Categories;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\posts\PostsController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Admins\AdminsController;
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

//Route::get('/', function () {
   // return view('welcome');
//});

Auth::routes();
Route::get('/',[PostsController::class,'index'])->name('welcome');
Route::get('/home',[PostsController::class,'index'])->name('home');
Route::get('/contact',[PostsController::class,'contact'])->name('contact');
Route::get('/about',[PostsController::class,'about'])->name('about');

Route::group(['prefix'=>'posts'],function(){
    Route::get('/index',[PostsController::class,'index'])->name('posts.index');
    Route::get('/single/{id}',[PostsController::class,'single'])->name('posts.single');
    Route::get('/recent/{id}',[PostsController::class,'recent'])->name('posts.recent');

    Route::post('/comment-store',[PostsController::class,'storeComment'])->name('comment.store');
    Route::get('/create-post',[PostsController::class,'CreatePost'])->name('posts.create');
    Route::post('/post-store',[PostsController::class,'storePost'])->name('posts.store');
    Route::get('/post-delete/{id}',[PostsController::class,'deletePost'])->name('posts.delete');

    Route::get('/post-edit/{id}',[PostsController::class,'editPost'])->name('posts.edit');
    Route::post('/post-update/{id}',[PostsController::class,'updatePost'])->name('posts.update');
    Route::any('/search',[PostsController::class,'search'])->name('posts.search');
});

Route::group(['prefix'=>'categories'],function(){
    Route::get('/category/{category}',[Categories::class,'category'])->name('category.single');
});

Route::group(['prefix'=>'users'],function(){
    Route::get('/edit/{id}',[UsersController::class,'editProfile'])->name('users.edit');
    Route::any('/update/{id}',[UsersController::class,'updateProfile'])->name('users.update');
    Route::get('/profile/{id}',[UsersController::class,'profile'])->name('users.profile');
});

Route::get('admin/login',[AdminsController::class,'viewLogin'])->name('admins.login')->middleware('checkforauth');
Route::post('admin/login',[AdminsController::class,'checkLogin'])->name('admins.check.login');

Route::group(['prefix'=>'admin','middleware'=>'auth:admin'],function(){
    //admins
    Route::get('/',[AdminsController::class,'index'])->name('admins.dashboard');
    Route::get('/show-admins',[AdminsController::class,'admins'])->name('admins.show');
    Route::get('/create-admins',[AdminsController::class,'createAdmins'])->name('admins.create');
    Route::post('/create-admins',[AdminsController::class,'storeAdmins'])->name('admins.store');

    //categories
    Route::get('/show-categories',[AdminsController::class,'categories'])->name('categories.show');
    Route::get('/create-categories',[AdminsController::class,'createCategories'])->name('categories.create');
    Route::post('/create-categories',[AdminsController::class,'storeCategories'])->name('categories.store');
    Route::get('/delete-categories/{id}',[AdminsController::class,'deleteCategories'])->name('categories.delete');
    Route::get('/edit-categories/{id}',[AdminsController::class,'editCategories'])->name('categories.edit');
    Route::post('/update-categories/{id}',[AdminsController::class,'updateCategories'])->name('categories.update');

    //posts
    Route::get('/show-posts',[AdminsController::class,'posts'])->name('posts.show');
    Route::get('/delete-posts/{id}',[AdminsController::class,'deletePosts'])->name('post.delete');

});



