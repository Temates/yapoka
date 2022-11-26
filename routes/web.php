<?php

use App\Models\Pelaporan;
use App\Models\Category;
use App\Models\UserProfile;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\LoginController;
use Illuminate\Auth\Events\PasswordReset;
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


Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);


Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);


Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/dashboard', [DashboardPostController::class,'index'])->middleware('auth');

Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');

Route::get('/dashboard/posts/create', function(){
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
Route::put('/dashboard/EditProfile', 
[UserProfileController::class, 'update'])->middleware('auth');




Route::get('/forgot-password',[LoginController::class, 'resetpasspage'])->middleware('guest')->name('password.request');
 
Route::post('/forgot-password', [LoginController::class, 'resetemail'])->middleware('guest')->name('password.email');


Route::get('/reset-password/{token}', function ($token) {
    return view('emails.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');


Route::get('/dashboard/angket/add', [CategoryController::class, 'index'])->middleware('admin');
Route::post('/dashboard/angket/send', [CategoryController::class, 'store'])->middleware('admin');

Route::get('/dashboard/pilihangket/add', [DashboardPostController::class, 'create'])->middleware('admin');

Route::get('/dashboard/pilihangket/addsend', [DashboardPostController::class, 'createsoal'])->middleware('admin');

Route::post('/dashboard/pilihangket/send', [DashboardPostController::class, 'storeangket'])->middleware('admin');
Route::get('/isiangket',[DashboardPostController::class, 'isiangket']);
Route::post('/isiangket/submit',[DashboardPostController::class, 'submit']);
Route::get('/ceklaporan',[DashboardPostController::class, 'ambildata']);
Route::post('ceklaporan/laporanditolak',[DashboardPostController::class, 'tolak']);
Route::post('ceklaporan/laporanditerima',[DashboardPostController::class, 'terima']);
Route::post('ceklaporan/penyimpanandata',[DashboardPostController::class, 'save']);
Route::get('/preview',[DashboardPostController::class, 'priview']);
Route::get('/print',[DashboardPostController::class, 'print']);
Route::get('/revisi',[DashboardPostController::class, 'revisi']);
Route::post('/revisi/submit',[DashboardPostController::class, 'updaterevisi']);
Route::get('/dashboard/laporan-yang-sudah-disetujui',[DashboardPostController::class, 'completejobs']);

