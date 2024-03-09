<?php

namespace App\Http\Requests;

use App\Rules\InLangRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CreateRentalPeriodRequest extends FormRequest
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
        // return [
        //     "locales" => "array",
        //     "locales.ar" => ['required', new InLangRule()],
        //     "locales.en" => ['required', new InLangRule()],
        //     "locales.ru" => ['required', new InLangRule()],
        //     "locales.ar.period" => ['required|string|unique:rental_periods,period.ar'],
        //     "locales.en.period" => ['required|string|unique:rental_periods,period.en'],
        //     "locales.ru.period" => ['required|string|unique:rental_periods,period.ru']
        // ];

        return [
            "locales" => "array",
            "locales.ar" => ['required', new InLangRule(), 'unique:rental_periods,period->ar'],
            "locales.en" => ['required', new InLangRule(), 'unique:rental_periods,period->en'],
            "locales.ru" => ['required', new InLangRule(), 'unique:rental_periods,period->ru'],
            "locales.*.period" => 'required|string',
        ];
    }
}
