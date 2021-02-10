<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ExistingUserInvitatationRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'invitation_owner' => 'required|email|exists:users,email',
            'project_id' => 'required|exists:projects,id',
        ];
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
