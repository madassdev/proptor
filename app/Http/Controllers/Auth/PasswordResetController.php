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
                    'token' => rand(100000, 999999)
                ]
        );
        
        $password_reset_url = url("/reset-password?email=".$user->email."&token=".$password_reset->token);

        Mail::to($user)->queue(new PasswordResetTokenMail($user, $password_reset_url, $password_reset->token));

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
            "password" => 'required|string|min:6'
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
        $user->password = bcrypt($request->password);
        $token =  $user->createToken('proptor-token')->accessToken;
        $user->save();
        
        // Delete the reset token
        $password_reset->delete();

        Mail::to($user)->queue(new PasswordResetSuccessfulMail());

        return response()->json([
            'message'=>true,
            'data'=>['message' => 'Your password has been reset.', 'data'=>[
                "user"=>$user,
                "token"=>$token
            ]]
        ]);
    }

}

