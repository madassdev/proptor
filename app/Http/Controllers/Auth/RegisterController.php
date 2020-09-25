<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Mail\TutorRegisteredMail;
use App\Mail\UserRegisteredMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function Register(UserCreateRequest $request)
    {
        // Prepare data for password encryption
        $data = $request->except('password');
        $data = array_merge($data, ['password'=>bcrypt($request->password)]);

        // Create User, send User a mail and assign the User role
        $user = User::create($data);
        $user->assignRole('user');
        
        Mail::to($user)->send(new UserRegisteredMail($user));

        // if($request->is_tutor)
        // {
        //     $user->tutor()->create([
        //         'name' => $user->full_name,
        //         'description' => 'Tutor',
        //     ]);

        //     Mail::to(User::permission('add-user')->get()->toArray())->queue(new TutorRegisteredMail($user));
        // }
        // Login the user
        $token =  $user->createToken('proptor-token')->accessToken;
        $roles = $user->roles->pluck('name')->toArray();
        return response()->json(['message'=>'User created successfully',
                                'data' => ['token'=>$token, 'user'=>$user]]
                            );

    }

    
}
