<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetSuccessfulMail;
use App\Mail\PasswordResetTokenMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Str;

class PasswordResetController extends Controller
{
    public function forgotPassword(Request $request)
    {
        // Validate request
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::whereEmail($request->email)->first();

        $password_reset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
                [
                    'email' => $user->email,
                    'token' => Str::random(60)
                ]
        );
        
        $password_reset_url = url("/reset-password?email=".$user->email."&token=".$password_reset->token);

        Mail::to($user)->queue(new PasswordResetTokenMail($user, $password_reset_url));

        return response()->json([
            'message'=>true,
            'data'=>['message' => 'We have e-mailed your password reset link!']
        ]);
    }

    public function resetPassword(Request $request)
    {
        // Validate request
        $request->validate([
            "email" => 'required|email|exists:users,email',
            "token" => 'required|string|exists:password_resets,token',
        ]);

        $password_reset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$password_reset){
            return response()->json(['message'=>'The password reset token is invalid.'], 401);
        }

        $user = User::where('email', $password_reset->email)->firstOrFail();
        
        $generated_password = strtolower(Str::random(8));
        $user->password = bcrypt($generated_password);
        $token =  $user->createToken('ngcart-token')->accessToken;
        $user->save();
        
        // Delete the reset token
        $password_reset->delete();

        Mail::to($user)->queue(new PasswordResetSuccessfulMail($user, $generated_password));

        return response()->json([
            'message'=>true,
            'data'=>['message' => 'Your password has been reset. We have e-mailed your new password!']
        ]);
    }

}

class PasswoardResetController extends Controller
{
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                'success'=>false,
                'data'=>['message' => 'This password reset token is invalid.']
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'success'=>false,
                'data'=>['message' => 'This password reset token is invalid.']
            ], 404);
        }
        return response()->json($passwordReset);
    }
     
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|string|email',
            'token' => 'required|string'
        ]);

        if ($validator->fails()) { 
            
            return response()->json(['success'=>false, 'data'=>$validator->errors()], 406);
        }

        
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset)
            return response()->json([
                'success' => false,
                'data' => ['message'=>'The password reset token is invalid.']
            ], 403);

        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
            return response()->json([
                'success' => false,
                'data' => ['message'=>'We cannot find a user with that e-mail address.']
            ], 404);

        $generated_password = strtolower(Str::random(8));
        $user->password = bcrypt($generated_password);
        $token =  $user->createToken('ngcart-token')->accessToken;
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($generated_password));
        return response()->json([
                                'success'=>true,
                                'data'=>[
                                    'user'=>$user,
                                    'token'=>$token,
                                    ]
                            ], 200);
    }
}
