<?php

namespace App\Http\Requests;

use App\Rules\AdminCurrentPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => 'string',
            "email" => 'unique:admins,email,' . auth()->id(),
            "username" => 'unique:admins,username,' . auth()->id(),
            'current_password' => ['required_with:password', new AdminCurrentPassword()],
            'password' => 'min:8|confirmed',
        ];
    }
}
