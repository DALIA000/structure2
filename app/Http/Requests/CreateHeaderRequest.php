<?php

namespace App\Http\Requests;

use App\Models\Header;
use App\Rules\MediaRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateHeaderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'exists:media,id', new MediaRule(Header::class)],
        ];
    }
}
