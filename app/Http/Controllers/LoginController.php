<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;

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
            return redirect()->intended('dashboard');
        }
        return back()->with('loginError', 'Login Failed!');
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout(Request $request){

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
            return redirect('/forgot-password')->with('success', 'Reset password has been sent!');

        }catch (Exception $th){
            return response()->json(['<h1>Sorry something went wrong!</h1>']);
        }
        


        // Mail::to('c11190016@john.petra.ac.id')->send(new MailNotify($data));
        // // dd($request);
        // // return redirect('auth.forgot-password', array('title' => 'Reset Password',
        // // 'active' => 'reset-password'))
        // // ->with('success', 'Reset password has been sent!')
        // // ->with('title', 'Reset Password')
        // // ->with('active','reset-password');
        // return view('auth.forgot-password',[
        //     'title' => 'Reset Password',
        //     'active' => 'reset-password']); 

         
            
    }

  


}
