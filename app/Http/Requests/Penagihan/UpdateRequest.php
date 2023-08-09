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
            'id_proyek' => ['required', 'exists:proyek,id_proyek'],
            'keperluan' => ['required', 'string', 'max:255'],
            'kas_masuk' => ['required', 'string', 'max:255']
        ];
    }
}
