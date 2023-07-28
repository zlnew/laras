<?php

namespace App\Http\Requests\Penagihan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'keperluan' => ['required', 'string', 'max:255'],
        ];
    }
}
