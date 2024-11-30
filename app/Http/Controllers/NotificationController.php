<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleApi;

class NotificationController extends Controller
{

    protected $googleApi;
    
    public function __construct(GoogleApi $googleApi)
    {
        $this->googleApi = $googleApi;
    }
    
    public function storeDeviceToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        if(Auth::check()){
            $user = User::where('id',Auth::user()->id)->first();
            $user->device_token = $request->token;
            $user->save();
    
            return response()->json(['message' => 'Device token stored successfully.']);
        }
    }
}
