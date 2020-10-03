<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class ApiLoginController extends Controller
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
        
        if(!$user)
        {
            return response()->json(["message"=>"Unauthenticated"],401);
        }
        
        $token =  $user->createToken('proptor-token')->accessToken;
        $roles = $user->roles->pluck('name')->toArray();
        $permissions = $user->permissions->pluck('name')->toArray();

        return response()->json(['message'=>'Login successful.',
                                    'data' => ['token'=>$token, 
                                    'user'=>$user, 
                                    'user_roles'=>$roles,
                                    'user_permissions'=>$permissions,
                                    ]]);
    }

    public function logout()
    {
        auth()->guard('api')->user()->token()->revoke();
        return response()->json(['success'=>true,'data' => ['message'=>'Successfully logged out']]);
    }
}
