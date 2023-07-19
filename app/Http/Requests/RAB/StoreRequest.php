<?php

namespace App\Http\Requests\RAB;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            'id_proyek' => 'proyek'
        ];
    }

    public function rules(): array
    {
        return [
            'id_proyek' => ['required', 'string', 'unique:rab,id_proyek', 'exists:proyek,id_proyek']
        ];
    }
}
