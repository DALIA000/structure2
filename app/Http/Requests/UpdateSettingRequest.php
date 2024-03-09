<?php

namespace App\Http\Requests;

use App\Models\Setting;
use App\Rules\InLangRule;
use App\Rules\MediaRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            "social" => "array",
            "locales" => "array",
            "locales.*" =>new InLangRule(),
            'image' => ['exists:media,id', new MediaRule(Setting::class)],
            'pdf' => ['exists:media,id', new MediaRule(Setting::class)],
        ];
    }
}
