<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Epic;
use App\Models\UserStory;
use App\Http\Requests\EpicRequest;
use App\Http\Requests\UserStoryRequest;

class EpicController
{
    public function index()
    {
        
    }

    public function show(Epic $epic)
    {
        return response()->json([
            'success' => true,
            'epic' => $epic->load(['user_stories'])
       ]);
    }

    public function create()
    {
        
    }

    public function store(EpicRequest $request)
    {
        //Hardcoded userId until branch of user_invitation with auth:api being merge. Once the branch is updated we are
        //gonna fetch user info with the request and get dynamically to assign it to user_story. Category is also harcoded
        // until formulas from excel are apply.

        $epic = new Epic($request->all());
        $epic->save();

        $epic->project()->associate($request->project_id);

        foreach($request->user_stories as $user_story){

            $user_story = new UserStory($user_story);
            $user_story->epic_id = $epic->id;
            $user_story->user_id = 1;
            $user_story->category = "Strategic";
            $user_story->save();
            $user_story->epic()->associate($epic);
        }

        return response()->json([
            'success' => true,
            'message' => 'Epic created successfully'
        ]);
        
    }

    public function edit(Epic $epic)
    {
        
    }

    public function update(EpicRequest $request, Epic $epic){

        $epic->update($request->all());

        foreach($request->user_stories as $user_story){

            if (array_key_exists('id', $user_story)) {
                $user_story_model = UserStory::findOrFail($user_story['id']);
                $user_story_model->update($user_story);
            }else{
                $user_story_model = new UserStory($user_story);
                $user_story_model->epic_id = $epic->id;
                $user_story_model->user_id = 1;
                $user_story_model->category = "Strategic";
                $user_story_model->save();
                $user_story_model->epic()->associate($epic);
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Epic updated successfully'
        ]);
    }

    public function delete(Epic $epic)
    {
        $epic->delete();

        return response()->json([
            'success' => true,
            'message' => 'Epic deleted successfully'
        ]);
    }
}