<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;

class ProjectUpdateRequest extends FormRequest
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
            'name' => ['required', Rule::unique('projects', 'name')->ignore($this->id)],
            'description' => 'required',
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
