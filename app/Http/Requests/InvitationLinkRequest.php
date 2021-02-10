<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Invite;
use App\Models\Project;

class InvitationLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'project_id' => 'required|exists:projects,id',
        ];
    }

    protected function withValidator(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $validator->after(function ($validator)
        {
            if(Invite::where('email', $this->email)
                    ->where('project_id', $this->project_id)
                    ->exists()){

                $validator->errors()->add('email', 'A invitation for this project to this email already exists!');
            }    

            $project = Project::findOrFail($this->project_id);

            if($project->whereHas('users', function($user){
                $user->where('email', $this->email);
            })->exists()){

                $validator->errors()->add('email', 'This user is already working on the project');
            }    
        
        });

        
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $val)
    {
        $response = new JsonResponse([
            'success' => false,
            'errors' => $val->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($val, $response);
    }
}
