<?php

namespace App\Http\Requests;

class UpdateAccountRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $registerID = $this->route('account');
        return [
            'login' => 'required|string|regex:/^[a-zA-Z0-9]+$/|unique:accounts,login,' . $registerID . ',registerID|max:20',
            'password' => 'nullable|string|min:6|max:40',
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
    public function messages()
    {
        $createRequest = new CreateAccountRequest();
        $msg = $createRequest->messages();
        unset($msg["password.required"]);
        return $msg;
    }

    /**
     * Passed the data for validation.
     *
     * @return void
     */
    protected function passedValidation(): void
    {
        if ($this->has('password')) {
            $key = config('app.key');
            $password_hashed = hash_hmac('sha1', $this->input('password'), $key);
            $this->merge([
                'password' => $password_hashed,
            ]);
        }
    }
}
