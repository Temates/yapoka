<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
         return  Socialite::driver('google')->redirect();
    }
    public function callbackGoogle()
    {
     try {

         $google_user = Socialite::driver('google')->user();
         $user = User::where('name', $google_user->getName())->first();
         if (!$user) {
            $new_user = User::create([
                 'name' => $google_user->getName(),
                 'email' => $google_user->getEmail(),
                 'username' => $google_user->getName(),
                 'password' => Hash::make('password')     

             ]);
             
             Auth::login($new_user);

             UserProfile::create([
                'user_id' => auth()->user()->id,
                'full_name' => auth()->user()->name,
                'handphone_number' => '',
                'address' => '',
             ]);
            Log::info('User Dengan Email: '. auth()->user()->email .' Telah Dibuat!'); 

             return redirect()->intended('dashboard');

         }
         else {
             Auth::login($user);
             return redirect()->intended('dashboard');
         }


     } catch (\Throwable $th) {
         dd('Something went wrong! '. $th->getMessage());
         
     }
    }
}
