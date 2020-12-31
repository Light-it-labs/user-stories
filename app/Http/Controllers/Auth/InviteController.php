<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use App\Models\Invite;
use App\Notifications\InviteNotification;
use Illuminate\Support\Str;
use App\Http\Requests\UserSignUpRequest;
use App\User;

class InviteController
{
    public function sendInvitationLink(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'email' => 'required|email|unique:users,email'
            ]);
    
            $validator->after(function ($validator) use ($request){
                if(Invite::where('email', $request->input('email'))->exists())
                {
                    $validator->errors()->add('email', 'A invitation for this email already exists!');
                }
            });
    
            if($validator->fails())
            {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ]);
            }
    
            $token = Str::random(32);
    
            Invite::create([
                'token' => $token,
                'email' => $request->input('email')
            ]);
    
            $url = URL::temporarySignedRoute(
                'invitation', now()->addMinutes(300), [
                    'token' => $token,
                    'email' => $request->input('email')
                ]
            );
    
            Notification::route('mail', $request->input('email'))->notify(new InviteNotification($url));
    
            return response()->json([
                'success' => true,
                'message' => 'Invitation link sent successfully!'
            ]);

        }catch(Exception $ex)
        {
            return response()->json([
                'success' => false,
                'errors' => $ex->getMessage()
            ], 500);
        }
        
    }

    public function signUpInvitedUser(UserSignUpRequest $request)
    {
        try
        {
            $credentials = $request->all();
            $token = $request->token;

            $invitation = Invite::where('token', $token)->firstOrFail();
            $invitation->delete();

            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'image' => $request->image,
            ]);
            $user->setImageAttribute($request->image);
            $user->save();
            $user->assignRole('invited');
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully created user!'
            ], 201);

        }catch(Exception $ex)
        {
            {
                return response()->json([
                    'success' => false,
                    'errors' => $ex->getMessage()
                ], 500);
            }
        }
    }
}
