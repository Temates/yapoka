<?php

use App\Models\Category;
use App\Models\UserProfile;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\DashboardPostController;

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

Route::get('/', function () {
    return view('login.index',[
        "title" => "Home",
        "active" => "home",
    ]);
});

Route::get('/about', function () {
    return view('about', [
        "name" => "Phe Nando",
        "active" => "about",
        "email" => "c11190016@john.petra.ac.id",
        "image" => "nando.jpg",
        "title" => "About"
        
    ]);
});



Route::get('/posts', [PostController::class, 'index']);

//halaman single post
Route::get('posts/{post:slug}',[PostController::class, 'show']);

Route::get('/categories', function(Category $category){
    return view('categories',[
        'title' => 'Post Categories',
        'active' => 'categories',
        'categories'=> Category::all()
    ]);
});
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);


Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);


Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/dashboard', function(){
    return view('dashboard.index',[
        'title' => 'Dashboard',
        'active' => 'dashboard'
    ]);
})->middleware('auth');

Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');

Route::get('/dashboard/posts/creates', function(){
    return dd(request());
    })->middleware('auth');
// Route::get('/dashboard/posts/creates', function(){
//     return view('dashboard.posts.create',[
//         'categories'=> Category::all()]);
//     })->middleware('auth');
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

Route::get('/dashboard/posts/{post:slug}',[DashboardPostController::class, 'show'])->middleware('auth');

Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware('admin');


Route::get('/dashboard/EditProfile', [UserProfileController::class, 'index'])->middleware('auth');
Route::put('/dashboard/EditProfile', [UserProfileController::class, 'update'])->middleware('auth');
Route::get('/forgot-password', function () {
    return view('auth.forgot-password',[
    'title' => 'Forgot Password',
    'active' => 'forgot']);
})->middleware('guest')->name('password.request');

Route::get('/dashboard/angket/add', [CategoryController::class, 'index'])->middleware('admin');
Route::post('/dashboard/angket/send', [CategoryController::class, 'store'])->middleware('admin');
Route::get('/dashboard/pilihangket/add', [CategoryController::class, 'create'])->middleware('admin');
Route::post('/dashboard/pilihangket/send', [CategoryController::class, 'storeangket'])->middleware('admin');


// Route::post('/dashboard/post/pilihangket', [dataangket::class, 'postdata'])->except('show')->middleware('admin');
// Route::get('/dashboard/post/isiangket', [dataangket::class, 'isiangket'])->except('show')->middleware('admin');
// Route::post('/dashboard/post/pilihangket', [dataangket::class, 'submit'])->except('show')->middleware('admin');
