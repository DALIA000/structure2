<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAdminRequest extends FormRequest
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
            'name' => 'max:255',
            'email' => 'email|unique:admins,email,' . $this->id,
            'username' => 'unique:admins,username,' . $this->id,
            'password' => 'string|min:8|confirmed',
            'role' => 'exists:roles,id',
        ];
    }
}
