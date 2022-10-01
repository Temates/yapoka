<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Models\Category;

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
    return view('home',[
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
