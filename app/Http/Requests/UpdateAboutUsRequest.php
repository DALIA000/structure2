<?php

namespace App\Http\Requests;

use App\Models\AboutUs;
use App\Rules\InLangRule;
use App\Rules\MediaRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutUsRequest extends FormRequest
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
            "locales" => "array",
            "locales.*" => new InLangRule(),
            "image" => ['exists:media,id', new MediaRule(AboutUs::class, 1)],
        ];
    }
}
