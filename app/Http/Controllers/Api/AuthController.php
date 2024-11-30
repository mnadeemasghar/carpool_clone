<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        // password check
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            // get the user
            $user = User::where('email', $request->email);
            
            // get the access token
            return response()->success([
                "access_token" => $user->first()->createToken('Personal Access Token')->plainTextToken,
                "user" => $user->select(['name','email','phone','profile_photo_path'])->first(),
            ]);
        }
        else
        {
            return response()->error('Login Failed');
        }
    }
}
