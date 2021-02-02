<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserStory;
use App\Http\Requests\UserStoryRequest;
use App\Events\ProjectUpdateEvent;

class UserStoryController
{
  public function show(Request $request, UserStory $userStory)
  {
    $project = $userStory->get_project_of_user_story();

    if(!$request->user()->has_basic_permissions_to_project($project)){
      return response()->json([
          'success' => false,
          'message' => 'Not authorized'
       ], 403);
    }

    return response()->json([
        'success' => true,
        'userStory' => $userStory
    ]);
  }

  public function edit(Request $request, UserStory $userStory)
  {
    $project = $userStory->get_project_of_user_story();

    if(!$request->user()->has_basic_permissions_to_project($project)){
      return response()->json([
          'success' => false,
          'message' => 'Not authorized'
       ], 403);
    }
    
    if(!$userStory->isAvailableToEdit($request->user()->id)){
      return response()->json([
          'success' => false,
          'message' => 'Not available to edit now. Try later'
       ], 422);
    };

    $epic = $userStory->epic()->first();
    $epic->user_id_editing = $request->user()->id;
    $epic->save();

    return response()->json([
        'success' => true,
        'userStory' => $userStory
    ]);
  }

  public function update(UserStoryRequest $request, UserStory $userStory)
  {
    $project = $userStory->get_project_of_user_story();

    if(!$request->user()->has_basic_permissions_to_project($project)){
      return response()->json([
          'success' => false,
          'message' => 'Not authorized'
       ], 403);
    }

    $epic = $userStory->epic()->first();
    
    if(!$userStory->isAvailableToEdit($request->user()->id)){
      return response()->json([
        'success' => false,
        'message' => 'Not available to edit now. Try later'
     ], 422);
    };

    $userStory->update($request->all());
    $userStory->calculateCategory();
    $userStory->save();
    $epic->user_id_editing = null;
    $epic->save();

    broadcast(new ProjectUpdateEvent($userStory->get_project_of_user_story()));
  
    return response()->json([
        'success' => true,
        'message' => 'UserStory updated successfully'
    ]);
  }

  public function delete(Request $request, UserStory $userStory)
  {
    $project = $userStory->get_project_of_user_story();

    if(!$request->user()->has_basic_permissions_to_project($project)){
      return response()->json([
          'success' => false,
          'message' => 'Not authorized'
       ], 403);
    }

    if(!$userStory->isAvailableToEdit($request->user()->id)){
      return response()->json([
          'success' => false,
          'message' => 'Not available to delete now. Try later'
       ], 422);
    };

    broadcast(new ProjectUpdateEvent($userStory->get_project_of_user_story()));
    $userStory->delete();

    return response()->json([
        'success' => true,
        'message' => 'UserStory deleted successfully'
    ]);
  }
}
