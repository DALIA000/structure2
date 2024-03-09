<?php

namespace App\Http\Requests;

use App\Models\Service;
use App\Rules\InLangRule;
use App\Rules\MediaRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'image' => ['exists:media,id', new MediaRule(Service::class, $id)],
        ];
    }
}
