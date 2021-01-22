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

    public function show(Request $request, Epic $epic)
    {
        if(!$request->user()->has_basic_permissions_to_project($epic->project()->first())){
            return response()->json([
                'success' => false,
                'message' => 'Not authorized'
             ], 403);
        }

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
        $user = $request->user();
        $epic = new Epic($request->all());
        $epic->save();

        $epic->project()->associate($request->project_id);

        foreach($request->user_stories as $user_story){

            $user_story = new UserStory($user_story);
            $user_story->epic_id = $epic->id;
            $user_story->user_id = $user->id;
            $user_story->calculateCategory();
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
        $user = $request->user();

        if(!$user->has_basic_permissions_to_project($epic->project()->first())){
            return response()->json([
                'success' => false,
                'message' => 'Not authorized'
             ], 403);
        }
        
        $epic->update($request->all());

        //Maybe change all this logic to updateOrCreate laravel method which update if model exists
        // or create a new model if none exists. How to know if the model is updated or created,
        //some attributes are set only when the model is new. i.e epic_id, user_id.
        foreach($request->user_stories as $user_story){

            if (array_key_exists('id', $user_story)) {
                $user_story_model = UserStory::findOrFail($user_story['id']);
                $user_story_model->update($user_story);
                $user_story_model->calculateCategory();
                $user_story_model->save();

            }else{
                $user_story_model = new UserStory($user_story);
                $user_story_model->epic_id = $epic->id;
                $user_story_model->user_id = $user->id;
                $user_story_model->calculateCategory();
                $user_story_model->save();
                $user_story_model->epic()->associate($epic);
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Epic updated successfully'
        ]);
    }

    public function delete(Request $request, Epic $epic)
    {
        if(!$request->user()->has_basic_permissions_to_project($epic->project()->first())){
            return response()->json([
                'success' => false,
                'message' => 'Not authorized'
             ], 403);
        }

        $epic->delete();

        return response()->json([
            'success' => true,
            'message' => 'Epic deleted successfully'
        ]);
    }
}
