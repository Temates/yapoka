<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use App\Http\Requests\StoreUserProfileRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(UserProfile::where('user_id', auth()->user()->id)->get());
        return view('dashboard.profile.index', [
            'user' => User::where('id', auth()->user()->id)->get(),
            'userprofile' => UserProfile::where('user_id', auth()->user()->id)->first(),


        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserProfileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function show(UserProfile $userProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function edit( Request $request ,UserProfile $userProfile)
    {
        return view('dashboard.posts.edit',[
            'userProfile' => $userProfile,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserProfileRequest  $request
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserProfileRequest $request, UserProfile $userProfile)
    {
        $user = [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
        ];
        $profile = [
            'fullname' => 'required|max:255',
            'handphone_number' => 'required|max:12',
            'address' => 'required',            
        ];


        $validatedData = $request->validate($user);
        $validatedData = $request->validate($profile);


        User::where('id', $userProfile->id)
        ->update($validatedData);
        UserProfile::where('user_id', $userProfile->id)
        ->update($validatedData);

    return redirect('/dashboard')->with('success','Post has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserProfile $userProfile)
    {
        //
    }
}
