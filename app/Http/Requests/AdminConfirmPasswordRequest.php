<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminConfirmPasswordRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'token' => 'required|exists:admins,token',
            'password'=> 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'token.required' => 'Token is required',
            'token.exists' => 'Token is invalid',
        ];
    }
}
