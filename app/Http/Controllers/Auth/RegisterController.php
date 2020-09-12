<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Mail\UserRegisteredMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function Register(UserCreateRequest $request)
    {
        // Get User's First and Last names from Fullname
        $names = User::resolveFirstAndLastName($request->full_name);
        $request->merge($names);

        // Prepare data for password encryption
        $data = $request->except('password');
        $data = array_merge($data, ['password'=>bcrypt($request->password)]);

        // Create User, send User a mail and assign the User role
        $user = User::create($data);
        $user->assignRole('user');
        Mail::to($user)->send(new UserRegisteredMail($user));

        // Login the user
        $token =  $user->createToken('learnstack-token')->accessToken;
        $roles = $user->roles->pluck('name')->toArray();
        return response()->json(['message'=>'User created successfully',
                                'data' => ['token'=>$token, 'user'=>$user]]
                            );


    }

    
}
