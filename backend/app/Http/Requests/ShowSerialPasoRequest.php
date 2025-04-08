<?php

namespace App\Http\Requests;


class ShowSerialPasoRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|string|max:128',
            'app_env' => 'required|integer|in:0,1,2',
            'contract_server' => 'required|integer|in:0,1',
        ];
    }
}
