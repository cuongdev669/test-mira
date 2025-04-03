<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAccountRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => 'required|string|regex:/^[a-zA-Z0-9]+$/|unique:accounts,login|max:20',
            'password' => 'required|string|min:6|max:40',
            'phone' => [
                "nullable",
                "string",
                "min:6",
                "max:12",
                "regex:#^[0-9\-]{6,12}$#",
            ],
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
            'login.required' => 'Login is a required field.',
            'login.regex' => 'The login field may only contain letters and numbers.',
            'login.unique' => 'This login already exists.',
            'login.max' => 'Login cannot be longer than 20 characters.',
            'password.required' => 'Password is a required field.',
            'password.min' => 'Password must be at least 6 characters long.',
            'password.max' => 'Password cannot be longer than 40 characters.',
            'phone.min' => 'The phone number must be between 6 to 12 characters',
            'phone.max' => 'The phone number must be between 6 to 12 characters',
            'phone.regex' => 'The phone must be between 6 to 12 characters and can only contain numbers and hyphens (-).',
        ];
    }

    /**
     * Passed the data for validation.
     *
     * @return void
     */
    protected function passedValidation(): void
    {
        $key = config('app.key');
        $password_hashed = hash_hmac('sha1', $this->input('password'), $key);
        $this->merge([
            'password' => $password_hashed,
        ]);
    }
}
