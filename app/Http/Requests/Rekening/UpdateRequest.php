<?php

namespace App\Http\Requests\Rekening;

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
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'nama_bank' => ['required', 'string', 'max:255'],
            'nomor_rekening' => ['required', 'numeric'],
            'nama_rekening' => ['required', 'string', 'max:255'],
        ];
    }
}
