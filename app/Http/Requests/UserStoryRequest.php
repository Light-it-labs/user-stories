<?php

namespace App\Http\Requests;
use Illuminate\Http\JsonResponse;

use Illuminate\Foundation\Http\FormRequest;

class UserStoryRequest extends FormRequest
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
            'estimate' => ['regex:/^(XXS|XS|S|M|L|XL|XXL)$/'],
            'priority' => 'required|between:1,4',
            'value' => 'required|between:1,4',
            'risk' => 'required|between:1,4',
            'epic_id' => 'required|exists:epics,id',
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
