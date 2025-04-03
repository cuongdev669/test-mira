<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SearchAccountRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => 'nullable',
            'phone' => 'nullable',
            'created_at_from' => 'nullable|date_format:Y-m-d',
            'created_at_to' => 'nullable|date_format:Y-m-d',
        ];
    }

    /**
     * Custom error messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'created_at_from.date_format' => 'The created at from field must be in the format YYYY-MM-DD.',
            'created_at_to.date_format' => 'The created at to field must be in the format YYYY-MM-DD.',
        ];
    }
}
