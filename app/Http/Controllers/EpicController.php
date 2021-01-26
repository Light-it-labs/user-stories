<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Epic;
use App\Models\UserStory;
use App\Http\Requests\EpicRequest;
use App\Http\Requests\UserStoryRequest;
use Illuminate\Support\Facades\DB;

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
        //Category is harcoded until excel formulas are applied.
        $user = $request->user();
        $epic = new Epic($request->all());
        $epic->save();

        $epic->project()->associate($request->project_id);

        foreach($request->user_stories as $user_story){

            $user_story = new UserStory($user_story);
            $user_story->epic_id = $epic->id;
            $user_story->user_id = $user->id;
            $user_story->category = "Strategic";
            $user_story->save();
            $user_story->epic()->associate($epic);
        }

        return response()->json([
            'success' => true,
            'message' => 'Epic created successfully'
        ]);
        
    }

    public function edit(Request $request, Epic $epic)
    {
        if(!$request->user()->has_basic_permissions_to_project($epic->project()->first())){
            return response()->json([
                'success' => false,
                'message' => 'Not authorized'
             ], 403);
        };

        if(!$epic->isAvailableToEdit()){
            return response()->json([
                'success' => false,
                'message' => 'Not available to edit now. Try later'
             ], 422);
        }

        $epic->user_id_editing = $request->user()->id;
        $epic->save();

        return response()->json([
            'success' => true,
            'epic' => $epic->load(['user_stories'])
        ]);
    }

    public function resetStatus(Epic $epic)
    {
        $epic->user_id_editing = null;
        $epic->save();

        return response()->json([
            'success' => true,
            'message' => 'Epic status reset successfully'
        ]);
    }

    public function update(EpicRequest $request, Epic $epic){
        $user = $request->user();

        if(!$user->has_basic_permissions_to_project($epic->project()->first())){
            return response()->json([
                'success' => false,
                'message' => 'Not authorized'
             ], 403);
        }

        if($epic->user_id_editing != $request->user()->id){
            return response()->json([
                'success' => false,
                'message' => 'Not available to edit now. Try later'
             ], 422);
        };
        
        $epic->update($request->all());
        $epic->user_id_editing = null;
        $epic->save();

        foreach($request->user_stories as $user_story){

            if (array_key_exists('id', $user_story)) {
                $user_story_model = UserStory::findOrFail($user_story['id']);
                $user_story_model->update($user_story);
            }else{
                $user_story_model = new UserStory($user_story);
                $user_story_model->epic_id = $epic->id;
                $user_story_model->user_id = $user->id;
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

    public function delete(Request $request, Epic $epic)
    {
        if(!$request->user()->has_basic_permissions_to_project($epic->project()->first())){
            return response()->json([
                'success' => false,
                'message' => 'Not authorized'
             ], 403);
        }

        if(!$epic->isAvailableToEdit()){
            return response()->json([
                'success' => false,
                'message' => 'Not available to delete now. Try later'
             ], 422);
        }

        $epic->delete();

        return response()->json([
            'success' => true,
            'message' => 'Epic deleted successfully'
        ]);
    }
}
