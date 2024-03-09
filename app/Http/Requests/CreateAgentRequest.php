<?php

namespace App\Http\Requests;

use App\Models\Agent;
use App\Rules\InLangRule;
use App\Rules\MediaRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAgentRequest extends FormRequest
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
            "locales.*.first_name" => "required|string",
            "locales.*.lang" => "required|string",
            "locales.*.last_name" => "required|string",
            "locales.*.position" => "required|string",
            'service' => 'array',
            'service.*' => 'exists:services,id',
            'image' => ['required', 'exists:media,id', new MediaRule(Agent::class)],
        ];
    }
}
