<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'questions_answers' => 'required|array',
            // 'questions_answers.*.locales.en.question' => 'required|string|max:255',
            // 'questions_answers.*.locales.en.answer' => 'required|string|max:255',
            // 'questions_answers.*.locales.ar.question' => 'required|string|max:255',
            // 'questions_answers.*.locales.ar.answer' => 'required|string|max:255',
            // 'questions_answers.*.locales.ru.question' => 'required|string|max:255',
            // 'questions_answers.*.locales.ru.answer' => 'required|string|max:255',
        ];
    }
}
