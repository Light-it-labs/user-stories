<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Epic;
use App\Models\Project;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.User.{id}', function ($user, $id) {
//      return (int) $user->id === (int) $id;
//  });

// Broadcast::channel('epic-channel', function(){
//     return true;
// });

//Private channel

Broadcast::channel('epic-channel.{epic}', function($user, Epic $epic){
    //return (int) $user->id === (int) $id;
    //dd($epic);
    return $epic->project->users->contains($user);
});

//  Broadcast::channel('epic-channel.{id}', function($user, Epic $epic){
//      return $epic->project->users->contains($user);
//  });

Broadcast::channel('project-channel.{project}', function($user, Project $project){
    return $project->users->contains($user);
});


