<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\MailNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    public function index(){

        return view('login.index',[
            'title' => 'Login',
            'active' => 'login'
        ]);
    }


    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            // 'email' => ['required', 'email:dns'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Log::info('User '. $request->email .' Login!'); 
            return redirect()->intended('dashboard');
        }
        Log::info('User '. $request->email .' Gagal Login!'); 
        return back()->with('loginError', 'Login Failed!');
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout(Request $request){
        Log::info('User '. $request->email .' Log Out!'); 

        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
        return redirect('/');
    }
  
    public function resetpasspage(){
        return view('auth.forgot-password',[
            'title' => 'Reset Password',
            'active' => 'reset-password']);         
    }
    public function resetemail(Request $request){
        $rules = [
            'email' => 'required|email:dns'    
        ];
        $request->validate($rules);
        $email = User::where('email', $request->email)->select('email')->first();
        $data = [
            'subject' => 'Reset Password',
            'body' => 'User '. $email->email .' mengirimkan reset password',
        ];
        try{
            
            Mail::to('c11190016@john.petra.ac.id')->send(new MailNotify($data));
            // return response()->json(['Check Ur email box!']);
            return redirect('/')->with('success', 'Reset password has been sent!');

        }catch (Exception $th){
            return response()->json(['<h1>Sorry something went wrong!</h1>']);
        }
    
    }

    


}
