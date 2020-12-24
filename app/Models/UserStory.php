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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

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
}
