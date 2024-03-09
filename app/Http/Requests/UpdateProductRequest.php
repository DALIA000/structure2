<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Rules\InLangRule;
use App\Rules\MediaRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        $id = $this->id;
        return [
            "locales" => "array",
            "locales.*" =>new InLangRule(),
            'images' => 'array',
            'images.*' => ['exists:media,id', new MediaRule(Product::class, $id)],
            'type' => 'exists:types,id',
            'category' => 'exists:categories,id',
            'amenities' => 'array',
            'amenities.*' => 'exists:amenities,id',
            'community' => 'exists:communities,id',
            'agent' => 'exists:agents,id',
            'developer' => 'exists:developers,id',
            // 'rental_period' => 'required_if:category,4',
            // 'handover_date' => 'required_if:category,1,2,3',
            'furnishing' => 'boolean',
            'status' => 'boolean',
            'brochure' => ['exists:media,id'],
        ];
    }
}
