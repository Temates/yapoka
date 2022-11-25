<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
class ResetPasswordController extends Controller
{
    // Normal Reset Password
    public function resetemail(Request $request){
        $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink(
            $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);  

    }
    // 

    //-- Reset Password versi kirim notif ke admin --
    // public function resetpasspage(){
    //     //     return view('auth.forgot-password',[
    //     //         'title' => 'Reset Password',
    //     //         'active' => 'reset-password']);         
    //     // }
    // public function resetemail(Request $request){
    //     $rules = [
    //         'email' => 'required|email:dns'    
    //     ];
    //     $request->validate($rules);
    //     $email = User::where('email', $request->email)->select('email')->first();
    //     $data = [
    //         'subject' => 'Reset Password',
    //         'body' => 'User '. $email->email .' mengirimkan reset password',
    //     ];
    //     try{
            
    //         Mail::to('c11190016@john.petra.ac.id')->send(new MailNotify($data));
    //         // return response()->json(['Check Ur email box!']);
    //         return redirect('/forgot-password')->with('success', 'Reset password has been sent!');

    //     }catch (Exception $th){
    //         return response()->json(['<h1>Sorry something went wrong!</h1>']);
    //     }
    
    // }
    
  
}
