<?php

namespace App\Http\Requests;

use App\Models\FormImage;
use App\Rules\MediaRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateListImageRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'images' => 'array|min:5|max:5',
            'images.*' => ['exists:media,id', new MediaRule(FormImage::class, 2)],
        ];
    }
}
