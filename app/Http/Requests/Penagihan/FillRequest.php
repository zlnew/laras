<?php

namespace App\Http\Requests\Penagihan;

use Illuminate\Foundation\Http\FormRequest;

class FillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
          'id_rekening' => 'rekening'
        ];
    }

    public function rules(): array
    {
        return [
            'id_rekening' => ['nullable', 'exists:rekening,id_rekening'],
            'nomor_sp2d' => ['nullable', 'string', 'max:255'],
            'tanggal_sp2d' => ['nullable', 'date'],
            'tanggal_terbit' => ['nullable', 'date'],
            'tanggal_cair' => ['nullable', 'date'],
        ];
    }
}
