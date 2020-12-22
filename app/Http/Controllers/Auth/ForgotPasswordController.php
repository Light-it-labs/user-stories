<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController
{
    public function forgoPasswordSendToken(Request $request) 
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

    public function passwordReset(Request $request)
    {
        try
        {
            $credentials = Validator::make($request->all(),[
                'email' => 'required|email|exists:users,email',
                'password' => 'required|string',
                // 'rePassword' => 'required|string|same:password',
                'token' => 'required|string'
            ]);

            if($credentials->fails()){
                return response()->json([
                    'success' => false,
                    'errors' => $credentials->errors()
                ]);
            }

            $reset_password_status = Password::reset($request->all(), function($user, $password){
                $user->password = bcrypt($password);
                $user->save();
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
}
