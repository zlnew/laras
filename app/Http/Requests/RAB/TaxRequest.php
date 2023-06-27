<?php

namespace App\Http\Requests\RAB;

use Illuminate\Foundation\Http\FormRequest;

class TaxRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'tax' => ['required', 'numeric', 'max:100'],
            'additional_tax' => ['required', 'numeric', 'max:100'],
        ];
    }
}
