<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserProfileController extends Controller
{
    public function index()
    {
        // dd(UserProfile::where('user_id', auth()->user()->id)->get());
        return view('dashboard.profile.index', [
            'user' => User::where('id', auth()->user()->id)->get(),
            'userprofile' => UserProfile::where('user_id', auth()->user()->id)->first(),


        ]);
    }
    
    public function update(Request $request)
    {
        $email = User::where('id', auth()->user()->id)->first();
        // $rules = [
        //     'name' => 'required|max:255',
        //     'full_name' => 'required|max:255',
        //     'handphone_number' => 'required|max:15|min:10',
        //     'address' => 'required|max:255',   
        // ];
        $user = [
            'name' => 'required|max:255',
        ];
        $profile = [
            'full_name' => 'required|max:255',
            'handphone_number' => 'required|max:15|min:10',
            'address' => 'required|max:255',   
        ];



        if($request->email != $email->email ){
            $user['email'] = 'required|unique:users';            
        }
   
        
        // $validatedData = $request->validate($rules);
        $validatedData1 = $request->validate($user);
        $validatedData2 = $request->validate($profile);

        User::where('id', auth()->user()->id)
        ->update($validatedData1);
        UserProfile::where('user_id', auth()->user()->id)
        ->update($validatedData2);
        Log::info('User '. auth()->user()->email .' Melakukan Perubahan Data Profile'); 

    return redirect('/dashboard')->with('success','User Profile has been updated!');
    }






}
