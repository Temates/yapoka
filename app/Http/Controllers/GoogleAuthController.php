<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
                 
             ]);
             
             Auth::login($new_user);
             return redirect()->intended('');

         }
         else {
             Auth::login($user);
             return redirect()->intended();
         }


     } catch (\Throwable $th) {
         dd('Something went wrong! '. $th->getMessage());
         
     }
    }
}
