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
        
    }

    public function create()
    {
        
    }

    public function store(EpicRequest $request)
    {
        // $user = $request->user();

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
            // $user_story->user()->associate($user->id);
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
