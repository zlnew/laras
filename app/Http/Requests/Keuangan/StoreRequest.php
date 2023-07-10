<?php

namespace App\Http\Requests\Keuangan;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Set the attributes for the request
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'id_proyek' => 'proyek',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id_proyek' => ['required', 'exists:proyek,id_proyek'],
            'keperluan' => ['required', 'string', 'max:255'],
        ];
    }
}
