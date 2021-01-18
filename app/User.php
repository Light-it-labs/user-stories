<?php

namespace App;

use App\Models\UserStory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Project;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

      /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

     public function projects()
     {
         return $this->belongsToMany(Project::class, 'user_project_role')->withPivot('role_id')->withTimestamps();
     }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function has_basic_permissions_to_project(Project $project){
        $project_users_allowed = $project->users()->pluck('user_id')->toArray();

        if(!in_array($this->id, $project_users_allowed)){
            return false;
        }
        return true;
    }

    public function has_full_permissions_to_project(Project $project){
        $project_users_full_permissions = $project->users()->where('role_id', 1)->pluck('user_id')->toArray();

        if(!in_array($this->id, $project_users_full_permissions)){
            return false;
        }
        return true;
    }

    public function can_invite_new_users_to_project($project_id){
        $project = Project::where('id', $project_id)->firstOrFail();

        if(!$this->has_full_permissions_to_project($project)){
            return false;
        }
        return true;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        
        $disk = 'public'; 
        
        $destination_path = "uploads/user_image"; 
        
        if ($value==null) {
        
            \Storage::disk($disk)->delete($this->{$attribute_name});
        
            $this->attributes[$attribute_name] = null;
        }

        if (Str::startsWith($value, 'data:image'))
        {        
            $image = Image::make($value)->encode('jpg', 90);
        
            $filename = md5($value.time()).'.jpg';
        
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
        
            \Storage::disk($disk)->delete($this->{$attribute_name});

            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;
        }
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($model)
        {  
            \Storage::disk('public')->delete($model->image); 
        });
    }
}
