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
        $token =  $user->createToken('proptor-token')->accessToken;
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

