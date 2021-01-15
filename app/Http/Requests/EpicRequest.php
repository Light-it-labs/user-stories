<?php

namespace App\Http\Requests;
use Illuminate\Http\JsonResponse;

use Illuminate\Foundation\Http\FormRequest;

class EpicRequest extends FormRequest
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
            
            'description' => 'required',
            'project_id' => ['required', 'exists:projects,id'],
            'user_stories.*.description' => 'required',
            'user_stories.*.estimate' => ['regex:/^(XXS|XS|S|M|L|XL|XXL)$/'],
            'user_stories.*.priority' => 'required|between:1,4',
            'user_stories.*.value' => 'required|between:1,4',
            'user_stories.*.risk' => 'required|between:1,4',
            
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
