<?php

namespace App\Http\Requests;

use App\Models\Community;
use App\Rules\InLangRule;
use App\Rules\MediaRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommunityRequest extends FormRequest
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
            'locales' => 'array',
            'locales.*.name' => new InLangRule(),
            'image' => 'exists:media,id', new MediaRule(Community::class, $id),
            'status' => 'boolean',
        ];
    }
}
