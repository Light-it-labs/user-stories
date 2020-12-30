<?php

namespace App\Http\Controllers\Auth;


use Exception;
use App\Http\Requests\UserSignUpRequest;
use App\Http\Requests\UserLogInRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;

class AuthController
{
    //
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] image
     * @return [string] message
     */
    public function signup(UserSignUpRequest $request)
    {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $request->image,
        ]);
        $user->setImageAttribute($request->image);
        $user->save();
        $user->assignRole('owner');
        return response()->json([
            'success' => true,
            'message' => 'Successfully created user!'
        ], 201);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(UserLogInRequest $request)
    {
        $credentials = request(['email', 'password']); 

        if(!Auth::attempt($credentials))
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

         if ($request->remember_me)
             $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'success' => true,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => $user
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        try{
            return response()->json([
                'success' => true,
                'user' => $request->user()
            ]);
        }catch(Exception $ex){
            return response()->json([
                'success' => false,
                'errors' => $ex->getMessage()
            ], 500);
        }
    }
}
