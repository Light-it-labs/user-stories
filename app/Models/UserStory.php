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
    protected $touches = ['epic'];

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

    public function calculateCategory()
    {
        if(($this->value === 1 or $this->value === 2) and ($this->risk === 1 or $this->risk === 2) ){
            $this->category = "Strategic";
        }else if (($this->value === 1 or $this->value === 2) and ($this->risk === 3 or $this->risk === 4)){
            $this->category = "Leveraged";
        }else if (($this->value === 3 or $this->value === 4) and ($this->risk === 1 or $this->risk === 2)){
            $this->category = "Focused";
        }else if(($this->value === 3 or $this->value === 4) and ($this->risk === 3 or $this->risk === 4)){
            $this->category = "Routine";
        }else{
            $this->category = "";
        }

    }

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
