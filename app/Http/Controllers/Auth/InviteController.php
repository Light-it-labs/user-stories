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
use App\Notifications\ExistingUserInvitationNotification;
use Illuminate\Support\Str;
use App\Http\Requests\InvitedUserSignUpRequest;
use App\Http\Requests\InvitationLinkRequest;
use App\Http\Requests\ExistingUserInvitatationRequest;
use App\User;

class InviteController
{
    public function sendInvitationLink(InvitationLinkRequest $request)
    {
        try
        {
            if(!$request->user()->can_invite_new_users_to_project($request->project_id)){
                return response()->json([
                    'success' => false,
                    'message' => 'Not authorized'
                 ], 403);
            }

            $token = Str::random(32);
            Invite::create([
                'token' => $token,
                'email' => $request->input('email'),
                'project_id' => $request->project_id,
            ]);

            if (User::where('email', $request->input('email'))->exists()){

                $url = URL::temporarySignedRoute(
                    'existingUserInvitation', now()->addMinutes(300), [
                        'token' => $token,
                        'email' => $request->input('email'),
                        'project_id' => $request->input('project_id'),
                        'invitation_owner' => $request->user()->email,
                    ]
                );

                Notification::route('mail', $request->email)->notify(new ExistingUserInvitationNotification($url));
            }else{

                $url = URL::temporarySignedRoute(
                    'invitation', now()->addMinutes(300), [
                        'token' => $token,
                        'email' => $request->input('email'),
                        'project_id' => $request->input('project_id'),
                    ]
                );

                Notification::route('mail', $request->email)->notify(new InviteNotification($url));
            }
    
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

    public function signUpInvitedUser(InvitedUserSignUpRequest $request)
    {
        try
        {
            $token = $request->token;
            $project_id = $request->project_id;

            $invitation = Invite::where('token', $token)
                                ->where('project_id', $project_id)
                                ->firstOrFail();

            $invitation->delete();

            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'image' => $request->image,
            ]);
            $user->setImageAttribute($request->image);
            $user->save();

            $user->projects()->attach($project_id, array('role_id' => 2));

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

    public function acceptProjectInvitation(ExistingUserInvitatationRequest $request)
    {
        try{
            
            $token = $request->token;
            $project_id = $request->project_id;

            $invitation = Invite::where('token', $token)
                                ->where('project_id', $project_id)
                                ->firstOrFail();
                                
            $invitation->delete();

            $user = User::where('email', $request->email)->firstOrFail();
            $user->projects()->attach($project_id, array('role_id' => 2));

                return response()->json([
                    'success' => true,
                    'message' => 'Invitation accepted!'
                ], 200);

        }catch(Exception $ex)
        {
            return response()->json([
                'success' => false,
                'errors' => $ex->getMessage()
            ], 500);
        }
        
    }
}
