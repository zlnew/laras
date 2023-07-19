<?php

namespace App\Http\Requests\RAB;

use Illuminate\Foundation\Http\FormRequest;

class TaxRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            'tax' => 'ppn',
        ];
    }

    public function rules(): array
    {
        return [
            'tax' => ['required', 'numeric', 'max:100'],
            'additional_tax' => ['required', 'numeric', 'max:100'],
        ];
    }
}
