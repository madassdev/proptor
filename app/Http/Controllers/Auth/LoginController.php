<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $request->validate(
        [
            "email"=>"required|email",
            "password" => "required"
        ]
        );

        auth()->attempt($request->only(['email', 'password']));
        $user = auth()->user();
        
        return $user;
        if(auth()->attempt(['email' => request('email'), 'password' => request('password')])){

            // Load user roles
            $user = Auth::user();
            $roles = $user->roles->pluck('name')->toArray();
            $token =  $user->createToken('ngcart-token')->accessToken;

            return response()->json(['success'=>true,'data' => ['token'=>$token, 'user'=>$user, 'saved_payments'=>$user->paystackRecurrents,'user_roles'=>$roles]], $this->successStatus);
        }

        else{

            // Return unauthorized.
            $this->incrementLoginAttempts($request);
            return response()->json(['success'=>false,'data'=>['message'=>'Unauthorised']], $this->unauthStatus);
        }

        return $request;
    }
}
