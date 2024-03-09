<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Rules\InLangRule;
use App\Rules\MediaRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            "locales.*.title" => "required|string",
            "locales.*.description" => "required|string",
            "locales.*.address" => "required|string",
            "locales.*.badge" => "required|string",
            'images' => 'array|required',
            'images.*' => ['required', 'exists:media,id', new MediaRule(Product::class)],
            'location.lat' => 'required',
            'location.long' => 'required',
            'type' => 'array',
            'type.*' => 'required|exists:types,id',
            'category' => 'required|exists:categories,id',
            'amenities' => 'array',
            'amenities.*' => 'exists:amenities,id',
            'community' => 'required|exists:communities,id',
            'agent' => 'exists:agents,id',
            'developer' => 'exists:developers,id',
            'price' => 'required',
            'furnishing' => 'boolean',
            'min_size' => 'required',
            'max_size' => 'required'

        ];
    }
}
