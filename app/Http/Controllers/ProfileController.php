<?php

namespace App\Http\Controllers;

use App\User;

class ProfileController extends Controller
{
    public function index()
    {
        // temporarily all()
//        if (request()->expectsJson()) {
//            return response([
//                'profiles' => User::all()
//            ], 200);
//        }

        return view('profiles', ['profiles' => User::all()]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        if(request()->expectsJson()) {
            return response([
                'message' => $user->name . "'s profile has been deleted."
            ], 200);
        }

//        return view('profiles', [
//            'message' => $user->name . "'s profile has been deleted."
//        ]);
    }
}
