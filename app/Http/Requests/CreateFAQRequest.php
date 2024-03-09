<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\InLangRule;


class CreateFAQRequest extends FormRequest
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
            "locales.ar" => ['required', new InLangRule()],
            "locales.en" => ['required', new InLangRule()],
            "locales.ru" => ['required', new InLangRule()],
            "locales.*.question" => "required|string",
            "locales.*.answer" => "required|string",
        ];
    }
}
