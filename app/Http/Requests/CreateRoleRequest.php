<?php

namespace App\Http\Requests;

use App\Rules\UniqueRoleName;
use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return $this->user()->hasRole('admin');
        return true;
    }

    protected function prepareForValidation(){}

    // protected function failedAuthorization(){
    //     return response()->json(['error' => 'You do not have the necessary permissions to create a role.'], 403);
    // }

    public function rules()
    {
        return [
            'name' => 'unique:roles,name',
            "title" => ['required', new UniqueRoleName()],
                'permissions' => 'required|array|min:1',
                'permissions.*' => [
                'distinct',
                'exists:permissions,id',
            ],
        ];
    }

    public function messages()
    {
        return [
        'permissions.array' => trans('validation.required'),
        'permissions.min' => trans('messages.you should choose at least one permission'),
        ];
    }
}
