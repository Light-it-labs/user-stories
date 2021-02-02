<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;


class UserStory extends Model
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'user_stories';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function epic()
    {
        return $this->belongsTo(Epic::class);
    }

    public function user()
    {
        return $this->belongTo(User::class);
    }

    public function dependencies()
    {
        return $this->belongsToMany(UserStory::class, 'user_stories_dependencies', 'user_story_id', 'user_story_predeccessor_id');
    }


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function get_project_of_user_story(){
        $project = Project::where('id', $this->epic()->first()->project_id)->firstOrFail();
        
        return $project;
        
    }

    public function isAvailableToEdit($user_id)
    {
        if($this->epic()->first()->user_id_editing != null && $this->epic()->first()->user_id_editing != $user_id)
        {
            return false;
        }
        return true;
    }
}
