<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Project extends Model
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'projects';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function epics()
    {
        return $this->hasMany(Epic::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_project_role')->withPivot('role_id')->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
}
