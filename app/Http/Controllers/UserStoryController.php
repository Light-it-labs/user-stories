<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserStory;
use App\Http\Requests\UserStoryRequest;

class UserStoryController
{
  public function show(UserStory $userStory)
  {
      return response()->json([
          'success' => true,
          'userStory' => $userStory
      ]);
  }

  public function update(UserStoryRequest $request, UserStory $userStory)
  {
    $userStory->update($request->all());
  
    return response()->json([
        'success' => true,
        'message' => 'UserStory updated successfully'
    ]);
  }

  public function delete(UserStory $userStory)
  {
    $userStory->delete();

    return response()->json([
        'success' => true,
        'message' => 'UserStory deleted successfully'
    ]);
  }
}
