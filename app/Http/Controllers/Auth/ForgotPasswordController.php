<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserPasswordResetRequest;
use App\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController
{
    public function forgotPasswordSendToken(Request $request) 
    {
        try
        {
            $credentials = Validator::make($request->all(),[
                'email' => 'required|email|exists:users,email',
            ]);

            if($credentials->fails()){
                return response()->json([
                    'success' => false,
                    'errors' => $credentials->errors()
                ]);
            }

            Password::sendResetLink($request->only('email'));

            return response()->json([
                'success' => true,
                'message' => 'Reset password link sent on your email.'
            ]);
        

        }catch(Exception $ex)
        {
            return response()->json([
                'success' => false,
                'errors' => $ex->getMessage()
            ], 500);
        }
    }

    public function passwordReset(UserPasswordResetRequest $request)
    {
        try
        {
            $credentials = $request->all();

            $reset_password_status = Password::reset($credentials, function($user, $password){
                $this->setupNewPassword($user, $password);
            });

            if($reset_password_status == Password::INVALID_TOKEN){
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid token provided'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Password has been successfully changed'
            ]);

        }catch(Exception $ex)
        {
            return response()->json([
                'success' => false,
                'errors' => $ex->getMessage()
            ], 500);
        }
    }

    protected function setupNewPassword($user, $password){
        $user->password = bcrypt($password);
        $user->save();
    }
}
